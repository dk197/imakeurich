@extends('layouts.app')

@section('content')

<h1>Multi Bid Millionaire</h1>

<div class="row mt-4">
    <div class="col-md-12 row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Game Data</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <p id="player_number">Player: {{ $player_number }}/{{ $game->max_players }}</p>
                        </div>
                        <div class="col-4 text-center">
                            <p>Minimal bid: {{ $game->min_bid }} Coins | Pot limit: {{ $game->igw_limit }} coins</p>
                        </div>
                        <div class="col-4 text-right">
                            <p>Winning Places: 1, {{ $game->win_1 }}, {{ $game->win_2 }}, {{ $game->win_3 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12 row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Join the Game</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="/games/{{ $game->id }}/enter" id="player_enter_form">
                                @csrf
                                <div class="form-group">
                                    <label for="game_bid">How much coins do you wanna drop in?</label>
                                    <input type="number" name="game_bid" id="game_bid" class="form-control" placeholder="Amount of coins u wanna spend">
                                </div>
                                <button type="submit" style="margin-top:20px;" class="btn button-gold enter-button">GO IN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12 row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Player's List</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <!-- <ul>
                                @foreach($game->player as $player)
                                    <li>{{ $player->username }} {{ $player->bid }}</li>
                                @endforeach
                            </ul>-->
                            <table class="table" id="player_table">
                                <tbody>
                                    @foreach($game->player as $player)
                                        <tr>
                                            <th class="col_1" scope="row" style="width: 33%">{{ $loop->iteration }}.</th>
                                            <td class="text-center col_2" style="width: 33%">{{ $player->username }} ({{ $player->bid }})</td>
                                        <td class="text-right col_3" style="width: 33%"><a href="/user/{{$player->id}}">Show profile</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="game_end_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Guess who's rich now? Right, it's...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center" id="modal_winners">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
