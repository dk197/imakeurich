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

<div class="container">
    <div class="row col-md-12">
            @if ($user->id==auth()->user()->id)

                <h1>That&apos;s your profile:</h1>
            @else
                <h1>That&apos;s {{$user->username}}:</h1>

            @endif
    </div>
    <div class="col-md-12 row justify-content-center ">
        <div class="col-md-12">
            <div class="card">
        <div class="card-header text-center mt-4">
                @if ($user->id==auth()->user()->id)
                    About you
                @else
                    About {{$user->username}}
                @endif
            </div>
        <div class="card-body">
            <table>
                <tr>
                    <th width="100px">Username:</th>
                    <td>{{$user->username}}</td>
                </tr>
                <tr>
                    <th>eMail:</th>
                    <td>{{$user->email}}<td>
                </tr>
                </table>
        </div>

@if ($user->id==auth()->user()->id)


        <div class="row mt-4">
<div class="card col-sm-12">
    <div class="card-header text-center">Actions</div>
    <div class="card-body">
        <div class="counter">
                <div class="container container-userStat">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="employees">
                                <a href="/editUser"><img src="/images/edituser.png" width="98px" class="mb-2 img-rounded"></a>
                                <p class="employee-p"><a href="/editUser">Edit Profile</a></p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="customer">
                                <a href="/games"><img src="/images/bidnow.png" width="98px" class="mb-2 img-rounded"></a>
                                <p class="customer-p"><a href="/games">Bid Now</a></p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="design">
                                <a href="/coins"><img src="/images/coin.png" width="98px" class="mb-2 img-rounded"></a>
                                <p class="design-p"><a href="/coins">Buy Coins</a></p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="order">
                                <a href="{{ url('/logout') }}"><img src="/images/logout.png" width="98px" class="mb-2 img-rounded"></a>
                                <p class="order-p"><a href="{{ url('/logout') }}">Log out</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif



<div class="row mt-4">
<div class="card col-sm-12">
    <div class="card-header text-center">
            @if ($user->id==auth()->user()->id)
                Your statistics
            @else
            {{$user->username}}&apos;s statistics
            @endif
    </div>
    <div class="card-body">
        <div class="counter">
                <div class="container container-userStat">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="employees">
                                <p class="counter-count1"><?php echo time_elapsed_string($timeago); ?></p>
                                <p class="employee-p">since
                                    @if ($user->id==auth()->user()->id)
                                        you
                                    @else
                                        {{$user->username}}
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


@endsection
