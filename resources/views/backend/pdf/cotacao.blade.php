@extends('layouts.pdf')



@section('content')

    <div class="row">
        <div class="col-md-12">
            <htmlpageheader class="pull-right" name="page-header">
                <div class="cotacao-header">
                    <img src="{{ theme('images/logo.png') }}" alt="" style="width: 100px;margin-right: 250px;"> Cotação
                </div>

            </htmlpageheader>

        </div>


        <div class="box-large">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Cotação nº: <span class="normal">{{$cotacao->idcotacao}}</span></th>
                    <th>Data inicio: <span class="normal"> {{date('d/m/Y', strtotime($cotacao->created_at))}}</span></th>
                    <th>Data validade: <span class="normal"> {{date('d/m/Y', strtotime($cotacao->validade))}}</span>
                    </th>

                </tr>
                </thead>
            </table>
        </div>

        <div class="box-large">
            <p>
                {{$cotacao->code_fipe}} / {{$cotacao->fipe->marca}}
                / {{$cotacao->fipe->modelo}}, {{$cotacao->ano_veiculo}},
                 {{$cotacao->combustivel->nm_comb}} | valor na fipe R$ {{format('real',$cotacao->fipe->anovalor()->where('idcombustivel',$cotacao->combustivel_id)->where('ano',$cotacao->ano_veiculo)->first()->valor)}}

            </p>
        </div>
        <div class="col-md-12 box-large">
            <table class="table table-condensed table-striped text-center">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Cobertura</th>
                    <th >LMI  <span class="info">*</span> </th>
                </tr>
                </thead>
                <tbody class="text-justify">
                @foreach($cotacao->produtos as $produto)
                    <tr>
                        <td>{{$produto->produto->nomeproduto}}</td>
                        <td>{{$produto->produto->descproduto}}</td>
                        <td>{{$produto->produto->caractproduto}}</td>
                        <td>{{($produto->produto->precoproduto()->where('idprecoproduto',$produto->idprecoproduto)->first()->lmiproduto ? $produto->produto->precoproduto()->where('idprecoproduto',$produto->idprecoproduto)->first()->lmiproduto : 'S/N') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="info"> <p>(*) LMI: Limite Máximo de Indenização</p> </div>

        </div>

        <div class="box-large">

            <div class="box-small alert alert-success text-justify">
                Total a vista<br>
                <strong>R$ {{format('real',$cotacao->premio)}}</strong>
            </div>

            <h3>Formas de pagamento</h3>
            <table class="table table-striped td-no-border text-center">
                <thead>
                <tr>
                    @foreach($formas as $forma)
                        <th>{{$forma->forma_pagamento}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach($formas as $forma)
                        <td>
                            <table class="table table-striped text-justify">
                                <thead>
                                <tr>
                                    <th>Qt</th>
                                    <th>Parcela</th>
                                    <th>Juros</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody class="nospace">
                                @foreach($forma->parcelas as $key => $parcela)
                                    <tr {{($key % 2 == 0 ? 'class=formas_pagamento': null)}}>
                                        <td>{{$parcela->quantidade}}x</td>
                                        <td>{{($parcela->primeira_parcela != $parcela->demais_parcela ? 'Com sinal de R$ '. format('real',$parcela->primeira_parcela) . ' e mais '.
                                         ($parcela->quantidade - 1).'x R$ ' .format('real',$parcela->demais_parcela)
                                        : 'R$ '.format('real',$parcela->primeira_parcela))}}</td>
                                        <td>{{str_replace('.',',',$parcela->taxa_juros)}}%</td>
                                        <td>R$ {{format('real',$parcela->valor_final)}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    @endforeach
                </tr>

                </tbody>
            </table>
        </div>


        <div class="box-large">
            <h3>Fale com seu consultor</h3>

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Corretor(a): <span class="normal">{{strtoupper($cotacao->corretor->corrnomerazao )}}</span></th>


                </tr>
                <tr>
                    <th>Consultor(a): <span class="normal"> {{strtoupper($cotacao->usuario->nome)}}</span></th>
                    <th>E-mail: <span class="normal"> <a href="mailto:{{$cotacao->usuario->email}}"></a>{{$cotacao->usuario->email}}</span>
                    </th>
                </tr>
                </thead>
            </table>


        </div>

        <div class="box-large obs">

            <p> Consultar condições gerais do seguro em: <a href="wwww.seguroautopratico.com.br/contratos"> wwww.seguroautopratico.com.br/contratos</a></p>

            <h4> <a href="wwww.seguroautopratico.com.br"> wwww.seguroautopratico.com.br</a></h4>
        </div>

    </div>









@stop

