<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href={{action('PageController@index')}}>Dota2Midas</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      @if(Auth::check())
        <li class="{{(Request::url()==action('TransactionController@backpack'))?"active":''}}"><a href="{{action('TransactionController@backpack')}}">My backpack {!!(Request::url()==action('TransactionController@backpack'))? '<span class="sr-only">(current)</span>':''!!} </a></li>
      @endif
      <li class="{{(Request::url()==action('TransactionController@index'))?"active":''}}"> <a href="{{action('TransactionController@index')}}">Items {!!(Request::url()==action('TransactionController@index'))?'<span class="sr-only">(current)</span>':''!!}</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{action('PageController@about')}}">About us</a></li>
            <li><a href="{{action('PageController@terms')}}">Terms</a></li>
            <li><a href="{{action('PageController@faq')}}">FAQ</a></li>
            <li><a href="{{action('PageController@support')}}">Support</a></li>
            <li><a href="{{action('PageController@partners')}}">Partners</a></li>
          </ul>
        </li>
      </ul>
     <div class="col-sm-4 col-md-4">
            <form class="navbar-form" role="search">
            <div class="input-group" id="scrollable-dropdown-menu">
                <input type="text" class="form-control typeahead" placeholder="Search" name="q">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            </form>
        </div>
        @if($cart =Session::get('cart',null))
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="cart_icon" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-shopping-cart"></span> <span id="number_cart">{{$cart['item_count']}}</span> <span id="cart_item_text">{{($cart['item_count']==1)?'Item':'Items'}}</span><span class="caret"></span></a>
                  <ul id="cart_head" class="dropdown-menu dropdown-cart" role="menu">
                  @foreach($cart['items'] as $item)
                      <li id="{{$item['id']}}">
                          <span class="item">
                              <span class="item-left">
                                <img  class="center-block" style="height: 100px;" src="{{$item['image']}}" alt="{{$item['item']}}" />
                                <span class="item-info">
                                    <span>{{$item['item']}}</span>
                                    <span class="coin-color">{{$item['price']}} coins</span>
                                </span>
                              </span>

                          </span>
                      </li>
                  @endforeach
                      <li class="divider"></li>
                       <li class="coin-color text-center">Total: <span id="cart-total">{{$cart['total']}}</span> coins</li>
                      <li><a class="text-center" href="{{action('UserController@cart')}}">Checkout</a></li>
                  </ul>
                </li>
            </ul>
        @endif
      @if(Auth::check())
      <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                  <li ><a  href={{action('UserController@index')}}>Info</a></li>
                  <li ><a  href={{action('UserController@sales')}}>Sales</a></li>
                  <li ><a  href={{action('UserController@transactions')}}>Finalized Transactions</a></li>
                  <li ><a  href={{action('UserController@coinRedeem')}}>Redeem coins</a></li>
                  <li ><a  href={{action('UserController@coins')}}>Add coins</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a  href={{action('SteamController@logout')}}>Logout</a></li>
                  </ul>
         </li>
       <img class="navbar-brand" alt="Brand" src="{{asset("images/coin.png")}}" style="padding-right:0px">
       <li>
          <a  href="{{action('UserController@index')}}" class="coin-color" style="padding-left:10px">{{Auth::user()->coins}}</a>
       </li>


      </ul>
      @else
         <a class="navbar-right" href={{action('SteamController@login')}}>
           <img alt="Brand" src="{{asset('images/steam.png')}}">
         </a>
      @endif

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<script>

</script>
