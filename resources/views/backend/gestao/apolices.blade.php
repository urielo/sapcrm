@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading','Apolices')
@section('contentSeg')

    <div class="col-md-12 apolice">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr >
                    <th>Nº PROPOSTA</th>
                    <th>CPF/CNPJ</th>
                    <th>PRODUTOS</th>
                    <th>VEICULO</th>
                    <th>VALIDADE</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($cotacoes as $cotacao)
                    @if(is_object($cotacao->proposta))
                        <tr {!!date('d/m/Y', strtotime($cotacao->proposta->dtvalidade)) < date('d/m/Y') ? 'class="table-danger"': ''!!}>
                            <td><a href="#" class="">{{$cotacao->proposta->idproposta}}</a></td>
                            <td><a href="#" class="">{!! format('cpfcnpj', $cotacao->segurado->clicpfcnpj) !!}</a></td>
                            <td>

                                @foreach($cotacao->produtos as $produto)
                                    <p style="margin-bottom: 0px">
                                        {{$produto->produto->nomeproduto}}
                                    </p>
                                @endforeach


                            </td>
                            <td><a href="#" class="">{!! format('placa',$cotacao->veiculo->veicplaca) !!}</a></td>
                            <td>{!! date('d/m/Y', strtotime($cotacao->proposta->dtvalidade)) !!}</td>
                            <td >
                                <center>
                                    <div class="btn-group">
                                        <a href="#" class="">
                                            <button type="button" class="btn btn-danger btn-xs">Anular</button>
                                        </a>
                                        <a href="{{route('vendas.negociar', $cotacao->idcotacao)}}" class="">
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