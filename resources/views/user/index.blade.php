@extends('layouts.app')

<?php
//Wandelt den created_at Timestamp in eine dynamische Anzeige um, wie lange man schon online ist.
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . '' : '';
}
$timeago = $user->created_at;
?>

@section('content')
</div>

<div id="banner">
    <div id="cloud-scroll">
        <div class="container">
            <div class="jumbotron p-4 p-md-5 text-dark rounded bg-transparent">
                <div class="row">
                    <div class="col-md-6 px-0">
                        @if ($user->id==auth()->user()->id)

                                <h1 class="display-4 font-italic">Welcome {{$user->username}},</h1>
                                <p class="lead my-3">here can you see all your personal statistics:</p>
                            @else
                                <h1 class="display-4 font-italic">Thats {{$user->username}},</h1>
                                <p class="lead my-3">here can you see all your personal statistics:</p>

                        @endif
                    </div>
                    <div class="col-md-6 px-0">
                        <!--button-->
                        <a href="/games"><img src="https://image.flaticon.com/icons/svg/747/747661.svg" alt="Bid now" class="img-rounded"></a>
                        <a href="/coins"><img src="https://img.icons8.com/color/260/us-dollar.png" alt="Buy Coins" class="img-rounded"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="counter">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="employees">
                                <p class="counter-count1"><?php echo time_elapsed_string($timeago); ?></p>
                                <p class="employee-p">since
                                    @if ($user->id==auth()->user()->id)
                                        you
                                    @else
                                        he
                                    @endif
                                got rich</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="customer">
                                <p class="counter-count"><?php echo $countbids ?></p>
                                <p class="customer-p">bids were taken</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="design">
                                <p class="counter-count"><?php echo $coinsbid ?></p>
                                <p class="design-p">coins were bid</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="order">
                                <p class="counter-count"><?php echo $coinswon ?></p>
                                <p class="order-p">coins were won</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
@endsection
