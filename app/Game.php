<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;

class Game extends Model
{
    protected $fillable = [
        'min_bid', 'max_bid', 'single_bid', 'game_end', 'win_1', 'win_2', 'win_3', 'max_players',
    ];

    public function player(){
    	return $this->hasMany(Player::class);
    }

    public function addPlayer($bid){

    	$user = auth()->user();

    	return Player::create([
    		'user_id' => $user->id,
    		'username' => $user->username,
    		'game_id' => $this->id,
    		'bid' => $bid
    	]);
    }
}
