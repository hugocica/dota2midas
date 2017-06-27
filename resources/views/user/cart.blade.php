@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
        @if($cart['items'] != null)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th> </th>
                        <th> </th>
                        <th class="text-center">Price</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cart['items'] as $item)
                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{$item['image']}}" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">{{$item['item']}}</a></h4>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center"    >
                        </td>
                                                <td>    </td>

                        <td class="col-sm-1 col-md-1 text-center"><strong class="coin-color">{{$item['price']}} Coins</strong></td>
                        <td class="col-sm-1 col-md-1">
                        <a href="{{action('UserController@cart')}}" id="{{$item['id']}}" type="button" class="btn btn-danger remove-cart">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </a></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong class="coin-color">{{$cart['total']}} Coins</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <a href="{{action('TransactionController@index')}}" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </a></td>
                        <td>
                        <a href="{{action('UserController@checkout')}}" type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </a></td>
                    </tr>
                </tbody>
            </table>
        @else
            <h2 class="text-center" style="margin-top: 200px;">No items on cart!</h2>
        @endif
        </div>
    </div>
    <script>
    $('.remove-cart').click(function(event) {
                      event.preventDefault();
                      console.log($(this));
                     $.ajax({
                       url: "{{ url('user/removecart?id=')}}"+$(this).attr('id')
                     }).done(function(ret) {
                           location.reload();
                     });
                   });
    </script>
@stop