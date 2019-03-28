<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Game;
use App\Player;
use Carbon\Carbon;

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
            'max_bid' => ['required', 'min:1', 'numeric'],
            'game_end' => ['required', 'min:1'],
            'single_bid' => ['required', 'min:0', 'max:1', 'numeric'],
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
            $random = rand(2, $max_players); 
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
        $player_number = DB::table('players')->where(['game_id' => $game->id])->count();
        
        // dd($player_number);
        return view('game.show', compact('game', 'player_number'));
    }

    public function enter(Game $game)
    {
        $bid = request()->game_bid;

        // dd($game);
        $game->addPlayer($bid);
        
        return redirect()->back();
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
