@extends('layouts.cotacao')

@section('panelcolor','info')
@section('heading','Cotação')

@section('contentSeg')
    {!!Form::open([ 'method' =>'post', 'route' =>['cotacao.gerar'] , 'id' => 'formcotacao' ]) !!}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="row panel panel-body">

                <div class="col-md-3 col-xs-12 ">
                    <strong class="radio" style="text-align: center"> Tipos de veículos: </strong>
                </div>
                @foreach($tipos::where('status_id',1)->get() as $index => $tipo)
                    <div class="col-md-4 col-xs-4 {{ ($index == 0 ? 'col-md-offset-0 col-xs-offset-2': '') }}">
                        <div class="radio">
                            <label for="{{$tipo->desc}}">
                                {!! Form::radio('tipoveiculo',$tipo->idtipoveiculo, ($index == 0 ? true: false),['id'=>$tipo->desc]) !!}
                                {{$tipo->desc}}
                            </label>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>


    </div>

    <div class="row">
        <div class="col-md-2 col-xs-5 ">
            {{Form::label('codefip-value','Fipe',['class'=>'label label-default'])}}
            <div class=" form-group input-group input-group-sm">

                {!! Form::text('codefipe','',
                [
                    'class'=>'form-control form-control-xs',
                    'id'=>'codefip-value',
                    'placeholder'=>'000000-0',
                    'data-veiculo'=>'#veiculo'
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

        <div class="col-md-4 col-xs-7">

            <div class="form-group form-group-sm">
                {{Form::label('veiculo','Veículo',['class'=>'label label-default'])}}
                {!! Form::text('veiculo','',['class'=>'form-control form-control-sm','id'=>'veiculo', 'placeholder'=>'Modelo do veículo']) !!}
            </div>
        </div>

        <div class="col-md-3 col-xs-8">

            <div class="form-group form-group-sm">
                <label for="anom" class="label label-default">Ano Modelo - Combustivel -
                    Valor</label>
                <select name="anom" id="anom" class="form-control form-control-sm">
                    <option value="0">Escolha um modelo...</option>
                </select>
            </div>
        </div>

        <div class="col-md-1 col-xs-4">
            <div class="form-group form-group-sm">

                {{Form::label('indautozero','Auto 0KM?',['class'=>'label label-default'])}}
                {{Form::select('indautozero',['Não','Sim'],0,['class'=>'form-control form-control-sm','id'=>'indautozero'])}}

            </div>
        </div>


        <div class="col-md-2 col-xs-7">

            <div class="form-group form-group-sm">


                {{Form::label('cpfcnpj','CPF/CNPJ do Segurado',['class'=>'label label-default'])}}
                {!! Form::text('cpfcnpj','',
                ['class'=>'form-control form-control-sm',
                'id'=>'cpfcnpj',
                 'placeholder'=>'000.000.000-00 ']
                ) !!}
            </div>
        </div>



    </div>


    <div class="row hide" id="produtopagamento">

    @role('altera-comissao')
    <!--Inicio - Escolha Margem-->
        <div class="col-md-4 ">
            <div class="panel panel-default" id="panelmargem">
                <div class="panel-body">
                    <div class="row">

                        <div class="form-group form-group-sm">
                            <div class="col-md-4 ">
                                <label for="anom" class="label label-default">Comissão</label>

                                <div class="input-group">

                                    <select name="comissao" id="comissao"
                                            class="selectpicker form-control form-control-sm"
                                            style="padding: 0;">
                                        <option value="{{Auth::user()->corretor->corrcomissaopadrao}}"
                                                selected>{{Auth::user()->corretor->corrcomissaopadrao}}</option>
                                        <option value="{{Auth::user()->corretor->corrcomissaomin}}">{{Auth::user()->corretor->corrcomissaomin}}</option>
                                    </select>
                                    <span class="input-group-addon" id="porcentsimbol">%</span>
                                </div>

                            </div>

                            <div class="col-md-6 col-md-offset-1">
                                <div class="alert alert-success alert-sm">
                                    <h5  style="text-align: center;">Total a vista<br> <strong
                                                id="valortotal"></strong></h5>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--Fim- Escolha Margem-->
    @endrole

    <!--Incio - Escolha Produtos Master-->
        <div class="col-md-4 ">
            <div class="panel panel-default " id="panelprodutosmaster">
                <div class="panel-heading">
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
        <div class="col-md-4 ">
            <div class="panel panel-default " id="panelprodutosopcional">
                <div class="panel-heading">
                    <h2 class="panel-title" style="text-align: center;">Opcionais</h2>
                </div>
                <div class="panel-body">
                    <div class="row produto" id="produtosopcionais">
                    </div>
                </div>
            </div>
        </div>
        <!--Fim- Escolha Produtos Opcional-->


    </div>

    <div class="row pull-right hide">
        <div class="col-md-12">

            <div class="button-group">

                <button class="btn btn-success " type="button">Salvar</button>
                <button class="btn btn-primary " type="button">Proposta</button>

            </div>
        </div>


    </div>






    {!! Form::close() !!}






@stop