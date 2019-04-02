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
        <div class="container mt-3">
            <div class="jumbotron p-4 p-md-5 text-dark rounded bg-transparent">
                <div class="row">
                    <div class="col-md-6 px-0">
                        <h1 class="display-4 font-italic">Thats {{$user->username}},</h1>
                        <p class="lead my-3">here can you see all his personal statistics:</p>
                    </div>
                    <div class="col-md-6 px-0">
                        <!--button-->
                        
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
                                <p class="employee-p">since he got rich</p>
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
