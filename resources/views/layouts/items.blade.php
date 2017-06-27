 <?php
 use App\Helpers\DotaHelper;
 ?>
  <div id="page">
        <?php $count=0; ?>
        @if($adds->count()>0)
              @foreach($adds as $item)
                        <?php $count++ ;?>
                        @if($count == 1)
                            <div class="row">
                        @endif
                                <div class="col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="thumbnail addCase {{DotaHelper::getQualityCss($item->quality)}}" >
                                        <h4 class="text-center"><span class="label label-{{{($item->item->item_rarity!="")? $item->item->item_rarity :"common"}}}">{{{($item['item']['item_rarity']!="")? $item->item->item_rarity :"common"}}}</span></h4>
                                        <img src={{ $item->item->image_inventory}} class="img-responsive">
                                        <div class="caption">
                                            <div class="row">
                                                <div class="{{DotaHelper::getQualityCss($item['quality'])}}">
                                                    <h3 class="text-center">{{ DotaHelper::getQuality($item['quality'])." ".$item['item']['name']}}</h3>
                                                </div>
                                            </div>
                                            <p class="text-center">{{{ ($item['item']['hero_name']!="1" && $item['item']['hero_name']!="0" )?$item['item']['hero_name'] ."'s " :""}}}{{$item['item']['item_type_name']}} </p>
                                            <h4 class="text-center coin-color">{{number_format($item->price)}} Coins </h4>
                                           <div class="row">
                                                <div class="col-xs-offset-3 col-xs-6">
                                                    <a class="btn btn-primary btn-success cart" id="{{$item['id']}}" href="{{ url('user/addcart?id='.$item['id'])}}">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @if($count == 4)
                        <?php $count=0;?>
                            </div>
                        @endif
                @endforeach
        @else
            <h1 class="text-center">No Items Found!</h1>
        @endif

        <?php $adds->setPath(Request::url()); ?>
           {!!$adds->render()!!}
        </div>
        <?php $count_cart = Session::get('cart.count',0); ?>
        <script>
    $(function(){
               console.log($('.btn-danger'));
        $('.cart').click(function(event) {
                  event.preventDefault();
                 $.ajax({
                   url: "{{ url('user/addcart?id=')}}"+$(this).attr('id')
                 }).done(function(ret) {
                   if(ret!=0 && ret!=-1){
                       if(document.getElementById('cart_icon')== null){
                          var cart = '<ul class="nav navbar-nav navbar-right">'+
                                         '<li class="dropdown">'+
                                           '<a href="#" id="cart_icon" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-shopping-cart"></span> <span id="number_cart">0</span> <span id="cart_item_text">Item </span><span class="caret"></span></a>'+
                                           '<ul id="cart_head" class="dropdown-menu dropdown-cart" role="menu">'+
                                          '<li class="divider"></li>'+
                                                '<li><a class="text-center" href="{{action('UserController@cart')}}">Checkout</a></li>'+
                                            '</ul>'+
                                          '</li>'+
                                      '</ul>';
                           $(".navbar-collapse").append(cart);
                       }

                       $('#cart_head').prepend(ret);//ok
                       var number_of_items = parseInt($('#number_cart').text());
                        number_of_items++;
                        $('#number_cart').text(number_of_items);
                       if(number_of_items==1){
                        $('#cart_item_text').text('item');
                       }
                       else if(number_of_items>1){
                          $('#cart_item_text').text('items');
                       }
                   }

                 });
               });

        });


        // usage:
        // $(elem).infinitescroll(options,[callback]);

        // infinitescroll() is called on the element that surrounds
        // the items you will be loading more of

        $('.container').infinitescroll({
          navSelector  : " ul.pager",
                         // selector for the paged navigation (it will be hidden)

          nextSelector : "ul.pager li:last a:last",
                         // selector for the NEXT link (to page 2)

          itemSelector : "#page",
                         // selector for all items you'll retrieve

          loadingImg: 'https://d13yacurqjgara.cloudfront.net/users/12755/screenshots/1037374/hex-loader2.gif',
                         // loading image.
                         // default: "http://www.infinite-scroll.com/loading.gif"
          loadingText  : "Loading",
                         // text accompanying loading image
                         // default: "<em>Loading the next set of posts...</em>"

          animate      : false,
                         // boolean, if the page will do an animated scroll when new content loads
                         // default: false

          extraScrollPx: 150,
                         // number of additonal pixels that the page will scroll
                         // (in addition to the height of the loading div)
                         // animate must be true for this to matter
                         // default: 150

          donetext     : "" ,
                         // text displayed when all items have been retrieved
                         // default: "<em>Congratulations, you've reached the end of the internet.</em>"

          bufferPx     : 1000,
                         // increase this number if you want infscroll to fire quicker
                         // (a high number means a user will not see the loading message)
                         // new in 1.2
                         // default: 40

          localMode    : true
                         // enable an overflow:auto box to have the same functionality
                         // demo: http://paulirish.com/demo/infscr
                         // instead of watching the entire window scrolling the element this plugin
                         //   was called on will be watched
                         // new in 1.2
                         // default: false

            });
        </script>