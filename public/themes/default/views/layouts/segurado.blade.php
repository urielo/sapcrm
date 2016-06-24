@extends('layouts.backend')
@section('style')
<link rel="stylesheet" href="{{ theme('css/style.css') }}">
@stop
@section('content')




<div class="col-xs-12 col-sm-12 ">
    <div class="panel panel-{{ $errors->any() ? 'danger': 'default' }}" style="margin-top: 10px;">
        <div class="panel-heading">
            <h2 class="panel-title">@yield('heading')</h2>
        </div>
        <div class="panel-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Erro: </strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach                                
                </ul>

            </div>
            @endif

            @yield('contentSeg')


        </div>
    </div>

    <div class="horizont-center">
        @yield('pagination')
    </div>





</div>


@stop