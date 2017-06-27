<?php
use App\Helpers\DotaHelper;
 ?>
@extends('layouts.template')

@section('content')
<div id="page">
    <?php $count=0; ?>

    @foreach($items as $item)
    <?php $count++ ;?>
        @if($count == 1)
            <div class="row">
        @endif
                <div class="col-md-3 col-sm-6 col-xs-12 ">
                    <div class="thumbnail addCase {{DotaHelper::getQualityCss($item['quality'])}}" >
                        <h4 class="text-center"><span class="label label-{{{($item['item_rarity']!="")? $item['item_rarity'] :"common"}}}">{{{($item['item_rarity']!="")? $item['item_rarity'] :"common"}}}</span></h4>
                        <img src={{ $item['image_inventory']}} class="img-responsive">
                        <div class="caption">
                            <div class="row">
                                <div class="col-md-6 col-xs-6 {{DotaHelper::getQualityCss($item['quality'])}}">
                                    <h3>{{ DotaHelper::getQuality($item['quality'])." ".$item['name']}}</h3>
                                </div>
                            </div>
                            <p>{{{ ($item['hero_name']!="1" && $item['hero_name']!="0" )?$item['hero_name'] ."'s " :""}}}{{$item['item_type_name']}} </p>
                            <div class="row">
                                <div class="col-xs-offset-4 col-xs-6">
                                    <a class="btn btn-primary btn-success" href="{{ url('transactions/create?id='.$item['steam_item_id'])}}"><span class="glyphicon glyphicon-usd"></span>Sell</a>
                                </div>
                            <p> </p>
                            </div>
                        </div>
                    </div>
                </div>
        @if($count == 4)
        <?php $count=0; ?>
            </div>
        @endif
    @endforeach
    <?php $items->setPath(Request::url()); ?>
       {!!$items->render()!!}
    </div>
    <script>
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
 @stop