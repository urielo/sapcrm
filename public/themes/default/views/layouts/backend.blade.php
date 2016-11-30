<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguro AUTOPRATICO</title>
    {{--    <link rel="stylesheet" href="{{ theme('css/backend.css') }}">--}}



    @yield('style')
    <link rel="stylesheet" href="{{ theme('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ theme('css/bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" href="https://bootswatch.com/sandstone/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{ theme('css/bootstrap-select.min.css') }}">

    {{--<link rel="stylesheet" href="{{ theme('css/bootstrap-theme.min.css') }}">--}}
    <link rel="stylesheet" href="{{ theme('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ theme('datatables/datatables.min.css') }}">
    {{--<link rel="stylesheet" href="{{ theme('css/sidebar.css') }}">--}}
    <link rel="stylesheet" href="{{ theme('css/style.css') }}">


    {{--<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">--}}

</head>

<body class="">
<div class="background"></div>
<div class="bgloading" id="loading"></div>
<div class="blur" id="body">
    <nav class="navbar navbar-inverse navbar-fixed-top " role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-sidebar-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand logo-autopratico " href="{{route('backend.dashboard')}}">
                    <h1>SEGURO</h1>
                    <h2>AUTOPRATICO</h2>
                    {{--<img src="{{ theme('images/logo-bar.png') }}"  height="25px" alt="Seguro AUTOPRATICO">--}}

                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-2">
                <ul class="nav navbar-nav">

                    @permission('cotacao')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mouse-over-down" data-toggle="dropdown">
                        <span style="font-size:16px;"
                              class="hidden-xs showopacity glyphicon glyphicon glyphicon-shopping-cart"></span> Cotação
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">

                            @permission('cotacao-nova')
                            <li><a href="{{route('cotacao.cotar')}}">Nova</a></li>
                            @endpermission

                            @permission('cotacao-gestao')
                            <li><a href="{{route('vendas.negociacoes')}}">Gestão</a></li>
                            <li><a href="{{route('cotacao.vencidas')}}">Vencidas</a></li>
                            @endpermission


                        </ul>
                    </li>
                    @endpermission

                    @permission('proposta')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-briefcase"></span> Proposta
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">

                            @permission('proposta-gestao')
                            <li><a href="{{route('proposta.acompanhamento')}}">Acompanhamento</a></li>
                            <li><a href="{{route('proposta.negativas')}}">Inativas</a></li>
                            @endpermission


                        </ul>
                    </li>
                    @endpermission

                    @permission('vistoria')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-list-alt"></span>
                            Vistoria<span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            @permission('vistoria')
                            <li><a href="#">Emitir</a></li> @endpermission

                        </ul>
                    </li>
                    @endpermission


                    @permission('apolices')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-list-alt"></span>
                            Apolices<span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            @permission('apolices-emitir')
                            <li><a href="{{route('apolices.aemitir')}}">Emitir</a></li> @endpermission
                            @permission('apolices-emitdas')
                            <li><a href="{{route('apolices.emitidas')}}">Gestão</a></li> @endpermission
                            @permission('apolices-canceladas')
                            <li><a href="{{route('apolices.emitidas')}}">Canceladas</a></li> @endpermission

                        </ul>
                    </li>
                    @endpermission


                    @permission('cobranca')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span style="font-size:16px;"
                              class="hidden-xs showopacity glyphicon glyphicon-usd"></span> Cobrança<span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            @permission('cobranca-agendar')
                            <li><a href="{{route('cobranca.agendar')}}">Agendar</a></li>@endpermission
                            @permission('cobranca-aprovar')
                            <li><a href="{{route('cobranca.aprovar')}}">Aprovar</a></li>@endpermission

                        </ul>
                    </li>
                    @endpermission

                    @permission('comissao')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-list-alt"></span>
                            Comissao<span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            @permission('vistoria')
                            <li><a href="#">Emitir</a></li> @endpermission

                        </ul>
                    </li>
                    @endpermission

                    @permission('segurado')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-list-alt"></span>
                            Segurado<span class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            @permission('vistoria')
                            <li><a href="#">Emitir</a></li> @endpermission

                        </ul>
                    </li>
                    @endpermission


                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="form-inline float-xs-right input-nav">
                            <div class="input-group input-group-sm">

                                <span class="input-group-btn">
                                     <select id="tipo-consulta" class=" tipo-consulta selectpicker form-control"
                                             data-style='btn-default btn-sm'>
                                        <option value="placa">Placa</option>
                                        <option value="cpfcnpj">CPF/CNPJ</option>
                                    </select>

                                </span>

                                <input class="form-control input-consulta" type="text" placeholder="Placa">
                                <span class="input-group-btn btn-up">

                                    <button class="btn btn-xs btn-default" type="submit">Consultar</button>
                                </span>

                            </div>
                        </form>
                    </li>
                    @permission('setup')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="font-size:16px;"
                                  class="hidden-xs showopacity glyphicon glyphicon-cog"></span>
                            Setup <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">

                            @permission('setup-usuarios')
                            <li><a href="{{route('usuarios.gestao')}}">Usuários</a></li>
                            @endpermission

                            @permission('setup-grupo')
                            <li><a href="{{route('grupos.index')}}">Grupos</a></li>
                            @endpermission

                            @permission('setup-homepage')
                            <li><a href="{{route('backend.homepage')}}">Homepage</a></li>
                            @endpermission

                            @permission('corretor-edit')
                            <li><a href="{{route('backend.homepage')}}">Dados da corretora</a></li>
                            @endpermission



                        </ul>
                    </li>

                    @endpermission
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span
                                    class=" hidden-xs showopacity  glyphicon glyphicon-user"></span> {{ucfirst(primeiroNome(Auth::user()->nome))}}
                            <span
                                    class="caret"></span>
                        </a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                            <li><a class="hidden" href="#">Editar</a></li>
                            <li><a href="{{route('auth.logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>


            </div>
        </div>
    </nav>

    <div class="container-fluid" id="allbody">
        <div class="row">
            @yield('content')
        </div>
    </div>
    <script src="{{ theme('js/jquery.js') }}"></script>
    <script src="{{ theme('js/bootstrap.min.js') }}"></script>
    <script src="{{ theme('js/bootstrap-select.min.js') }}"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>--}}

    <script src="{{ theme('js/i18n/defaults-pt_BR.min.js') }}"></script>
    <script src="{{ theme('js/jquery-ui.js') }}"></script>
    <script src="{{ theme('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ theme('js/bootstrap-validation.min.js') }}"></script>
    <script src="{{ theme('js/cpfcpnj-validator.js') }}"></script>
    <script src="{{ theme('js/locales/datepicker-ptbr.js') }}"></script>
    <script src="{{ theme('datatables/datatables.min.js') }}"></script>
    <script src="{{ theme('js/maskedinput.min.js') }}"></script>
    <script src="{{ theme('js/script.js') }}"></script>


    @yield('script')

    <footer class="footer navbar-fixed-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <span>&copy;</span> Seguro AUTOPRATICO {{date('Y')}}
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>