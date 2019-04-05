@extends('layouts.app')

@section('content')


<h1>All Games</h1>
<a class="btn btn-block button-purple" href="/games/create">Create new Game</a>

<div class="row">
    <div class="col-md-12 all-games">

		@foreach($games as $game)

			<div class="col-md-4 card" id="game_card" onclick="location.href='/games/{{ $game->id }}'">
				<div class="card-body game-card-body">
					<h5 class="card-title text-center">{{  $game->single_bid === 1 ? "Single Bid" : "Multi Bid" }}</h5>
					<ul id="game_list">
						<li>Min bid: {{ $game->min_bid }}</li>
						<li>Max bid: {{ $game->max_bid }}</li>
						<li>Max Players: {{ $game->max_players }}</li>
					</ul>
				</div>
			</div>

        @endforeach
    </div>

</div>

@endsection
