@extends('layouts.template')

@section('content')
    <div class="row">
      <div class="col-xs-offset-4 col-xs-4">
            {!! Form::open(array('url' => "transactions/".$transaction->id, 'method' => 'PUT'))!!}
                 <div class="form-group">
                    <h2>{{$transaction->item->name}}</h2>
                 </div>
                  <div class="form-group">
                    <h2>{{$transaction->item->hero_name."'s ".$transaction->item->item_type_name}}</h2>
                  </div>
                 <div class="form-group">
                    <img class="img-thumbnail" src={{$transaction->item->image_inventory}} alt={{$transaction->item->name}}/>
                 </div>
                 <div class="form-group">
                    {!!Form::label('price', 'Price')!!}
                    {!!Form::text('price',$transaction->price,['class'=>'form-control'])!!}
                 </div>
                 <div class="form-group">
                     {!!Form::label('featured', 'Featured')!!}
                     <?php 
                        if ($transaction->featured>0) {
                             $featured ="checked";
                        }else{
                            $featured = "";
                        }
                      ?>
                     {!! Form::checkbox('featured','value', ['class'=>'form-control'])!!}  <span data-toggle="tooltip" data-placement="right" title="Your item will be in our main page and are always at the top of most search results"><span class="glyphicon glyphicon-question-sign"></span></span>
                     <p class="help-block alert-danger">We will change 200 coins for the featured service</p>
                  </div>
                 <div class="form-group">
                     {!!Form::submit('Submit',['class'=>'btn btn-default'])!!}
                 </div>

            {!! Form::close()!!}

        </div>
    </div>
    <script>
           $('[data-toggle="tooltip"]').tooltip();
    </script>
@stop