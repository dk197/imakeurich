<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'user_id', 'username', 'game_id', 'bid',
    ];

    public function Game(){
    	return $this->belongsTo(Game::class);
    }
}
