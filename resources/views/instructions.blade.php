@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>This is how it works. How to get rich.</h1>
            <div class="col-md-12 row justify-content-center ">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center mt-4">
                Our expert tips & tricks on how to get rich
            </div>
            <div class="card-body">
                <ul>
                    <li>It doesnt have to be always the first place to get rich</li>
                    <li>Sometimes it helps to wait, but its also risky</li>
                    <li>Bait a bit with Bids</li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-center mt-4">
            Multi bid millionaire
            </div>
            <div class="card-body">
            Different lobbies with different minimum stakes are available. Player A enters a lobby with a minimum bet of x coins (in-game currency). Before the start, in addition to the first place, which receives 50% of all bids, the four other winning places, which each receive 10%, are drawn. Important: The last place cannot be chosen randomly. The game starts as soon as the lobby is full, each player automatically places the minimum bet. Now each player can place any bets (also under the minimum bet) and see on the right by means of a scoreboard on which place he is at the moment (but without knowing the exact distances). The game ends as soon as a bid breaks the maximum target, e.g. 500 coins of total bets. The proceeds, in this case just over 500 coins, are then distributed to the players in the correct positions.
        </div>
        <!-- <div class="card">
            <div class="card-header text-center mt-4">
            Für unsere deutschen Kunden: Multi Bid Millionaire
            </div>
            <div class="card-body">
            Es sind verschiedene Lobbys mit unterschiedlich hohen Mindesteinsätzen verfügbar. Spieler A betritt eine Lobby mit Mindesteinsatz x Coins (InGameWährung). Vor Start werden neben dem ersten Platz, der 50% aller Bids erhält, die vier weiteren Gewinnplätze ausgelost, die jeweils 10 % erhalten. Wichtig: Der letzte Platz kann nicht zufällig ausgewählt werden. Das Spiel startet, sobald die Lobby voll ist, jeder Spieler setzt automatisch minestens den Mindesteinsatz. Nun kann jeder Spieler beliebig Einsätze setzen ( auch unter dem Mindesteinsatz ) und rechts anhand eines Scoreboards sehen, auf welchem Platz er sich im Moment befindet ( ohne aber die genauen Abstände zu kennen ). Das Spiel endet, sobald mit einem Bid das Maximalziel, also z.B 500 Coins Gesamteinsätze durchbrochen werden. Der Erlös, in diesem Fall also knapp über 500 Coins wird dann auf die Spieler auf den richtigen Positionen verteilt.
        </div> -->

        <div class="card">
            <div class="card-header text-center mt-4">
            Important informations
            </div>
            <div class="card-body">
            You have to be 18 years or older to gamble. Gambling can be addictive. More information at <a style="color: #efba1a;" href="https://www.responsiblegambling.org">responsiblegambling.org</a> or by calling the free hotline 0800 137 27 00.
        </div>
        <div class="links flex-center">
                    <a class="btn button-start" href="/games">Really! Let's get started!</a>
        </div>
    </div>
</div>
@endsection
