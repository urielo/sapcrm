<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Seguro Auto Pratico</title>
        <link rel="stylesheet" href="{{ theme('css/backend.css') }}">
        <link rel="stylesheet" href="{{ theme('css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ theme('css/sidebar.css') }}">

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        @section('style')        
        @show
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" style="margin-bottom: 10px" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{route('backend.dashboard')}}">Seguro AutoPratico</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="{{route('segurado.index')}}" class="dropdown-toggle" data-toggle="dropdown">Vendas<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span><span class="caret"></span></a>
                            <ul class="dropdown-menu forAnimate" role="menu">
                                <li><a href="{{route('cotacao.cotar')}}">Cotar</a></li>
                                <li><a href="{{route('vendas.negociacoes')}}">Negociações</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Seguradora<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span><span class="caret"></span></a>
                            <ul class="dropdown-menu forAnimate" role="menu">
                                <li><a href="#">Nobre</a></li>
                                <li><a href="#">Usebens</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                            <ul class="dropdown-menu forAnimate" role="menu">
                                <li><a href="{{route('backend.upload')}}">Upload</a></li>

                            </ul>
                        </li>


                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><span class="navbar-text">Hello, {{Auth::user()->nome}}</span></li>
                        <li><a href="{{route('auth.logout')}}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid" id="allbody">
            <div class="row row-offcanvas row-offcanvas-left">
                @yield('content')
            </div>
        </div>
        <script src="{{ theme('js/jquery.js') }}"></script>
        <script src="{{ theme('js/bootstrap.min.js') }}"></script>
        <script src="{{ theme('js/jquery-ui.js') }}"></script>

        <script src="{{ theme('js/script.js') }}"></script>
        <script src="{{ theme('js/autocomplete.js') }}"></script>

        <footer class="footer navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <center>&copy; SeguroAutoPratico {{date('Y')}} </center>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>