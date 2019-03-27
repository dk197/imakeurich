@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
		<h1>{{ $game->single_bid === 1 ? "Single Bid" : "Multi Bid"}}</h1>
	</div>
	<div class="col-4">
		<p>Spieler {{ $player_number }}/{{ $game->max_players }}</p>
	</div>
	<div class="col-4">
		<p>Winning Places: {{ $game->win_1 }}, {{ $game->win_2 }}, {{ $game->win_3 }}</p>
	</div>
	<div class="col-4">
		<p>Game ending: {{ $game->game_end }}</p>
	</div>
	
</div>

<div class="row">
	<form method="POST" action="/games/{{ $game->id }}/enter">
		@csrf
		<div class="form-group">
			<label for="game_bid">How much money do you wanna drop in?</label>
			<input type="number" name="game_bid" id="game_bid" class="form-control" placeholder="Amount of IGW u wanna spend">
		</div>
		<button type="submit" class="btn btn-primary">GO IN</button>
	</form>
</div>

<div class="row">
	<ul>
		@foreach($game->player as $player)
			<li>{{ $player->username }} {{ $player->bid }}</li>
		@endforeach
	</ul>
</div>
@endsection