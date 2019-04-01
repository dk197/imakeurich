<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userstatistics;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user_id = $id;
        $user = User::find($user_id);
        $userstats = DB::table('Userstatistics')->where('user_id',$user_id)->get();
        $count = 0;
        foreach ($userstats as $some)
        {
            $count++;
        }

        return view('user.index')->with('user',$user)->with('countbids',$count);
    }

    public function addToBalance(Request $request)
    {
        $coins = $request->input('coins');
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->balance = $user->balance + $coins;
        $user->save();
        return response()->json(['message' => $coins.' Coins successfully added.', 'coins' => $user->balance]);
    }

    public function removeFromBalance(Request $request)
    {
        $coins = $request->input('coins');
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->balance = $user->balance - $coins;
        $user->save();
        return response()->json(['message' => $coins.' Coins successfully donated.', 'coins' => $user->balance]);
    }

    public function coins()
    {
        return view('coins');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
