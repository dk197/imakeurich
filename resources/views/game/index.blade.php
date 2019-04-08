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
                    <div class="row ">
                    <div class="col-4">
                            <i class="fas fa-coins game-icon"></i>Min bid: {{ $game->min_bid }}
                        </div>
                        <div class="col-4 text-center">
                            <i class="fas fa-sort-amount-up game-icon"></i>Pot limit: {{ $game->igw_limit }}
                        </div>
                        <div class="col-4 text-right">
                            <i class="fas fa-user-tie game-icon"></i>Max Players: {{ $game->max_players }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach


@endsection
