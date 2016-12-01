@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading','Aprovações')
@section('contentSeg')

    <div class="col-md-12 apolice ">
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-datatable">
            <thead>
            <tr>
                <th># Proposta</th>
                <th>Segurado</th>
                <th>Corretor</th>
                <th>Data vencimento boleto</th>
                <th>Primeira parcela</th>
                <th>Forma de pagamento</th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            @foreach ($propostas as $proposta)

                <tr>
                    <td><a href="#" class="">{{$proposta->proposta->idproposta}}</a></td>
                    <td><a href="{{route('show.segurado',$proposta->proposta->cotacao->segurado->clicpfcnpj)}}" class=""
                           data-toggle="modal"
                           data-target=".modal-show"
                           id="linksegurado">{!! nomeCase($proposta->proposta->cotacao->segurado->clinomerazao) !!}</a>
                    </td>
                    <td><a href="#" class="">{{$proposta->proposta->cotacao->corretor->corrnomerazao}}</a></td>

                    <td>
                        {!! ( empty($proposta->proposta->cobranca->dtvencimento) ? NULL : date('d/m/Y', strtotime($proposta->proposta->cobranca->dtvencimento))) !!}

                    </td>
                    <td><a href="#" class="">R$ {!! format('real',$proposta->proposta->primeiraparc) !!}</a></td>
                    <td>{!! $proposta->proposta->formapg->descformapgto !!}</td>
                    <td>


                        <div class="btn-group" role="group">

                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                    data-target=".modal-show"
                                    href="{{route('show.confirmapgto',$proposta->proposta->idproposta)}}"
                                    id="comfirmapgto">Confirmar
                            </button>


                        </div>

                        <div class="btn-group" role="group">
                            <a href="{{route('cobranca.recusar',$proposta->proposta->idproposta)}}">
                                <button type="button" class="btn btn-danger btn-xs"
                                        id="recusar">Recusar
                                </button>
                            </a>

                        </div>


                    </td>


                </tr>

            @endforeach
            </tbody>
        </table>

    </div>



    <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    </div>


@stop