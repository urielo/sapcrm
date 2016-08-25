@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="{{ theme('css/style.css') }}">
@stop
@section('content')




<div class="col-xs-12 col-sm-12 " >
    <div class="panel panel-@yield('panelcolor')" style="margin-top: 10px;">
        <div class="panel-heading">
            <h2 class="panel-title" style="text-align: center;">@yield('heading')</h2>
        </div>
        <div class="panel-body"  style="height: 450px; overflow-x: auto;">

            <div class="alert alert-danger" id="diverror">
                <strong>Erro: </strong>
                <div id="messageerror">

                </div>
            </div>

            @if(Session::has('sucesso'))
                <div class="alert alert-info" id="sucesso">
                    <button type="button" class="close" aria-label="Close" id="fechasecesso">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{Session::get('sucesso')}}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger" id="sucesso">
                    <button type="button" class="close" aria-label="Close" id="fechasecesso">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{Session::get('error')}}
                </div>
            @endif




            @yield('contentSeg')


        </div>
    </div>

    <div class="horizont-center" style=" margin-top: 0; padding-top: 0">
        @yield('pagination')
    </div>





</div>


@stop