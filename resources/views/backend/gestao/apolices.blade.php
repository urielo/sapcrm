@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading','Apolices')

@section('contentSeg')

    <div class="col-md-12 col-xs-12 apolice">
        <div class="table-responsive">
            <table class="table table-hover table-condensed  table-datatable">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Segurado</th>
                    <th>Placa</th>
                    @if(isset($apolices))
                        <th>Proposta</th>
                        <th>Certificado</th>
                    @endif
                    <th class="hidden-xs">Corretor</th>
                    <th>{{isset($status) && $status ? 'Status': null}}</th>
                </thead>
                <tbody>

                @if($propostas)
                    @foreach($propostas as $proposta)
                        <tr>
                            <th>{{$proposta->idproposta}}</th>
                            <td><a href="#{{$proposta->cotacao->segurado->clicpfcnpj}}">
                                    {{nomeCase($proposta->cotacao->segurado->clinomerazao)}}
                                </a></td>
                            <td><a href="#{{$proposta->veiculo->veicid}}">
                                    {{format('placa',$proposta->veiculo->veicplaca)}}
                                </a></td>
                            <td><a href="#{{$proposta->cotacao->corretor->idcorretor}}">
                                    {{nomeCase($proposta->cotacao->corretor->corrnomerazao)}}
                                </a></td>
                            <td>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-sm modal-call" data-toggle="modal"
                                       data-target=".modal-show"
                                       data-url="{{route('apolices.show',$proposta->idproposta)}}"
                                       id="showinfo">Emitir
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm modal-call"
                                       data-toggle="modal"
                                       data-target=".modal-show"
                                       data-url="{{route('proposta.cancela',$crypt::encrypt($proposta->idproposta))}}"
                                       id="">Cancelar
                                    </button>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                @elseif($apolices)
                    @foreach($apolices as $apolice)
                        <tr>
                            <th>{{$apolice->id}}</th>
                            <td><a href="#{{$apolice->proposta->cotacao->segurado->clicpfcnpj}}">
                                    {{nomeCase($apolice->proposta->cotacao->segurado->clinomerazao)}}
                                </a>
                            </td>
                            <td><a href="#{{$apolice->proposta->veiculo->veicid}}">
                                    {{format('placa',$apolice->proposta->veiculo->veicplaca)}}
                                </a>
                            </td>
                            <td><a href="#">
                                    {{$apolice->id_proposta_sap}}
                                </a>
                            </td>
                            <td><a href="#">
                                    {{$apolice->id_apolice_seguradora}}
                                </a>
                            </td>
                            <td><a href="#{{$apolice->proposta->cotacao->corretor->idcorretor}}">
                                    {{nomeCase($apolice->proposta->cotacao->corretor->corrnomerazao)}}
                                </a>
                            </td>

                            <td>

                                @if($status)
                                    {{$apolice->cancelado->motivo->descricao}}
                                @else
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm modal-call" data-toggle="modal"
                                           data-target=".modal-show"
                                           data-url="{{route('apolices.showemiditas',$apolice->id_proposta_sap)}}"
                                           id="showinfo">Apolices
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm modal-call"
                                           data-toggle="modal"
                                           data-target=".modal-show"
                                           data-url="{{route('apolices.cancela',$crypt::encrypt($apolice->id))}}"
                                           id="">Cancelar
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                @endif


                </tbody>
            </table>
        </div>

        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Emissao/Emitidas"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>




@stop

