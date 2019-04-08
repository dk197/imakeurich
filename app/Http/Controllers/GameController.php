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
        $games = Game::orderBy('igw_limit', 'DESC')->get();

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
        $player_number = $this->getPlayerNumber($game);

        // dd($player_number);
        return view('game.show', compact('game', 'player_number'));
    }

    public function getGameData(Game $game)
    {
        $data = DB::table('players')->select('user_id', 'username', 'game_id')->where(['game_id' => $game->id])->orderBy('bid', 'DESC')->get()->toArray();

        return response()->json(['data' => $data, 'player_number' => $this->getPlayerNumber($game)]);
    }

    public function enter(Game $game)
    {

        $bid = request()->game_bid;

        $currentuser = auth()->user();

        // check if game is full and user is not a player
        if($this->getPlayerNumber($game) == $game->max_players && !$this->findPlayer($currentuser->id, $game->id)){

            return response()->json(['message' => 'Game is full!']);

        // game isn't full & user is a player
        }else if($this->getPlayerNumber($game) < $game->max_players && $this->findPlayer($currentuser->id, $game->id)){

            return response()->json(['message' => 'Please wait, until the lobby is full!']);


        // game is full and user is a player
        }else if($this->getPlayerNumber($game) == $game->max_players && $this->findPlayer($currentuser->id, $game->id)){

            if($bid < $game->min_bid){
                return response()->json(['message' => 'Bid not in allowed area!']);
            }else if($bid > $this->getUserBalance($currentuser->id)){
                return response()->json(['message' => 'You dont have enough Coins!']);
            }else{

                $userstat = new Userstatistics;
                $userstat->game_id = $game->id;
                $userstat->user_id = $currentuser->id;
                $userstat->username = $currentuser->username;
                $userstat->value = $bid;
                $userstat->isBid = true;
                $userstat->save();

                $game->updatePlayerBid($bid, $game);

                if($this->getPot($game->id) >= $game->igw_limit){
                    $this->endGame($game);
                }

                $UserClass = new User;
                $newBalance = json_decode($UserClass->changeBalance(- $bid, $currentuser->id));

                return response()->json(['message' => 'You Bid successfully', 'newBalance' => $newBalance->balance]);
            }

        // game isn't full and user is not a player
        }else if($this->getPlayerNumber($game) < $game->max_players && !$this->findPlayer($currentuser->id, $game->id)){

            if($game->min_bid > $this->getUserBalance($currentuser->id)){
                return response()->json(['message' => 'You dont have enough Coins!']);
            }else{
                $userstat = new Userstatistics;
                $userstat->game_id = $game->id;
                $userstat->user_id = $currentuser->id;
                $userstat->username = $currentuser->username;
                $userstat->value = $game->min_bid;
                $userstat->isBid = true;
                $userstat->save();

                // Add User to the game with the min bid
                $game->addPlayer($game->min_bid);

                // check if game is full now
                if($this->getPlayerNumber($game) == $game->max_players){
                    DB::table('games')->where('id', $game->id)->update(['game_status' => "started"]);                }

                // subtract min bid (for joining the game) from user balance
                $UserClass = new User;
                $newBalance = json_decode($UserClass->changeBalance(- $game->min_bid, $currentuser->id));

                return response()->json(['message' => 'Game successfully entered with the min Bid', 'newBalance' => $newBalance->balance]);
            }

        }else{
            return response()->json(['message' => 'Unknown error, please contact the ImakeYouRich-Team']);
        }
    }

    public function getUserBalance($user_id){
        return DB::table('users')->where(['id' => $user_id])->value('balance');
    }

    // get amount of players of a game
    public function getPlayerNumber($game){
        return DB::table('players')->where(['game_id' => $game->id])->count();
    }

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
    public function getPot($game_id)
    {
        return DB::table('players')->where(['game_id' => $game_id])->sum('bid');
    }

    // get the userIDs of the winners
    public function getWinners($game)
    {
        $allPlayers = DB::table('players')->where(['game_id' => $game->id])->orderBy('bid', 'DESC')->get()->toArray();

        // -1 cause the array starts at 0
        $winner_1 = $allPlayers[0]->user_id;
        $winner_2 = $allPlayers[$game->win_1 - 1]->user_id;
        $winner_3 = $allPlayers[$game->win_2 - 1]->user_id;
        $winner_4 = $allPlayers[$game->win_3 - 1]->user_id;


        $winners = array(
            'winner_1' => $winner_1,
            'winner_2' => $winner_2,
            'winner_3' => $winner_3,
            'winner_4' => $winner_4
        );

        return $winners;
    }

    // calculate the earnings
    public function getEarnings($game_id)
    {
        $pot = $this->getPot($game_id);

        $earnings = array(
            'win_1' => floor(0.5 * $pot),
            'win_2' => floor(0.1 * $pot),
            'win_3' => floor(0.1 * $pot),
            'win_4' => floor(0.1 * $pot)
        );

        return $earnings;
    }

    // set endGame event with some data
    public function endGame($game){

        $winner_ids = array(
            '0' => $this->getWinners($game)['winner_1'], 
            '1' => $this->getWinners($game)['winner_2'], 
            '2' => $this->getWinners($game)['winner_3'], 
            '3' => $this->getWinners($game)['winner_4']
        );

        //get Usernames based on their IDs
        $winners = array(
            '0' => User::find($winner_ids[0])->username,
            '1' => User::find($winner_ids[1])->username,
            '2' => User::find($winner_ids[2])->username,
            '3' => User::find($winner_ids[3])->username
        ); 

        $earnings = array(
            '0' => $this->getEarnings($game->id)['win_1'],
            '1' => $this->getEarnings($game->id)['win_2'],
            '2' => $this->getEarnings($game->id)['win_3'],
            '3' => $this->getEarnings($game->id)['win_4']
        );

        // add user statistics and IGW to the users
        for ($i=0; $i < count($winners); $i++) { 
            $userstat = new Userstatistics;
            $userstat->game_id = $game->id;
            $userstat->user_id = $winner_ids[$i];
            $userstat->username = $winners[$i];
            $userstat->value = $earnings[$i];
            $userstat->isBid = false;
            $userstat->save();

            $UserClass = new User;
            $newBalance = json_decode($UserClass->changeBalance($earnings[$i], $winner_ids[$i]));
        }

        $data = array(
            'game_id' => $game->id,
            'winners' => $winners,
            'earnings' => $earnings
        );

        $game->makePusherEvent($data, 'game_end');

        DB::table('players')->where(['game_id' => $game->id])->delete();
        DB::table('games')->where('id', $game->id)->update(['game_status' => "pending"]);
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
