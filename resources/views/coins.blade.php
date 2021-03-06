@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12 row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Free Coins</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3 text-center">
                        <img class="coin-icon" src="images/1Coin.svg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3 text-center">
                        <p> Watch an Ad and get 1 Coin for free! </p>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-12 text-center">
                                    <a id="watchAdBtn" class="btn btn-block button-gold coinChanger" >Get 1 Free Coin</a>
                            </div>
                        </div>
                </div>
            </div>
        <div class="row mt-4 pt-0">
            <div class="col-md-4">
                <div class="card card-coins">
                    <div class="card-header text-center">Buy</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-3 text-center">
                                    <img class="coin-icon-buy" src="images/99Coins.svg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-3 text-center">
                                        <p> 99 Coins </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <a id="buy99" class="btn btn-block button-gold coinChanger">Buy Now for 0,99€</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">Buy</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-3 text-center">
                                        <img class="coin-icon-buy" src="images/999Coins.svg">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 mb-3 text-center">
                                    <p> 999 Coins </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <a id="buy999" class="btn btn-block button-gold coinChanger">Buy Now for 9,99€</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center">Buy</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 mb-3 text-center">
                                            <img class="coin-icon-buy" src="images/9999Coins.svg">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 mb-3 text-center">
                                        <p> 9999 Coins </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a id="buy9999" class="btn btn-block button-gold coinChanger">Buy Now for 99,99€</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header text-center">Donation</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-3 text-center">
                                <img class="coin-icon" src="images/get-money.svg">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3 text-center">
                                    Support Us.
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-12 text-center">
                                        <a id="donate10" class="btn btn-block button-gold coinChanger">Donate 10 Coins</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="coin_add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Time to get RICH!</button>
      </div>
    </div>
  </div>
</div>

@endsection
