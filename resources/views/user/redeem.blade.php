<?php
  ?>
@extends('layouts.template')
@section('content')
<div class="jumbotron">
    	<div class="container">
    		<h1>Redeem your coins!</h1>
    		<p>You may redeem your Coins via PayPal on this page. The minimum coins to redeem is 500. The rate is $1.00 USD per 100 Coins. We process all redeem requests manually to check for accuracy. Because of this we may take up to 7 days to process your request.</p>
    	</div>

</div>
<div class="well">
{!! Form::open(['action'=>'UserController@sendCoinRedeem','class'=>'form-inline'])!!}
              <div class="form-group">
                <label for="mail">Paypal e-mail</label>
                <input type="email" class="form-control" name="mail" id="exampleInputEmail2" placeholder="jane.doe@example.com">
              </div>
              <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="500">
              </div>

              <button type="submit" class="btn btn-default">Send request</button>
           {!!Form::close()!!}
</div>

    <?php
        $dir = public_path().'\sounds';
        $files = File::glob($dir.'\*.mp3');
        $file = array_rand($files);
        $sound =$files[$file];
        $sound=str_replace($dir."\\","",$sound);
    ?>
<audio autoplay>
  <source src="{{asset('sounds/'.$sound)}}" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
<script src='https://www.google.com/recaptcha/api.js'></script>
@stop