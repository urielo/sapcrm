@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Negociações')
@section('contentSeg')

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead style="font-size: 13px;">
                <tr>
                    <th>Nº PROPOSTA</th>
                    <th>CPF/CNPJ</th>
                    <th>SEGURADO</th>
                    <th>VEICULO</th>
                    <th>VALIDADE</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($cotacoes as $cotacao)
                    @if(is_object($cotacao->proposta))
                        <tr>
                            <td><a href="#" class="">{{$cotacao->proposta->idproposta}}</a></td>
                            <td><a href="#" class="">{!! format('cpfcnpj', $cotacao->segurado->clicpfcnpj) !!}</a></td>
                            <td>{!! nomeCase($cotacao->segurado->clinomerazao) !!}</td>
                            <td><a href="#" class="">{!! format('placa',$cotacao->veiculo->veicplaca) !!}</a></td>
                            <td>{!! date('d/m/Y', strtotime($cotacao->proposta->dtvalidade)) !!}</td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <a href="#" class="">
                                            <button type="button" class="btn btn-danger btn-xs">Anular</button>
                                        </a>
                                        <a href="#" class="">
                                            <button type="button" class="btn btn-primary btn-xs">Negociar</button>
                                        </a>
                                        <a href="#" class="">
                                            <button type="button" class="btn btn-success btn-xs">Efetivar</button>
                                        </a>
                                    </div>
                                </center>
                            </td>


                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <center>{{$cotacoes->render()}}</center>
        </div>

    </div>
@stop