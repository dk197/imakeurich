@extends('layouts.app')

@section('content')


<h1>All Games</h1>
<div class="col-md-12 all-games">
    <a class="btn btn-block button-purple" href="/games/create">Create new Game</a>
</div>

    @foreach($games as $game)
    <div class="row">
        <div class="col-md-12 all-games">
            <div class="card game_card game-card" onclick="location.href='/games/{{ $game->id }}'">
                <div class="card-header text-center">Multi Bid Millionaire</div>
                <div class="card-body">
                    <ul id="game_list">
                        <li>Min bid: {{ $game->min_bid }}</li>
                        <li>Max bid: {{ $game->igw_limit }}</li>
                        <li>Max Players: {{ $game->max_players }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @endforeach


@endsection
