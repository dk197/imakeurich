<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Game;
use App\Player;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Userstatistics;
use App\User;

class GameController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();

        return view('game.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $attributes = request()->validate([
            'min_bid' => ['required', 'min:1', 'numeric'],
            'igw_limit' => ['required', 'min:1', 'numeric'],
            'max_players' => ['required', 'min:1', 'numeric']
        ]);

        //$this, da Funktion nicht global sichtbar ist
        $winning_places = $this->setWinningPlaces($attributes['max_players']);

        $attributes['game_end'] = Carbon::now()->toDateTimeString();
        $attributes['win_1'] = $winning_places[0];
        $attributes['win_2'] = $winning_places[1];
        $attributes['win_3'] = $winning_places[2];

        Game::create($attributes);

        return redirect('/games');
    }

    function setWinningPlaces($max_players)
    {
        $winning_places = [];

        while (sizeof($winning_places) < 3) {
            $random = rand(2, $max_players - 1);
            if(!in_array($random, $winning_places)){
                array_push($winning_places, $random);
            }
            $random = '';
        }
        return $winning_places;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        // mehrere entries pro user bei einem game! -> update entry
        $player_number = $this->getPlayerNumber($game);

        // dd($player_number);
        return view('game.show', compact('game', 'player_number'));
    }

    public function getGameData(Game $game)
    {
        return DB::table('players')->where(['game_id' => $game->id])->orderBy('bid', 'DESC')->get()->toArray();
    }

    public function joinGame(Game $game)
    {

    }

    public function enter(Game $game)
    {

        $bid = request()->game_bid;

        $currentuser = auth()->user();


        // check if game is full and user is not a player
        if($this->getPlayerNumber($game) == $game->max_players && !$this->findPlayer($currentuser->id, $game->id)){

            return response()->json(['message' => 'Game is full!']);

        // game is full and user is a player
        }else if($this->getPlayerNumber($game) == $game->max_players && $this->findPlayer($currentuser->id, $game->id)){

            if($bid < $game->min_bid || $bid > $game->igw_limit){
                return response()->json(['message' => 'Bid not in allowed area!']);
            }else{

                $userstat = new Userstatistics;
                $userstat->game_id = $game->id;
                $userstat->user_id = $currentuser->id;
                $userstat->username = $currentuser->username;
                $userstat->value = $bid;
                $userstat->isBid = true;
                $userstat->save();

                // Player has bid for this game already
                $game->updatePlayerBid($bid, $game);

                if($this->getAllGameBids($game->id) >= $game->igw_limit){
                    $this->endGame($game);
                }

                $UserClass = new User;
                $newBalance = json_decode($UserClass->changeBalance($bid));

                return response()->json(['message' => 'You Bid successfully', 'newBalance' => $newBalance->balance]);
            }

        // game isn't full and user is not a player
        }else if($this->getPlayerNumber($game) < $game->max_players && !$this->findPlayer($currentuser->id, $game->id)){

            $userstat = new Userstatistics;
            $userstat->game_id = $game->id;
            $userstat->user_id = $currentuser->id;
            $userstat->username = $currentuser->username;
            $userstat->value = $bid;
            $userstat->isBid = true;
            $userstat->save();

            // Add User to the game with the min bid
            $game->addPlayer($game->min_bid);

            // subtract min bid (for joining the game) from user balance
            $UserClass = new User;
            $newBalance = json_decode($UserClass->changeBalance($game->min_bid));

            return response()->json(['message' => 'Game successfully entered with the min Bid'.$newBalance->balance, 'newBalance' => $newBalance->balance]);

        // game isn't full & user is a player
        }else if($this->getPlayerNumber($game) < $game->max_players && $this->findPlayer($currentuser->id, $game->id)){

            return response()->json(['message' => 'Please wait, until the lobby is full!']);

        }else{
            return response()->json(['message' => 'Unknown error, please contact the ImakeYouRich-Team']);
        }

    }

    // get amount of players of a game
    public function getPlayerNumber($game){
        return DB::table('players')->where(['game_id' => $game->id])->count();
    }

    // public function getPlayerBids($game_id){
    //     return DB::table('players')->where(['game_id' => $game_id, 'user_id' => auth()->user()->id])->count();
    // }

    // check, if user is a player of a specific game -> true, if given user is a player in the given game
    public function findPlayer($user_id, $game_id)
    {
        $result = Player::where(['game_id' => $game_id, 'user_id' => $user_id])->count();

        if($result == 0){
            return false;
        }else{
            return true;
        }
    }

    // get the value of all bids
    public function getAllGameBids($game_id)
    {
        return DB::table('players')->where(['game_id' => $game_id])->sum('bid');
    }

    // get the winners
    public function getWinners($game)
    {
        $allPlayers = DB::table('players')->where(['game_id' => $game->id])->orderBy('bid', 'DESC')->get()->toArray();

        // array starts at 0 -> winner would be wrong
        $win_index_0 = 0;
        $win_index_1 = $game->win_1 - 1;
        $win_index_2 = $game->win_2 - 1;
        $win_index_3 = $game->win_3 - 1;


        $winner_0 = $allPlayers[$win_index_0]->user_id;
        $winner_1 = $allPlayers[$win_index_1]->user_id;
        $winner_2 = $allPlayers[$win_index_2]->user_id;
        $winner_3 = $allPlayers[$win_index_3]->user_id;


        $winners = array(
            'winner_0' => $winner_0,
            'winner_1' => $winner_1,
            'winner_2' => $winner_2,
            'winner_3' => $winner_3
        );

        return $winners;
    }

    public function endGame($game){

        // ################# Pusher start #############################

            $options = array(
                'cluster' => 'eu'
            );

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $winners = array(
                'winner_0' => $this->getWinners($game)['winner_0'],
                'winner_1' => $this->getWinners($game)['winner_1'],
                'winner_2' => $this->getWinners($game)['winner_2'],
                'winner_3' => $this->getWinners($game)['winner_3']
            ); 

            $data = array(
                'game_id' => $game->id,
                'winners' => $winners
            );

            $pusher->trigger('game_end', 'game_end-event', $data);

        // ################# Pusher end ###############################

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
