@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading','Apolices')

@section('contentSeg')

    <div class="col-md-12 col-xs-12 apolice">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Segurado</th>
                    <th>Placa</th>
                    <th>Data do pagamento</th>
                    <th class="hidden-xs">Corretor</th>
                    <th></th>
                </thead>
                <tbody>


                @foreach($propostas as $proposta)
                    <tr>
                        <th>{{$proposta->idproposta}}</th>
                        <td><a href="#{{$proposta->cotacao->segurado->clicpfcnpj}}">
                                {{nomeCase($proposta->cotacao->segurado->clinomerazao)}}
                            </a></td>
                        <td><a href="#{{$proposta->cotacao->veiculo->veicid}}">
                                {{format('placa',$proposta->cotacao->veiculo->veicplaca)}}
                            </a></td>
                        <td>{{( is_object($proposta->cobranca) ? showDate($proposta->cobranca->dtpagamento) : '||') }}</td>
                        <td><a href="#{{$proposta->cotacao->corretor->idcorretor}}">
                                {{nomeCase($proposta->cotacao->corretor->corrnomerazao)}}
                            </a></td>
                        <td>

                            <div class="btn-group" role="group">

                                @if($proposta->idstatus == 15)
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target=".modal-show"
                                            href="#"
                                            {{--href="{{route('show.confirmapgto',$proposta->proposta->idproposta)}}"--}}
                                            id="emitir">Emitir
                                    </button>
                                @elseif($proposta->idstatus == 24)
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target=".modal-show"
                                            href="#"
                                            {{--href="{{route('show.confirmapgto',$proposta->proposta->idproposta)}}"--}}
                                            id="emitir">Emitir
                                    </button>
                                @elseif($proposta->idstatus == 18)
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target=".modal-show"
                                            href="#"
                                            {{--href="{{route('show.confirmapgto',$proposta->proposta->idproposta)}}"--}}
                                            id="emitir">
                                    </button>
                                @endif


                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade modal-error" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Descrição do Erro</h4>
                    </div>
                    <div class="modal-body danger">
                        <p id="msgdeerro"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop

