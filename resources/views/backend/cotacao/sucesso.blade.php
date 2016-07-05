@extends('layouts.backend')
@section('style')
    <link rel="stylesheet" href="{{ theme('css/style.css') }}">
@stop
@section('content')




    <div class="col-md-12 col-xs-12 col-sm-12 ">
        <div class="panel panel-success" style="margin-top: 10px;">
            <div class="panel-heading">
                <h2 class="panel-title">Sucesso</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" id="mensagem">
                        {{$message}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="align-items: center;">
                        <center><div class="btn-group">
                            <a href="{{route('cotacao.cotar')}}"><button type="button" class="btn btn-success">NOVA PROPOSTA</button></a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('cotacao.pdf',302)}}" target="_blank"><button type="button" class="btn btn-danger" >PDF</button></a>
                        </div>
                        <div class="btn-group">
                            <a href="#"><button type="button" href="#" class="btn btn-info" >ENVIAR VIA EMAIL</button></a>
                        </div></center>

                    </div>
                </div>

            </div>
        </div>


    </div>


@stop