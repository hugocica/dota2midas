@extends('layouts.template')

@section('content')
<div class="jumbotron">
    	<div class="container">
    		<h1>Thank you for you purchase!</h1>
    		<p>A bot will soon make you a trade-offer on steam with your items!</p>
    		<p>
    			<a class="btn btn-primary btn-lg">Learn more</a>
    		</p>
    	</div>
    </div>
<audio autoplay>
  <source src="{{asset('sounds/bountiful.mp3')}}" type="audio/mpeg">
Your browser does not support the audio element.
</audio>

@stop