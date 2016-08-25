@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading')

    <div class="form-group row" style="margin: 0px ">
        <div class="col-md-2 col-md-offset-4"> Apolices</div>
        <div class="col-md-3 pull-right">
            {!! Form::text('search',null,['class'=>'search form-control','placeholder'=>'Search']) !!}
        </div>
    </div>
@stop
@section('contentSeg')

    <div class="col-md-12 col-xs-12 apolice">
        <div class="table-responsive">
            <table class="table table-hover table-condensed results">
                <thead>
                <tr class="row">
                    <th>PROPOSTA</th>
                    <th>CPF/CNPJ</th>
                    <th class="hidden-xs">PRODUTOS</th>
                    <th>VEICULO</th>
                    <th class="hidden-xs">VALIDADE</th>
                    <th></th>


                </tr>
                <tr class="warning no-result">
                    <td colspan="4"><i class="fa fa-warning"></i> Dados não encontrado</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($cotacoes as $cotacao)
                    @if(is_object($cotacao->proposta))
                        <tr class="row {!!date('d/m/Y', strtotime($cotacao->proposta->dtvalidade)) > date('d/m/Y') ? 'danger"': ''!!}">
                            <td><a href="#">{{$cotacao->proposta->idproposta}}</a></td>
                            <td><a
                                        href="#">{!! format('cpfcnpj', $cotacao->segurado->clicpfcnpj) !!}</a></td>
                            <td class="hidden-xs">
                                {{--<button class="btn btn-success btn-xs">ver</button>--}}
                                <div>
                                    @foreach($cotacao->produtos as $produto)
                                        {{$produto->produto->nomeproduto }}
                                        @if($cotacao->produtos->count() > 1))
                                        <br>
                                        @endif


                                    @endforeach
                                </div>

                            </td>
                            <td><a href="#"
                                   class="">{!! format('placa',$cotacao->veiculo->veicplaca) !!}</a>
                            </td>
                            <td class="hidden-xs">{!! date('d/m/Y', strtotime($cotacao->proposta->dtvalidade)) !!}</td>
                            <td>


                                @if(!$cotacao->proposta->apoliceseguradora)

                                    @if($cotacao->proposta->propostaseguradora && $cotacao->proposta->propostaseguradora->cd_retorno_seguradora != 0 )
                                        <div class="btn-group">

                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target=".modal-error"
                                                    message="erro{{$cotacao->proposta->idproposta}}" id="erro">Ver Erro
                                            </button>
                                            <input type="hidden" id="erro{{$cotacao->proposta->idproposta}}"
                                                   value="Proposta:{{$cotacao->proposta->idproposta}} {{$cotacao->proposta->cotacaoseguradora->nm_retorno_seguradora}}">
                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal"
                                                    data-target=".modal-error"
                                                    message="xml{{$cotacao->proposta->idproposta}}" id="xml">XML
                                            </button>
                                            <input type="hidden" id="xml{{$cotacao->proposta->idproposta}}"
                                                   value="{{$cotacao->proposta->cotacaoseguradora->xml_saida}}">

                                            <a href="{{route('apolices.emitir', $cotacao->proposta->idproposta)}}"
                                               class="">
                                                <button type="button" class="btn btn-success btn-xs">Emitir</button>
                                            </a>
                                        </div>
                                    @elseif($cotacao->proposta->cotacaoseguradora && $cotacao->proposta->cotacaoseguradora->cd_retorno_seguradora != 0)
                                        <div class="btn-group">

                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target=".modal-error"
                                                    message="erro{{$cotacao->proposta->idproposta}}" id="erro">Ver Erro
                                            </button>
                                            <input type="hidden" id="erro{{$cotacao->proposta->idproposta}}"
                                                   value="Proposta:{{$cotacao->proposta->idproposta}}  {{$cotacao->proposta->cotacaoseguradora->nm_retorno_seguradora}}">

                                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal"
                                                    data-target=".modal-error"
                                                    message="xml{{$cotacao->proposta->idproposta}}" id="xml">XML
                                            </button>
                                            <input type="hidden" id="xml{{$cotacao->proposta->idproposta}}"
                                                   value="{{$cotacao->proposta->cotacaoseguradora->xml_saida}}">

                                            <a href="{{route('apolices.emitir', $cotacao->proposta->idproposta)}}"
                                               class="">
                                                <button type="button" class="btn btn-success btn-xs">Emitir</button>
                                            </a>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{route('apolices.emitir', $cotacao->proposta->idproposta)}}"
                                               class="">
                                                <button type="button" class="btn btn-info btn-xs">Emitir</button>
                                            </a>
                                        </div>
                                    @endif


                                @elseif($cotacao->proposta->apoliceseguradora->cd_retorno_seguradora == 0)
                                    <a href="{{route('apolices.pdf', $cotacao->proposta->idproposta)}}" target="_blank">
                                        <span class="glyphicon glyphicon-save-file"></span> PDF - Apolice </a>
                                @endif

                            </td>


                        </tr>
                    @endif
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

@section('pagination')
    {{$cotacoes->render()}}
@stop