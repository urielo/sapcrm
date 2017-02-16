@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Movimentos ' . $title)
@section('contentSeg')

    <div class="col-md-12">

        <ul class="nav nav-tabs">
            <li class="active"><a href="#aguardando" aria-controls="Aguardando Retorno" role="tab" data-toggle="tab">Aguardando Retorno</a></li>
            <li class=""><a href="#sucesso" aria-controls="Sucesso" role="tab" data-toggle="tab">Successo</a></li>
            <li>
                <a href="#error" aria-controls="Sucesso" role="tab" data-toggle="tab">Erros</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="sucesso">
                @include('backend.movimentos.sucesso')
            </div>
            <div class="tab-pane fade " id="error">
                @include('backend.movimentos.erro')
            </div>
            <div class="tab-pane fade in active" id="aguardando">
                @include('backend.movimentos.aguardando')
            </div>
        </div>


    </div>
@stop