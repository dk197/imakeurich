@extends('layouts.app')

@section('content')

<h1>Create new Game</h1>


	<form id="create_game_form" action="/games" method="POST">
		@csrf
		<div class="form-group">
			<label for="game_min_bid">Min Bid</label>
			<input type="number" name="min_bid" id="game_min_bid" class="form-control" placeholder="Min Bid for this game">
		</div>

		<div class="form-group">
			<label for="game_max_bid">IGW Limit</label>
			<input type="number" name="igw_limit" id="game_igw_limit" class="form-control" placeholder="Max amount of IGW for this game">
		</div>

		<div class="form-group">
			<label for="game_max_players">Max Players of the game</label>
			<input type="number" name="max_players" id="game_max_players" class="form-control" placeholder="Max Players of the game (min 5)">
		</div>

		<button type="submit" class="btn button-purple">Create</button>
	</form>


@endsection
