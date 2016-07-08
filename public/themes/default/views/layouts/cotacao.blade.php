@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="{{ theme('css/style.css') }}">
@stop
@section('content')




<div class="col-xs-12 col-sm-12 ">
    <div class="panel panel-@yield('panelcolor')" style="margin-top: 10px;">
        <div class="panel-heading">
            <h2 class="panel-title">@yield('heading')</h2>
        </div>
        <div class="panel-body">

            <div class="alert alert-danger" id="diverror">
                <strong>Erro: </strong>
                <div id="messageerror">

                </div>
            </div>


            @yield('contentSeg')


        </div>
    </div>

    <div class="horizont-center">
        @yield('pagination')
    </div>





</div>


@stop