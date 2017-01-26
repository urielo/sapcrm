@extends('layouts.cotacao')
@section('panelcolor','warning')
@section('heading','Cobrança')
@section('contentSeg')
    <div class="col-md-12 col-xs-12 ">
        <div class=" apolice table-responsive">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th># PROPOSTA</th>
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
                        <td>
                            <div class="btn-group">
                            <a href="{{route('show.proposta',$proposta->idproposta)}}" class="" data-toggle="modal"
                               data-target=".modal-show"
                               id="showinfo">{{$proposta->idproposta}}
                            </a>
                                <a href="{{route('proposta.pdf',$crypt::encrypt($proposta->idproposta))}}" target="_blank">
                                    <button type="button" class="btn btn-primary btn-xs">PDF</button>
                                </a>
                            </div>
                        </td>
                        <td><a href="{{route('show.segurado',$proposta->cotacao->segurado->clicpfcnpj)}}" class=""
                               data-toggle="modal"
                               data-target=".modal-show"
                               id="showinfo">{!! nomeCase($proposta->cotacao->segurado->clinomerazao) !!}</a></td>
                        <td><a href="#" class="">{!! nomeCase($proposta->cotacao->corretor->corrnomerazao) !!}</a></td>
                        <td><a href="#" class="">{!! format('placa',$proposta->cotacao->veiculo->veicplaca) !!}</a></td>
                        <td>{!! date('d/m/Y', strtotime($proposta->dtvalidade)) !!}</td>
                        <td>


                            <div class="btn-group" role="group">

                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                        data-target=".modal-show"
                                        href="{{route('show.pagamento',$proposta->idproposta)}}"
                                        id="pagar">Agenda Pagamento
                                </button>


                            </div>

                            <div class="btn-group" role="group">

                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
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