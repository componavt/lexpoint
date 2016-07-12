<!DOCTYPE html>
<html>
    <head>
        <title>Lexpoint :: @yield('title')</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery & jQuery UI -->
        <script src="/js/jquery-1.11.3.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
 
        <!-- Bootstrap -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
 
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('headExtra')
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Lexpoint</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <!-- NAVIGATION ITEMS -->
                        <li><a href="/lab">{{trans('navigation.wiktionary_lab')}}</a></li>
                        <li><a href="/algorithms">{{trans('navigation.algorithms')}}</a></li>
                        <li><a href="/wordgames">{{trans('navigation.wordgames')}}</a></li>

            @if (Auth::check() && Auth::user()->status=="admin")
            <li><a href="/admin">Admin</a></li>
            @endif

                        @foreach ( trans('navigation.locale_links') as $link_url => $link_text)
                        <li><a href="/setlocale/{{ $link_url }}">{{ $link_text }}</a></li>
                        @endforeach
                    </ul>


                    @if (!Auth::check())
        {!! Form::open(array('url'=>'/auth/login', 'method'=>'get', 'class'=>'navbar-form navbar-right')) !!}
             {!! Form::submit(trans('user.log_in'),array('class'=>'btn btn-success')) !!}
                         <a href="/auth/register" class="btn btn-success"> {{trans('user.register')}} </a>
        {!! Form::close() !!}
                    @else
        {!! Form::open(array('url'=>'/auth/logout', 'class'=>'navbar-form navbar-right', 'method'=>'get')) !!}
             {!! Form::submit(Auth::user()->name.': '.trans('user.logout'),array('class'=>'btn btn-success')) !!}
        {!! Form::close() !!}
                    @endif

                </div><!--/.navbar-collapse -->
            </div>
        </div>

    <div class="jumbotron">
        <div class="container">
 
@yield('content')

        </div>
    </div>
        <div id="footer">
            <div class="container">
                <div class="col-md-4">
                    &copy; 2015-2016 Lexpoint
                </div>
            </div>
        </div>
    </body>
</html>
