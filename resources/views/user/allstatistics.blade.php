@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron p-4 p-md-5 text-white rounded statistics-card">
      <div class="col-md-6 px-0">
      <h1 class="display-4">All-Time Statistics</h1>
        <p class="lead my-3">Here can you see all your statistics:</p>
      </div>
    </div>
</div>


<div class="counter">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="employees">
                    <p class="counter-count"><?php echo $gamesplayed ?></p>
                    <p class="employee-p">games were played</p>
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
@endsection
