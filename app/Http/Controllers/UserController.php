<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    function addToBalance($coins)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->balance = $user->balance + $coins;
        $user->save();
        return $user->balance;
    }
}
