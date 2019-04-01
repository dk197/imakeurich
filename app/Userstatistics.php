<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userstatistics extends Model
{
    protected $fillable = [
        'game_id',	'user_id',	'username',	'value',	'isBid'

    ];


}
