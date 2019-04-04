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
        'min_bid', 'igw_limit', 'win_1', 'win_2', 'win_3', 'max_players',
    ];

    public function player(){
    	return $this->hasMany(Player::class)->orderBy('bid', 'DESC');
    }

    public function addPlayer($bid){

    	$user = auth()->user();

    	$result = Player::create([
    		'user_id' => $user->id,
    		'username' => $user->username,
    		'game_id' => $this->id,
    		'bid' => $bid
    	]);

        //the position of the player in the game
        $position = $this->getPlayerPosition($this->id, $result->id) + 1;

        
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
                'game_id' => $this->id
            ]);
            
            $pusher->trigger('player_change', 'player_change-event', $data);  

        // ################# Pusher end ###############################

    }

    public function updatePlayerBid($bid, $game){
        
        $user = auth()->user();

        //get Entry which will get updated
        $result = Player::where(['user_id' => $user->id, 'game_id' => $game->id]);

        // convert the Entry-Object to an array before updating
        $result_array = $result->get()->toArray();

        //the position of the player in the game after updating
        $previous_position = $this->getPlayerPosition($game->id, $result_array[0]['id']) + 1;

        // update the Entry
        $result->update(['bid' => DB::raw('bid +'.$bid)]);

        // convert the Entry-Object to an array after updating
        $result_array = $result->get()->toArray();

        //the position of the player in the game after updating
        $position = $this->getPlayerPosition($game->id, $result_array[0]['id']) + 1;


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
                'game_id' => $this->id
            ]);
            
            $pusher->trigger('player_change', 'player_change-event', $data);   

        // ################# Pusher end ###############################

    }

    //get the Position of the Player based on his bid
    public function getPlayerPosition($game_id, $player_id){
        $all_players = DB::table('players')->where(['game_id' => $game_id])->orderBy('bid', 'DESC')->get()->toArray();

        //search for the player ID in the Array of all Player of the selected game and get the index (that array is descending ordered by the Bid)
        $key = array_search($player_id, array_column($all_players, 'id'));

        return $key;
    }
}
