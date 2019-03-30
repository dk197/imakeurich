<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Game;
use App\Player;
use Pusher\Pusher;

class Game extends Model
{
    protected $fillable = [
        'min_bid', 'max_bid', 'single_bid', 'game_end', 'win_1', 'win_2', 'win_3', 'max_players',
    ];

    public function player(){
    	return $this->hasMany(Player::class)->orderBy('bid', 'DESC');;
    }

    public function addPlayer($bid){

    	$user = auth()->user();


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

            $data = ([
                'game_id' => $this->id,
                'bid' => $bid,
                'user_id' => $user->id,
                'username' => $user->username
            ]);
            
            $pusher->trigger('player_enter', 'player_enter-event', $data);  

        // ################# Pusher end ###############################


    	return Player::create([
    		'user_id' => $user->id,
    		'username' => $user->username,
    		'game_id' => $this->id,
    		'bid' => $bid
    	]);
    }

    public function updatePlayerBid($bid, $game){
        
        $user = auth()->user();


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

            $data = ([
                'game_id' => $game->id,
                'bid' => $bid,
                'user_id' => $user->id,
                'username' => $user->username
            ]);
            
            $pusher->trigger('player_update', 'player_update-event', $data);  

        // ################# Pusher end ###############################

        
        Player::where(['user_id' => $user->id, 'game_id' => $game->id])->update(['bid' => DB::raw('bid +'.$bid)]);
    }
}
