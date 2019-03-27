@extends('layouts.app')

@section('content')
<div class="row">
	<h1>{{ $game->single_bid === 1 ? "Single Bid" : "Multi Bid"}}</h1>
</div>

<div class="row">
	<form method="POST" action="/games//enter">
		@csrf
		<div class="form-group">
			<label for="game_bid">How much money do you wanna drop in?</label>
			<input type="number" name="game_bid" id="game_bid" class="form-control" placeholder="Amount of IGW u wanna spend">
		</div>
		<button type="submit" class="btn btn-primary">GO IN</button>
		<h1>{{ $game->id }}yx</h1>
	</form>
</div>
@endsection