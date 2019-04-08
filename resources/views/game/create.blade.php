@extends('layouts.app')

@section('content')

<h1>Create new Game</h1>

<div class="col-md-12 row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Enter game data</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <form id="create_game_form" action="/games" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="game_min_bid">Min Bid</label>
                                    <input type="number" name="min_bid" id="game_min_bid" class="form-control" placeholder="Min Bid for this game">
                                </div>

                                <div class="form-group">
                                    <label for="game_max_bid">Pot Limit</label>
                                    <input type="number" name="igw_limit" id="game_igw_limit" class="form-control" placeholder="Max amount of coins for this game">
                                </div>

                                <div class="form-group">
                                    <label for="game_max_players">Max Players of the game</label>
                                    <input type="number" name="max_players" id="game_max_players" class="form-control" placeholder="Max Players of the game (min 5)">
                                </div>
                                <div style="margin-top:40px;">
                                    <button type="submit" class="btn button-purple">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
