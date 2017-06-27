@extends('layouts.template')

@section('content')
    <div class="jumbotron">
    	<div class="container">
    		<h1>What does a hero trully need?</h1>
            <p>That is for you to decide</p>
    		<p>
    			<a class="btn btn-primary btn-lg">Learn more</a>
    		</p>
    	</div>
    </div>
    @include('layouts.adv-search')
    @include('layouts.items')

@stop