@extends('layouts.cotacao')

@section('panelcolor','success')
@section('heading','Proposta')

@section('contentSeg')

    {!!Form::open([ 'method' =>'post', 'route' =>['proposta.emitir'] , 'id' => 'form-cotacao' ]) !!}
    {!!  Form::hidden('fipe',$cotacao->veiculo->veiccodfipe)!!}
    {!!  Form::hidden('ano',$cotacao->veiculo->veicano)!!}
    {!!  Form::hidden('combustivel',$cotacao->veiculo->veictipocombus)!!}
    {!!  Form::hidden('autozero',$cotacao->veiculo->veicautozero)!!}
    {!!  Form::hidden('tipoveiculo',$cotacao->veiculo->veiccdveitipo)!!}
    {!!  Form::hidden('cotacao_id',$cotacao->idcotacao)!!}

    <div class="row proposta-form">
        <div class="col-md-6 col-xs-12">

            <div class="row" id="segurado-row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row info-veiculo">

                                        <div class="col-md-4">
                                            <strong>Cotação: </strong> {{$cotacao->idcotacao}}

                                        </div>

                                        <div class="col-md-4">
                                            <strong>Emissão: </strong> {{date('d/m/Y', strtotime($cotacao->dtcreate))}}

                                        </div>
                                        <div class="col-md-4">
                                            <strong>Vencimento: </strong> {{date('d/m/Y', strtotime($cotacao->dtvalidade))}}
                                        </div>


                                    </div>
                                </div>
                            </div>


                            @if(strlen($cotacao->segurado->clicpfcnpj) > 11)


                                <div class="row pessoa">
                                    <div class="col-md-3">

                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_cpfnpj','CNPJ',['class'=>'label label-default']) !!}
                                            {{--<label class="label label-default" for="segcpf">CPF</label>--}}
                                            {!! Form::text('seg_cpfnpj',$cotacao->segurado->clicpfcnpj,[
                                            'class' =>'form-control form-control-sm cpfcnpj',
                                            'readonly'=>true,

                                            ]) !!}

                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_nomerazao','Razão social',['class'=>'label label-default']) !!}
                                            {{--<label class="label label-default" for="segcpf">CPF</label>--}}
                                            {!! Form::text('seg_nomerazao',(strlen($cotacao->segurado->clinomerazao) > 5 ? $cotacao->segurado->clinomerazao : NULL ),[
                                            'class' =>'form-control form-control-sm',
                                            ]) !!}

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::label('seg_data_nascimento_inscricao', 'Inscrição',['class'=>'label label-default']) !!}
                                        <div class="input-group input-group-sm date nascimento">
                                            {!! Form::text('seg_data_nascimento_inscricao', (empty($cotacao->segurado->clidtnasc) ? date('d/m/Y',strtotime('-18 year')): date('d/m/Y',strtotime($cotacao->segurado->clidtnasc))),
                                                                       ['class'=> 'form-control form-control-sm',
                                                                       'data-date-format'=> 'dd/mm/yyyy',
                                                                       'placeholder'=> 'DD/MM/YYYY',
                                                                       'readonly'=>true,
                                                                       'id'=>"seg_data_nascimento_inscricao",
                                                                       ]) !!}
                                            <span class="input-group-btn">  <button class="btn btn-secondary"
                                                                                    type="button"><i
                                                            class="glyphicon glyphicon-calendar"></i></button> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_profissao_ramo','Romo Atividade',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_profissao_ramo',$ramos_atividades,
                                            (!empty($cotacao->segurado->clicdprofiramoatividade) ? $cotacao->segurado->clicdprofiramoatividade : '')
                                            ,
                                            ['class'=>'selectpicker form-control form-control-sm',
                                            'data-live-search'=>'true',
                                            'data-style'=>'btn-secondary btn-sm',
                                            'id'=>'seg_profissao_ramo',
                                            'data-size'=>"5"]) !!}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row pessoa">
                                    <div class="col-md-3">

                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_cpfnpj','CPF',['class'=>'label label-default']) !!}
                                            {!! Form::text('seg_cpfnpj',$cotacao->segurado->clicpfcnpj,[
                                            'class' =>'form-control form-control-sm cpfcnpj',
                                            'readonly'=>true,

                                            ]) !!}

                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_nomerazao','Nome',['class'=>'label label-default']) !!}
                                            {!! Form::text('seg_nomerazao',(strlen($cotacao->segurado->clinomerazao) > 5 ? $cotacao->segurado->clinomerazao : NULL ),[
                                            'class' =>'form-control form-control-sm',
                                            ]) !!}

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::label('seg_data_nascimento_inscricao', 'Nascimento',['class'=>'label label-default']) !!}
                                        <div class="input-group input-group-sm date nascimento">
                                            {!! Form::text('seg_data_nascimento_inscricao', (empty($cotacao->segurado->clidtnasc) ? date('d/m/Y',strtotime('-18 year')): date('d/m/Y',strtotime($cotacao->segurado->clidtnasc))),
                                                                       ['class'=> 'form-control form-control-sm',
                                                                       'data-date-format'=> 'dd/mm/yyyy',
                                                                       'placeholder'=> 'DD/MM/YYYY',
                                                                       'readonly'=>true,
                                                                       'id'=>"seg_data_nascimento_inscricao",
                                                                       ]) !!}
                                            <span class="input-group-btn">  <button class="btn btn-secondary"
                                                                                    type="button"><i
                                                            class="glyphicon glyphicon-calendar"></i></button> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_sexo','Sexo',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_sexo',
                                            ['1'=>'Masculino','2'=>'Feminino'],
                                            (!empty($cotacao->segurado->clicdsexo) ? $cotacao->segurado->clicdsexo : 1),
                                            ['class'=>'form-control form-control-sm','id'=>'seg_sexo']) !!}

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_estado_civil','Estado civil',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_estado_civil',
                                            $estados_civis,
                                            (!empty($cotacao->segurado->clicdestadocivil) ? $cotacao->segurado->clicdestadocivil : 1),
                                            ['class'=>'form-control form-control-sm','id'=>'seg_estado_civil']) !!}

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_rg_numero','RG',['class'=>'label label-default']) !!}
                                            {!! Form::text('seg_rg_numero', (!empty($cotacao->segurado->clinumrg) ? $cotacao->segurado->clinumrg : NULL),
                                            ['class'=>'form-control form-control-sm','id'=>'seg_rg_numero','placeholder'=>'0000000000A']) !!}

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_rg_uf','RG - UF',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_rg_uf',
                                            $ufs,
                                            (!empty($cotacao->segurado->clicdufemissaorg) ? $cotacao->segurado->clicdufemissaorg : 1),
                                            ['class'=>'selectpicker form-control form-control-sm',
                                            'data-live-search'=>'true',
                                            'data-style'=>'btn-secondary btn-sm',
                                            'id'=>'seg_rg_uf',
                                             'data-size'=>"5"]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::label('seg_rg_emissao', 'RG - Emissão',['class'=>'label label-default']) !!}
                                        <div class="input-group input-group-sm date nascimento">
                                            {!! Form::text('seg_rg_emissao', (empty($cotacao->segurado->clidtemissaorg) ? date('d/m/Y',strtotime('-1 year')) : date('d/m/Y',strtotime($cotacao->segurado->clidtemissaorg))),
                                                                       ['class'=> 'form-control form-control-sm',
                                                                       'data-date-format'=> 'dd/mm/yyyy',
                                                                       'placeholder'=> 'DD/MM/YYYY',
                                                                       'readonly'=>true,
                                                                       'id'=>"seg_rg_emissao",
                                                                       ]) !!}
                                            <span class="input-group-btn">  <button class="btn btn-secondary"
                                                                                    type="button"><i
                                                            class="glyphicon glyphicon-calendar"></i></button> </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_rg_org','Orgão Emissor',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_rg_org',
                                            $orgaos_emissores,
                                            (!empty($cotacao->segurado->cliemissorrg) ? $cotacao->segurado->cliemissorrg : 'SSP'),
                                            ['class'=>'selectpicker form-control form-control-sm',
                                            'data-live-search'=>'true',
                                            'data-style'=>'btn-secondary btn-sm',
                                            'id'=>'seg_rg_org',
                                            'data-size'=>"5"]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-sm">
                                            {!! Form::label('seg_profissao_ramo','Profissão',['class'=>'label label-default']) !!}
                                            {!! Form::select('seg_profissao_ramo',$profissoes ,
                                            (!empty($cotacao->segurado->clicdprofiramoatividade) ? $cotacao->segurado->clicdprofiramoatividade : '')
                                            ,
                                            ['class'=>'selectpicker form-control form-control-sm',
                                            'data-live-search'=>'true',
                                            'data-style'=>'btn-secondary btn-sm',
                                            'id'=>'seg_profissao_ramo',
                                            'data-size'=>"5"]) !!}
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">

                                        <div class="col-md-7">
                                            {!! Form::label('seg_email','E-mail',['class'=>'label label-default']) !!}
                                            <div class="input-group input-group-sm email">
                                                <span class="input-group-addon">  <i
                                                            class="glyphicon glyphicon-envelope"></i> </span>
                                                {!! Form::text('seg_email',(!empty($cotacao->segurado->cliemail) ? $cotacao->segurado->cliemail : NULL ),[
                                                'class' =>'form-control form-control-sm ',
                                                'id'=>'seg_email'

                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-2">

                                            {!! Form::label('seg_cel_ddd','DDD',['class'=>'label label-default']) !!}
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">  <i
                                                            class="glyphicon glyphicon-phone"></i> </span>
                                                {!! Form::text('seg_cel_ddd',(!empty($cotacao->segurado->clidddcel) ? $cotacao->segurado->clidddcel : NULL ),[
                                                'class' =>'form-control form-control-sm ddd',
                                                'placeholder' =>'99',
                                                'id'=>'seg_cel_ddd'

                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_cel_numero','Celular',['class'=>'label label-default']) !!}

                                                {!! Form::text('seg_cel_numero',(!empty($cotacao->segurado->clinmcel) ? $cotacao->segurado->clinmcel : NULL ),[
                                                'class' =>'form-control form-control-sm cel',
                                                'placeholder' =>'99999-9999',
                                                'id'=>'seg_cel_numero'

                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            {!! Form::label('seg_fixo_ddd','DDD',['class'=>'label label-default']) !!}
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-addon">  <i
                                                            class="glyphicon glyphicon-phone-alt"></i> </span>
                                                {!! Form::text('seg_fixo_ddd',(!empty($cotacao->segurado->clidddfone) ? $cotacao->segurado->clidddfone : NULL ),[
                                                'class' =>'form-control form-control-sm ddd',
                                                'placeholder' =>'99',
                                                'id'=>'seg_fixo_ddd'

                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_fixo_numero','Fixo',['class'=>'label label-default']) !!}

                                                {!! Form::text('seg_fixo_numero',(!empty($cotacao->segurado->clinmfone) ? $cotacao->segurado->clinmfone : NULL ),[
                                                'class' =>'form-control form-control-sm fixo',
                                                'placeholder' =>'9999-9999',
                                                'id'=>'seg_fixo_numero'
                                                ]) !!}
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::label('seg_end_cep','CEP',['class'=>'label label-default']) !!}
                                            <div class="input-group input-group-sm">
                                                {!! Form::text('seg_end_cep',(!empty($cotacao->segurado->clicep) ? $cotacao->segurado->clicep : NULL ),[
                                                'class'=>'form-control form-control-sm cep',
                                                'placeholder'=>'00000-000',
                                                'id'=>'seg_end_cep',
                                                'data-target-logradouro'=>'#seg_end_log',
                                                'data-target-bairro'=>'#seg_end_bairro',
                                                'data-target-uf'=>'#seg_end_uf',
                                                'data-target-cidade'=>'#seg_end_cidade',
                                                ]) !!}
                                                <span class="input-group-btn">
                                                             <button class="btn btn-primary cep"
                                                                     data-target="#seg_end_cep"
                                                                     type="button"
                                                                     id="search-cep">
                                                                 <span class="glyphicon glyphicon-search"></span>
                                                             </button>
                                                </span>
                                            </div>


                                        </div>

                                        <div class="col-md-7">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_log','Logradouro',['class'=>'label label-default']) !!}
                                                {!! Form::text('seg_end_log',(!empty($cotacao->segurado->clinmend) ? $cotacao->segurado->clinmend : NULL ),[
                                                'class' =>'form-control form-control-sm',
                                                'id'=>'seg_end_log'

                                                ]) !!}

                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_num','Numero',['class'=>'label label-default']) !!}
                                                {!! Form::text('seg_end_num',(!empty($cotacao->segurado->clinumero) ? $cotacao->segurado->clinumero : NULL ),[
                                                'class' =>'form-control form-control-sm',
                                                'id'=>'seg_end_num'

                                                ]) !!}

                                            </div>
                                        </div>
                                        <div class="col-md-5">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_cidade','Cidade',['class'=>'label label-default']) !!}
                                                {!! Form::text('seg_end_cidade',(!empty($cotacao->segurado->clinmcidade)  ? $cotacao->segurado->clinmcidade : NULL ),[
                                                'class' =>'form-control form-control-sm',
                                                'id'=>'seg_end_cidade'
                                                ]) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-5">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_bairro','Bairro',['class'=>'label label-default']) !!}
                                                {!! Form::text('seg_end_bairro',(!empty($cotacao->segurado->bairro) ? $cotacao->segurado->bairro : NULL ),[
                                                'class' =>'form-control form-control-sm',
                                                'id'=>'seg_end_bairro'
                                                ]) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_uf','UF',['class'=>'label label-default']) !!}
                                                {!! Form::select('seg_end_uf',
                                                $ufs,
                                                (!empty($cotacao->segurado->clicduf) ? $cotacao->segurado->clicduf : 1),
                                                ['class'=>'selectpicker form-control form-control-sm',
                                                'data-live-search'=>'true',
                                                'data-style'=>'btn-secondary btn-sm',
                                                'id'=>'seg_end_uf',
                                                 'data-size'=>"5"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('seg_end_complemento','Complemento',['class'=>'label label-default']) !!}
                                                {!! Form::text('seg_end_complemento',(!empty($cotacao->segurado->cliendcomplet) ? $cotacao->segurado->cliendcomplet : NULL ),[
                                                'class' =>'form-control form-control-sm',
                                                'id'=>'seg_end_complemento'
                                                ]) !!}

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group form-group-sm">
                                                {!! Form::label('ind_propritetario','Proprietário é o seg?',['class'=>'label label-default']) !!}
                                                {!! Form::select('ind_propritetario',
                                                ['1'=>'Sim','0'=>'Não'],
                                                1,
                                                ['class'=>'form-control form-control-sm ind-proprietario','id'=>'ind_propritetario']) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-6 dados-proprietario hide">

                                            <div class="form-group form-group-sm">
                                                {!! Form::label('prop_nomerazao','Nome',['class'=>'label label-default']) !!}
                                                {!! Form::text('prop_nomerazao','',[
                                                'class' =>'form-control form-control-sm',
                                                'placeholder' =>'Nome do Proprietario',
                                                ]) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-3 dados-proprietario hide">
                                            {!! Form::label('prop_data_nascimento_inscricao', 'Nascimento',['class'=>'label label-default']) !!}
                                            <div class="input-group input-group-sm date nascimento">
                                                {!! Form::text('prop_data_nascimento_inscricao',  date('d/m/Y',strtotime('-18 year')),
                                                                           ['class'=> 'form-control form-control-sm',
                                                                           'data-date-format'=> 'dd/mm/yyyy',
                                                                           'placeholder'=> 'DD/MM/YYYY',
                                                                           'readonly'=>true,
                                                                           'id'=>"prop_data_nascimento_inscricao",
                                                                           ]) !!}
                                                <span class="input-group-btn">  <button class="btn btn-secondary"
                                                                                        type="button"><i
                                                                class="glyphicon glyphicon-calendar"></i></button> </span>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6 col-xs-12">
            <div class="row" id="veiculo-row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row info-veiculo">

                                        <div class="col-md-4">
                                            <strong>Marca: </strong> {{$cotacao->veiculo->fipe->marca}}

                                        </div>

                                        <div class="col-md-8">
                                            <strong>Modelo: </strong> {{$cotacao->veiculo->fipe->modelo}}

                                        </div>
                                        <div class="col-md-3">
                                            <strong>Fipe: </strong> {{$cotacao->veiculo->veiccodfipe}}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Valor: </strong>
                                            R$ {{format('real',$cotacao->veiculo->fipe->anovalor()->where('idcombustivel',$cotacao->veiculo->veictipocombus)->where('ano',$cotacao->veiculo->veicano)->first()->valor)}}
                                        </div>

                                        <div class="col-md-2">
                                            <strong>Ano: </strong> {{$cotacao->veiculo->veicano}}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Combustivel: </strong> {{$cotacao->veiculo->combustivel->nm_comb}}
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <label class="label label-default" for="placa">Placa</label>
                                    <div class="input-group input-group-sm ">
                                        <input class="form-control form-control-sm placa" type="text"
                                               data-target-chassi="#chassi"
                                               data-target-renavan="#renavan"
                                               data-target-municipio="#munplaca"
                                               data-target-uf="#placauf"
                                               data-target-anorenav="#anorenav"
                                               data-target-cor="#veiccor"
                                               placeholder="AAA-9999"
                                               name="placa" id="placa"/>
                                                        <span class="input-group-btn">
                                                             <button class="btn btn-primary btn-sm" data-target="#placa"
                                                                     href="{{route('veiculo.search')}}" type="button"
                                                                     id="search-placa">
                                                                 <span class="glyphicon glyphicon-search"></span>
                                                             </button>
                                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-5  ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default"
                                               for="munplaca">Município </label>
                                        <input class="form-control form-control-sm" type="text"
                                               name="munplaca" id="munplaca"/>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="form-group form-group-sm">

                                        {!! Form::label('placa_uf','UF',['class'=>'label label-default']) !!}
                                        {!! Form::select('placa_uf',
                                        $ufs,
                                        1,
                                        ['class'=>'selectpicker form-control form-control-sm',
                                        'data-live-search'=>'true',
                                        'data-style'=>'btn-secondary btn-sm',
                                        'id'=>'placa_uf']) !!}

                                    </div>
                                </div>
                                <div class="col-md-2  ">
                                    <div class="form-group form-group-sm">
                                        <label for="anof" class="label label-default">Fabricação</label>


                                        <select name="anof" id="anof"
                                                class="form-control form-control-sm">

                                            @if($cotacao->veiculo->veicano == 0)

                                                <option value="{{date('Y')}}">{{date('Y')}}</option>

                                            @else
                                                @for($i = $cotacao->veiculo->veicano; $i >= $cotacao->veiculo->veicano - 1; $i--)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            @endif


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3  ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="renavan">Renavan</label>
                                        <input class="form-control form-control-sm" type="text"
                                               tipoinput="renavan" stats="1" name="renavan"
                                               id="renavan"/>
                                    </div>
                                </div>
                                <div class="col-md-2  ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="anorenav">Ano
                                            Renavan</label>
                                        <select name="anorenav" id="anorenav"
                                                class="form-control form-control-sm">
                                            @for($i = ($cotacao->veiculo->veicano == 0 ? date('Y') :$cotacao->veiculo->veicano); $i <= date('Y'); $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4  ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="chassi">Chassi </label>
                                        <input class="form-control form-control-sm" stats="1"
                                               tipoinput="chassi" type="text"
                                               name="chassi" id="chassi"/>
                                    </div>
                                </div>
                                <div class="col-md-3  ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="veiccor">Cor</label>
                                        <input class="form-control form-control-sm" type="veiccor"
                                               name="veiccor" id="veiccor"/>
                                    </div>
                                </div>

                                <div class="col-md-3 ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="veicultilizacao">Ultilização</label>
                                        <select name="veicultilizacao" id="veicultilizacao"
                                                class="form-control form-control-sm">
                                            @foreach($tipoultiveics::orderBy('idutilveiculo', 'ASC')->get() as $tipoulti)
                                                <option value="{{$tipoulti->idutilveiculo}}"
                                                        style="font-size: 12px;">{{$tipoulti->descutilveiculo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="indcahssiremarc">Chassi
                                            Remarcado?</label>
                                        <select name="indcahssiremarc" id="indcahssiremarc"
                                                class="form-control form-control-sm">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group form-group-sm">
                                        <label class="label label-default" for="indleilao">Comprado em Leilão? </label>
                                        <select name="indleilao" id="indleilao"
                                                class="form-control form-control-sm">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>


            <div class="row" id="formas-pagamentos-row">
                <div class="col-md-12">
                    <div class="panel panel-default">


                        <div class="panel-body">

                            <div class="panel panel-success valor-total">
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-md-4 col-md-offset-4">
                                            <div class="alert alert-sm alert-success text-center ">
                                                <h6>Total a Vista <br>
                                                    <strong>R$ {{format('real',$cotacao->premio)}}</strong>
                                                </h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($formas as $key => $forma)
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="forma-pagamento btn btn-{{ ($key == 0 ? 'primary active' : 'default') }} btn-xs">
                                                {!! Form::radio('formapagamento',$forma->forma_id, ($key == 0 ? true : false),['data-target'=>'parcela-'.$forma->forma_id]) !!}  {{$forma->forma_pagamento}}
                                            </label>
                                        </div>
                                    @endforeach
                                    @foreach($formas as $key => $forma)

                                        <div class="quant-parcelas {{  ($key == 0 ? '' : 'hide')}}"
                                             id="quant-parcela-{{$forma->forma_id}}">
                                            <div class="row radio-sm">
                                                @foreach($forma->parcelas as $k =>$parcela)
                                                    <div class="col-md-12 col-xs-12 radio ">
                                                        <label class="">
                                                            {!! Form::radio('quant_parcela',$parcela->quantidade,($k == 0 && $key == 0 ? true : false),['data-name' => 'parcela-'.$forma->forma_id]) !!}
                                                            {{$parcela->quantidade}}x - {{($parcela->primeira_parcela != $parcela->demais_parcela ? 'Com sinal de R$ '. format('real',$parcela->primeira_parcela) . ' e mais '.
                                         ($parcela->quantidade - 1).'x R$ ' .format('real',$parcela->demais_parcela)
                                        : 'R$ '.format('real',$parcela->primeira_parcela))}} {{ ($parcela->taxa_juros == 0 ? 'Sem juros': 'Juros de '. str_replace('.',',',$parcela->taxa_juros) .'%' ) }}
                                                            - Total: R$ {{format('real',$parcela->valor_final)}}
                                                        </label>
                                                    </div>


                                                @endforeach
                                            </div>
                                        </div>

                                    @endforeach

                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">


                                        <div class="panel-body">

                                            @foreach($formas as $key => $forma)

                                                <div class="row dados-forma-pagamento {{  ($key == 0 ? '' : 'hide')}}">

                                                    @if($forma->forma_id == 2)
                                                        <div class="col-md-3">
                                                            {!! Form::label('form_boleto_primeiro', 'Primeiro Boleto',['class'=>'label label-default']) !!}
                                                            <div class="input-group input-group-sm date vencimento">
                                                                {!! Form::text('form_boleto_primeiro', date('d/m/Y'),
                                                                                           ['class'=> 'form-control form-control-sm',
                                                                                           'data-date-format'=> 'dd/mm/yyyy',
                                                                                           'placeholder'=> 'DD/MM/YYYY',
                                                                                           'readonly'=>true,
                                                                                           'id'=>"form_boleto_primeiro",
                                                                                           ]) !!}
                                                                <span class="input-group-btn">  <button
                                                                            class="btn btn-secondary"
                                                                            type="button"><i
                                                                                class="glyphicon glyphicon-calendar"></i></button> </span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            {!! Form::label('form_boleto_dia_demais', 'Dia demais',['class'=>'label label-default']) !!}
                                                            <div class="input-group input-group-sm date dia">
                                                                {!! Form::text('form_boleto_dia_demais', date('d'),
                                                                                           ['class'=> 'form-control form-control-sm',
                                                                                           'data-date-format'=> 'dd',
                                                                                           'placeholder'=> 'DD',
                                                                                           'readonly'=>true,
                                                                                           'id'=>"form_boleto_dia_demais",
                                                                                           ]) !!}
                                                                <span class="input-group-btn">  <button
                                                                            class="btn btn-secondary"
                                                                            type="button"><i
                                                                                class="glyphicon glyphicon-calendar"></i></button> </span>
                                                            </div>
                                                        </div>



                                                    @else
                                                        <div class="col-md-4 ">


                                                            <div class="form-group form-group-sm">
                                                                <label class="label label-default"
                                                                       for="forma_cartao_numero">Nº
                                                                    Cartão</label>
                                                                <input class="form-control form-control-sm" type="text"
                                                                       tipoinput="num-cartao" stats="1"
                                                                       name="forma_cartao_numero"
                                                                       id="forma_cartao_numero"/>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-sm">
                                                                <label class="label label-default"
                                                                       for="forma_cartao_nome">Titular
                                                                    do
                                                                    Cartão</label>
                                                                <input class="form-control form-control-sm" type="text"
                                                                       placeholder="Nome proprietario do cartão"
                                                                       name="forma_cartao_nome"
                                                                       id="forma_cartao_nome"/>
                                                            </div>

                                                        </div>
                                                        <div class="form-group form-group-sm col-md-4 ">
                                                            <label class="label label-default"
                                                                   for="forma_cartao_bandeira">Bandeira
                                                                Cartão</label>
                                                            <select name="forma_cartao_bandeira"
                                                                    id="forma_cartao_bandeira"
                                                                    class="form-control form-control-sm">

                                                                <option value="visa">Visa</option>
                                                                <option value="mastercard">MasterCard</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            {!! Form::label('forma_cartao_validade', 'Validade',['class'=>'label label-default']) !!}
                                                            <div class="input-group input-group-sm date validade">
                                                                {!! Form::text('forma_cartao_validade',  date('m/Y'),
                                                                                           ['class'=> 'form-control form-control-sm',
                                                                                           'data-date-format'=> 'mm/yyyy',
                                                                                           'placeholder'=> 'MM/YYYY',
                                                                                           'readonly'=>true,
                                                                                           'id'=>"forma_cartao_validade",
                                                                                           ]) !!}
                                                                <span class="input-group-btn">  <button
                                                                            class="btn btn-secondary"
                                                                            type="button"><i
                                                                                class="glyphicon glyphicon-calendar"></i></button> </span>
                                                            </div>
                                                        </div>


                                                    @endif

                                                </div>

                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="btn-group pull-right button-proposta-enviar">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>


        </div>

    </div>




    {!! Form::close() !!}



@stop

@section('script')
    <script src="{{ theme('js/proposta.js') }}"></script>
@stop