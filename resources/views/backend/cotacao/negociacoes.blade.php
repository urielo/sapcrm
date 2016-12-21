@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Cotações - '. $title)
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
                    <th>Usuário</th>
                    @if(Auth::user()->hasRole('admin'))
                        <th>Corretor(a)</th>
                    @endif
                    <th>Status</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($cotacoes as $cotacao)
                    <tr>
                        <th><a href="#" class="">{{$cotacao->idcotacao}}</a></th>
                        <th><a href="#" class=""> {{$cotacao->segurado->clicpfcnpj}}</a></th>
                        <td>{!! date('d/m/Y', strtotime($cotacao->dtcreate)) !!}</td>
                        <td>{!! date('d/m/Y', strtotime($cotacao->dtvalidade)) !!}</td>
                        <td>{!! strtoupper($cotacao->usuario->nome) !!}</td>
                        @if(Auth::user()->hasRole('admin'))
                        <td>{{strtoupper(Auth::user()->corretor->corrnomerazao)}}</td>
                        @endif

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


                                @if(!$cotacao->proposta && $cotacao->idstatus == 9)
                                    <a class="btn btn-primary "
                                       href="{{route('proposta.index',$crypt::encrypt($cotacao->idcotacao))}}">
                                    <span
                                            class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                                        Emitir proposta
                                    </a>

                                    <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                       data-target=".modal-show"
                                       href="{{route('cotacao.showemail',$crypt::encrypt($cotacao->idcotacao))}}"
                                       id="showinfo"><i class="glyphicon glyphicon-envelope"></i> Email
                                    </a>

                                @endif

                            </div>


                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Emissao/Emitidas"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                </div>
            </div>
        </div>

    </div>
@stop