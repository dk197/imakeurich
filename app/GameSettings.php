<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameSettings extends Model
{
    protected $fillable = [
        'min_bid', 'max_bid', 'single_bid', 'game_end', 'win_1', 'win_2', 'win_3', 'max_players',
    ];
}
