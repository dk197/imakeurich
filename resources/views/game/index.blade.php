@extends('layouts.app')

@section('content')


<h1>All Games</h1>

<div class="row">
	<ul>

		@foreach($games as $game)

			<div class="card" style="width: 18rem;">
				<div class="card-body">
					<li> Min bid: {{ $game->min_bid }}</li>
					<li>Max bid: {{ $game->max_bid }}</li>
					<li>Max Players: {{ $game->max_players }}</li>
				</div>
			</div>

		@endforeach

	</ul>
</div>

@endsection