@extends('layouts.template')

@section('content')
    <div class="row">
           <div class="col-xs-6 col-md-3">
                <a href="{{action("UserController@coinPurchase", ['value' => 100])}}" class="thumbnail">
                  <h4 class="text-center"> $1.00 USD</h4>
                    <img src="{{asset('images/coin.png')}}" class="coin-img">
                  <h4 class="text-center">100 coins</h4>
                </a>
              </div>
          <div class="col-xs-6 col-md-3">
            <a href="{{action("UserController@coinPurchase", ['value' => 500])}}" class="thumbnail">
              <h4 class="text-center"> $5.00 USD</h4>
              <img src="{{asset('images/coin.png')}}" class="coin-img">
              <h4 class="text-center">500 coins</h4>
            </a>
          </div>
          <div class="col-xs-6 col-md-3">
              <a href="{{action("UserController@coinPurchase", ['value' => 1000])}}" class="thumbnail">
                <h4 class="text-center"> $10.00 USD</h4>
                <img src="{{asset('images/coin.png')}}" class="coin-img">
                <h4 class="text-center">1000 coins</h4>
              </a>
          </div>
          <div class="col-xs-6 col-md-3">
              <a href="{{action("UserController@coinPurchase", ['value' => 2000])}}" class="thumbnail">
                <h4 class="text-center"> $20.00 USD</h4>
                <img src="{{asset('images/coin.png')}}" class="coin-img">
                <h4 class="text-center">2000 coins</h4>
              </a>
          </div>
          <div class="col-xs-6 col-md-3">
              <a href="{{action("UserController@coinPurchase", ['value' => 3500])}}" class="thumbnail">
                 <h4 class="text-center"> $35.00 USD</h4>
                <img src="{{asset('images/coin.png')}}" class="coin-img">
                <h4 class="text-center">3500 coins</h4>
              </a>
          </div>
            <div class="col-xs-6 col-md-3">
                <a href="{{action("UserController@coinPurchase", ['value' => 5000])}}" class="thumbnail">
                  <h4 class="text-center"> $50.00 USD</h4>
                    <img src="{{asset('images/coin.png')}}" class="coin-img">
                  <h4 class="text-center">5000 coins</h4>
                </a>
            </div>
              <div class="col-xs-6 col-md-3">
                  <a href="{{action("UserController@coinPurchase", ['value' => 10000])}}" class="thumbnail">
                    <h4 class="text-center"> $100.00 USD</h4>
                    <img src="{{asset('images/coin.png')}}" class="coin-img">
                    <h4 class="text-center">10000 coins</h4>
                  </a>
              </div>

             <div class="col-xs-6 col-md-3">
               <a href="{{action("UserController@coinPurchase", ['value' => 50000])}}" class="thumbnail">
                 <h4 class="text-center"> $500.00 USD</h4>
                 <img src="{{asset('images/coin.png')}}" class="coin-img">
                 <h4 class="text-center">50000 coins</h4>
               </a>
             </div>


    </div>

@stop