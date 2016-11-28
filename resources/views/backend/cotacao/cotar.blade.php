@extends('layouts.cotacao')

@section('panelcolor','info')
@section('heading','Cotação')

@section('contentSeg')
    {!!Form::open([ 'method' =>'post', 'route' =>['cotacao.salvar'] , 'id' => 'form-cotacao' ]) !!}




    <div class="row">
        <div class="col-md-6 col-md-offset-3 remove-class" data-target="col-md-offset-3">

            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="row panel panel-default">

                        <div class="panel-body panel-body-sm">
                            <div class="col-md-4 col-xs-12 ">
                                <strong class="radio radio-label" style="text-align: center;"> Renova? </strong>
                            </div>
                            <div class="col-md-4 col-xs-4 col-md-offset-0 col-xs-offset-2">
                                <div class="radio">
                                    <label for="renova-sim">
                                        {!! Form::radio('renova',1,false,['id'=>'renova-sim']) !!}
                                        Sim
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-4 ">
                                <div class="radio">
                                    <label for="renova-nao">
                                        {!! Form::radio('renova',0,true,['id'=>'renova-nao']) !!}
                                        Não
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-3 col-xs-5 ">
                    {{Form::label('codefip-value','Fipe',['class'=>'label label-default'])}}
                    <div class=" form-group input-group input-group-sm">

                        {!! Form::text('codefipe',($cotacao->veiculo->veiccodfipe ? $cotacao->veiculo->veiccodfipe : ''),
                        [
                            'class'=>'form-control form-control-xs fipe',
                            'id'=>'codefip-value',
                            'placeholder'=>'000000-0',
                            'data-veiculo'=>'#veiculo',

                          ]
                          ) !!}

                        <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm btn-xs"
                            data-target="#codefip-value"
                            href="{{route('fipe.search')}}"
                            type="button"
                            id="search-fipe">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
                    </div>

                </div>

                <div class="col-md-9 col-xs-7">

                    <div class="form-group form-group-sm">
                        {{Form::label('veiculo','Veículo',['class'=>'label label-default'])}}

                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                {{Form::select('tipoveiculo',
                                    $tipos::where('status_id',1)->lists('desc', 'idtipoveiculo'),1,
                                    ['class'=>'selectpicker form-control' ,'data-style'=>'btn-default btn-sm',])}}
                            </span>
                            {!! Form::text('veiculo','',[
                            'class'=>'form-control form-control-sm',
                            'id'=>'veiculo' ,'data-url'=>route('ajax.modelo'),
                            'placeholder'=>'Modelo do veículo']) !!}

                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-xs-8">

                    <div class="form-group form-group-sm">
                        <label for="anomodelo" class="label label-default">Ano Modelo - Combustivel -
                            Valor</label>

                        <meta name="anomodelo" value="{{($cotacao->veiculo->veicano ? $cotacao->veiculo->veicano : '')}}">
                        <select name="anomodelo" id="anomodelo" class="form-control form-control-sm">
                            <option value="1">Escolha um modelo...</option>
                        </select>
                        {{Form::hidden('combustivel',null)}}
                    </div>
                </div>

                <div class="col-md-2 col-xs-4">
                    <div class="form-group form-group-sm">

                        {{Form::label('indautozero','Auto 0KM?',['class'=>'label label-default'])}}
                        {{Form::select('indautozero',['Não','Sim'],0,['class'=>'form-control form-control-sm','id'=>'indautozero'])}}

                    </div>
                </div>


                <div class="col-md-4 col-xs-7">

                    <div class="form-group form-group-sm " id="input-cpfcnpj">


                        {{Form::label('cpfcnpj','CPF/CNPJ do Segurado',['class'=>'label label-default', 'id'=>'label-cpfcnpj'])}}
                        {!! Form::text('cpfcnpj',($cotacao->segurado->clicpfcnpj ? $cotacao->segurado->clicpfcnpj : ''),
                        ['class'=>'form-control form-control-sm cpfcnpj',
                        'id'=>'cpfcnpj',
                        'data-target-input' => '#input-cpfcnpj',
                        'data-target-label' => '#label-cpfcnpj',
                         'placeholder'=>'000.000.000-00 ']
                        ) !!}
                    </div>
                </div>


            </div>

            <div class="row hide produto-pagamento">
                <!--Incio - Escolha Produtos Master-->

                <meta name="produto-master" value="{{(isset($produto_master) ? $produto_master : '')}}">
                <meta name="produto-opcionais" value="{{(isset($produto_opcionais) ? json_encode($produto_opcionais, JSON_PRETTY_PRINT) : '')}}">
                <meta name="produto-opcionais2" value="{{(isset($produto_opcionais) ? json_encode($produto_opcionais) : '')}}">
                <div class="col-md-6 ">
                    <div class="panel panel-default " id="panelprodutosmaster">
                        <div class="panel-heading panel-heading-sm">
                            <h2 class="panel-title" style="text-align: center;">Produtos</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row produto" id="produtos">

                            </div>

                        </div>
                    </div>
                </div>
                <!--Fim- Escolha Produtos Master-->


                <!--Incio - Escolha Produtos Opcional-->
                <div class="col-md-6">
                    <div class="panel panel-default " id="panelprodutosopcional">
                        <div class="panel-heading panel-heading-sm">
                            <h2 class="panel-title" style="text-align: center;">Opcionais</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row produto opcionais" id="produtosopcionais">
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fim- Escolha Produtos Opcional-->


            </div>

        </div>
        <div class="col-md-6 hide produto-pagamento">
            <div class="row">

                <!--Inicio - Escolha Margem-->
                <div class="col-md-12">
                    <div class="panel panel-default" id="panelmargem">
                        <div class="panel-body ">

                            <div class="row">
                                <meta name="comissao" value="{{$cotacao->comissao ? $cotacao->comissao :''}}">
                                @if(Auth::user()->hasRole('altera-comissao'))

                                    @role('altera-comissao')
                                    <div class="col-md-3 ">
                                        <div class="form-group form-group-sm">

                                            <label for="comissao" class="label label-default">Comissão</label>
                                            <div class="input-group">
                                                <select name="comissao" id="comissao"
                                                        class=" form-control form-control-sm"
                                                >
                                                    <option value="{{Auth::user()->corretor->corrcomissaopadrao}}"
                                                            selected>{{Auth::user()->corretor->corrcomissaopadrao}}</option>
                                                    <option value="{{Auth::user()->corretor->corrcomissaomin}}">{{Auth::user()->corretor->corrcomissaomin}}</option>
                                                </select>


                                                <span class="input-group-addon" id="porcentsimbol">%</span>
                                            </div>


                                        </div>


                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-warning alert-sm text-center">
                                            <h5>Valor da comissão <br>
                                                <strong id="valor-comissao"></strong></h5>
                                        </div>
                                    </div>
                                    @endrole
                                @else

                                    {!! Form::hidden('comissao', Auth::user()->corretor->corrcomissaopadrao, ['id'=>'comissao']) !!}

                                @endif


                                <div class="col-md-4 {{Auth::user()->hasRole('altera-comissao') ? '':'col-md-offset-4'}}">
                                    <div class="alert alert-success alert-sm">
                                        <h5 style="text-align: center;">Total a vista<br> <strong
                                                    id="valortotal"></strong></h5>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="table-responsive">
                            <table class="table table-condensed table-sm text-center"
                                   style="margin-bottom:0;">
                                <thead>
                                <tr>

                                    @foreach($formas::all() as $forma)
                                        <meta name="forma-pagamento"
                                              id-forma="{{$forma->idformapgto}}"
                                              data-maxparcela="{{$forma->nummaxparc}}"
                                              data-juros="{{$forma->taxamesjuros}}"
                                              data-parce-sem-juros="{{$forma->numparcsemjuros}}"
                                        >
                                        <th class="formas_pagamento" id-forma="{{$forma->idformapgto}}"
                                            data-target="#forma_id_{{$forma->idformapgto}}"
                                        > {{ $forma->descformapgto }}</th>

                                    @endforeach

                                </tr>


                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($formas::all() as $forma)

                                        <td class="table-responsive">
                                            <table class="table table-condensed table-striped"
                                                   id="forma_id_{{$forma->idformapgto}}" style="margin-bottom:0;">
                                                <thead>
                                                <tr>
                                                    <th>Qt.</th>
                                                    <th>Desc</th>
                                                    <th>Juros</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                        </td>

                                    @endforeach
                                </tr>

                                </tbody>
                            </table>


                        </div>

                        <table class="table table-sm hide" style="margin-top: 0 " id="botton-cotacao">
                            <tbody>
                            <tr>
                                <td class="pull-left">

                                    <div class="button-group btn-group">

                                        <button class="btn   btn-info button-cotacao-submit" type="submit"
                                                id="salvar"><strong>Salvar, Imprimir
                                            ou enviar email da cotação</strong>
                                        </button>


                                    </div>


                                </td>
                                <td class="pull-right">

                                    <div class="button-group btn-group">

                                        {{--<button class="btn   btn-info button-cotacao-submit" type="submit"--}}
                                                {{--id="salvar">Salvar e imprimir--}}
                                            {{--ou email--}}
                                        {{--</button>--}}
                                        <button class="btn btn-primary button-cotacao-submit" type="submit"
                                                id="proposta">Emitir
                                            proposta
                                        </button>
                                        <button class="btn btn-danger button-cotacao-submit" type="submit"
                                                id="nova">Nova
                                        </button>

                                    </div>


                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>


                </div>
                <!--Fim- Escolha Margem-->
            </div>
        </div>
    </div>









    {!! Form::close() !!}






@stop

@section('script')
    <script src="{{ theme('js/cotacao.js') }}"></script>
@stop