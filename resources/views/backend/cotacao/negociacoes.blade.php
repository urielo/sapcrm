@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Cotações')
@section('contentSeg')

    <div class="col-md-12">
        <div class="table-responsive apolice">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th># Cotação</th>
                    <th>CPF/CNPJ</th>
                    <th>Emissão</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($cotacoes as $cotacao)
                    <tr {!! date('d/m/Y', strtotime($cotacao->dtvalidade)) > date('d/m/Y') ? 'class="danger"': '' !!}>
                        <th><a href="#" class="">{{$cotacao->idcotacao}}</a></th>
                        <th><a href="#" class="">{{format('cpfcnpj',$cotacao->segurado->clicpfcnpj)}}</a></th>
                        <td>{!! date('d/m/Y', strtotime($cotacao->dtcreate)) !!}</td>
                        <td>{!! date('d/m/Y', strtotime($cotacao->dtvalidade)) !!}</td>

                        <td>{{$cotacao->status->descricao}}</td>

                        <td>
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-danger"
                                   href="{{route('cotacao.pdf',$crypt::encrypt($cotacao->idcotacao))}}"
                                   target="_blank">
                                    <span
                                            class="glyphicon glyphicon glyphicon-print"
                                            aria-hidden="true"></span> PDF

                                </a>

                                <a class="btn btn-success"
                                   href="{{route('cotacao.reemitir',$crypt::encrypt($cotacao->idcotacao))}}"
                                   >
                                    <span
                                            class="glyphicon glyphicon glyphicon-edit"
                                            aria-hidden="true"></span> Reemitir

                                </a>
                                @if(!$cotacao->proposta)
                                    <a class="btn btn-primary "
                                       href="{{route('proposta.index',$crypt::encrypt($cotacao->idcotacao))}}">
                                    <span
                                            class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                                        Emitir proposta
                                    </a>

                                @endif

                            </div>


                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop