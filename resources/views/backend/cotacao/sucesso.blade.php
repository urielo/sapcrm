@extends('layouts.cotacao')

@section('panelcolor','success')
@section('heading','Sucesso')

@section('contentSeg')

    @if($cotacao)
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" id="mensagem">
                    <h3 style="text-align: center;">

                        Cotação realizada com sucesso!! <br>Nº: {{$cotacao->idcotacao}}
                    </h3>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="align-items: center;">
                    <center>
                        <div class="btn-group">
                            <a href="{{route('cotacao.cotar')}}">
                                <button type="button" class="btn btn-success">Nova Cotação</button>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('cotacao.pdf',$crypt::encrypt($cotacao->idcotacao))}}" target="_blank">
                                <button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir PDF</button>
                            </a>
                        </div>

                        <div class="btn-group">
                            <a href="{{route('proposta.index',$crypt::encrypt($cotacao->idcotacao))}}" >
                                <button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-expand" aria-hidden="true"></span> Emitir proposta</button>
                            </a>
                        </div>

                        <div class="btn-group hide">
                            <a href="#">
                                <button type="button" href="#" class="btn btn-info"> <span class="glyphicon glyphicon glyphicon-send" aria-hidden="true"></span> Enviar Email</button>
                            </a>
                        </div>

                    </center>

                </div>
            </div>

        </div>

    @elseif($proposta)

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" id="mensagem">
                    <h3 style="text-align: center;">

                        Proposta realizada com sucesso!! <br> Nº: {{$proposta->idproposta}}
                    </h3>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="align-items: center;">
                    <center>
                        <div class="btn-group">
                            <a href="{{route('cotacao.cotar')}}">
                                <button type="button" class="btn btn-success">Nova Cotacao</button>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('proposta.pdf',$crypt::encrypt($proposta->idproposta))}}" target="_blank">
                                <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-open-file"></i>PDF</button>
                            </a>
                        </div>
                        @role('diretor')
                        <div class="btn-group">
                            <a href="#">
                                <button type="button" href="#" class="btn btn-info">ENVIAR VIA EMAIL</button>
                            </a>
                        </div>
                        @endrole
                    </center>

                </div>
            </div>

        </div>
    @endif

@stop