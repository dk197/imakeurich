<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userstatistics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['allstatistics']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        if(auth()->user() != null){
        $user_id = $id;
        $user = User::find($user_id);
        $userstats = DB::table('Userstatistics')->where('user_id',$user_id)->get();
        $count = 0;
        $coinsbid = 0;
        $coinswon = 0;
        foreach ($userstats as $some)
        {
            if($some->isBid == 1){
                $coinsbid = $coinsbid + $some->value;
                $count++;
            }else{
                $coinswon = $coinswon + $some->value;
            }
        }
        return view('user.index')->with('user',$user)->with('countbids',$count)->with('coinsbid',$coinsbid)->with('coinswon',$coinswon);
        }else{
            return redirect(getenv("HTTP_REFERER"));
        }
    }

    public function allstatistics()
    {
        $userstats = DB::table('Userstatistics')->get();
        $gamesplayed = DB::table('Userstatistics')->max('game_id');
        $countbids = 0;
        $coinsbid = 0;
        $coinswon = 0;
        foreach ($userstats as $some)
        {
            if($some->isBid == 1){
                $coinsbid = $coinsbid + $some->value;
                $countbids++;
            }else{
                $coinswon = $coinswon + $some->value;
            }
        }
        return view('user.allstatistics')->with('gamesplayed',$gamesplayed)->with('countbids',$countbids)->with('coinsbid',$coinsbid)->with('coinswon',$coinswon);
    }

    public function addToBalance(Request $request)
    {   
        $user_id = auth()->user()->id;
        $coins = $request->input('coins');
        $UserClass = new User;
        $newBalance = json_decode($UserClass->changeBalance($coins, $user_id));

        return response()->json(['message' => 'Success: Your Balance now: '.$newBalance->balance , 'coins' => $newBalance->balance]);
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
        $user_id = $id;
        $user = User::find($user_id);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $password = $request->input('password');
        $user->password = Hash::make($password);
        $user->save();
        $redirectPage = "/user"."/".$id;
        return redirect($redirectPage);
    }

    public function showEditPage()
    {
        if(auth()->user() != null){
            return view('user/editUser');
        }else{
            return redirect(getenv("HTTP_REFERER"));
        }
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
