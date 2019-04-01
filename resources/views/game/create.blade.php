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
			<label for="game_max_bid">Max Bid</label>
			<input type="number" name="max_bid" id="game_max_bid" class="form-control" placeholder="Max Bid for this game">
		</div>

		<div class="form-group">
			<label class="radio-inline mr-1"><input type="radio" checked class="mr-1" value="1" name="single_bid">Single Bid</label>
			<label class="radio-inline"><input type="radio" class="mr-1" value="0" name="single_bid">Multi Bid</label>
		</div>

		<div class="form-group">
			<label for="game_end">Game end</label>
			<input type="number" name="game_end" id="game_end" class="form-control" placeholder="Minutes after the game ends">
		</div>

		<div class="form-group">
			<label for="game_max_players">Max Players of the game</label>
			<input type="number" name="max_players" id="game_max_players" class="form-control" placeholder="Max Players of the game (min 5)">
		</div>

		<button type="submit" class="btn btn-primary">Create</button>
	</form>


@endsection
