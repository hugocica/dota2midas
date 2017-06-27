<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/infinite-scroll.js') }}"></script>
        <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
        <title>Dota2Midas</title>
    </head>
    <body>
    @include('layouts.navbar')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success">{{Session::get('flash_message')}}
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                 </button>
            </div>
        @endif
         @if(Session::has('flash_message_error'))
                <div class="alert alert-danger">{{Session::get('flash_message_error')}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                     </button>
                </div>
         @endif
         @if(Session::has('flash_message_warning'))
               <div class="alert alert-warning">{{Session::get('flash_message_warning')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                    </button>
               </div>
         @endif
        @yield('content')
    </div>
    @include('layouts.footer')
    </body>
</html>
