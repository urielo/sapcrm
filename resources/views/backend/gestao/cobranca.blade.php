@extends('layouts.cotacao')


@section('panelcolor','warning')
@section('heading','Cobrança')
@section('contentSeg')

    <div class="col-md-12 apolice table-responsive"">
        <div class="table">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Nº PROPOSTA</th>
                    <th>SEGURADO</th>
                    <th>CORRETOR</th>
                    <th>VEICULO</th>
                    <th>VALIDADE</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($propostas as $proposta)

                        <tr>
                            <td><a href="#" class="">{{$proposta->idproposta}}</a></td>
                            <td><a href="{{route('show.segurado',$proposta->cotacao->segurado->clicpfcnpj)}}" class=""
                                   data-toggle="modal"
                                   data-target=".modal-show"
                                   id="linksegurado">{!! nomeCase($proposta->cotacao->segurado->clinomerazao) !!}</a></td>
                            <td><a href="#" class="">{!! nomeCase($proposta->cotacao->corretor->corrnomerazao) !!}</a></td>
                            <td><a href="#" class="">{!! format('placa',$proposta->cotacao->veiculo->veicplaca) !!}</a></td>
                            <td>{!! date('d/m/Y', strtotime($proposta->dtvalidade)) !!}</td>
                            <td>


                                <div class="btn-group" role="group">

                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target=".modal-show"
                                            id="pagar">Efetuar Pagamento
                                    </button>


                                </div>

                                <div class="btn-group" role="group">

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target=".modal-show"
                                            href="{{route('show.cancelaproposta',$proposta->idproposta)}}"
                                            id="cancelar">Cancelar
                                    </button>


                                </div>


                            </td>


                        </tr>

                @endforeach
                </tbody>
            </table>
            <center>{{$propostas->render()}}</center>
        </div>



        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>


@stop