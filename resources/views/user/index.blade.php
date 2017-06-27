@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-xs-offset-3 col-xs-7">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object dp img-circle" src={{$user->avatar_medium}} style="width:100px;height:100px;">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$user->name}} </h4>
                      @if($user->communityvisibilitystate==1)
                        <h5>Private (set it to public {!!link_to($user->profileurl."edit/settings/","here")!!})<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button></h5>
                      @elseif($user->communityvisibilitystate==3)
                        <h5>Public <span data-toggle="tooltip" data-placement="right" title="We need your profile to be public!"><span class="glyphicon glyphicon-question-sign"></span></span></h5>
                      @endif
                      {!! Form::open(array('class'=>'form-inline' , 'id'=>'ajax_form'))!!}
                        <div class="form-group">
                          <label class="sr-only" for="exampleInputAmount">Trade URL</label>
                          <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></div>
                            <input type="text" class="form-control" id="trade_url" placeholder="Trade URL" value={{$user->steam_trade_url}}>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary" >Update</button>
                      {!! Form::close()!!}
                    <h5> {!!"Get your url ".link_to($user->profileurl."tradeoffers/privacy","here")!!}
                     <span data-toggle="tooltip" data-placement="right" title="We need your trade URL, without it we can't trade with you!"><span class="glyphicon glyphicon-question-sign"></span></span></h5>
                    @if($user->personastate==0)
                        <span class="label label-default">Offline</span>
                    @elseif($user->personastate==1)
                        <span class="label label-success">Online</span>
                    @elseif($user->personastate==2)
                        <span class="label label-warning">Busy</span>
                    @elseif($user->personastate==3)
                        <span class="label label-default">Away</span>
                    @elseif($user->personastate==4)
                        <span class="label label-info">Snooze</span>
                    @elseif($user->personastate==5)
                        <span class="label label-danger">Looking to trade</span>
                    @elseif($user->personastate==6)
                        <span class="label label-primary">Looking to play</span>
                    @endif

                    <h3>{{$user->coins}} Coins</h3>
                    <a href="{{action('UserController@coins')}}">Add coins</a>

                </div>
            </div>

        </div>



    </div>
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
            $('#ajax_form').submit(function(e){
                e.preventDefault();
       			var url = $("#trade_url").val();
       			var _token =  $('input[name="_token"]').val();
       			jQuery.ajax({
       				type: "POST",
       				url: "updateTradeUrl",
       				data:{url: url, _token: _token},
       				success: function( data ){
       				    alert(data.msg);
       				}
       			});

       			return false;
       		});

    });

    </script>
@stop