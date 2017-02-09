{!!Form::open([ 'method' => 'post', 'route' => ['segurado.update_']  ]) !!}
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Editar Segurado
        <h4>
</div>
<div class="modal-body">
    <div class="container-fluid">

        @if(strlen($segurado->clicpfcnpj) > 11)


            <div class="row pessoa">
                <div class="col-md-3">

                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_cpfnpj','CNPJ',['class'=>'label label-default']) !!}
                        {{--<label class="label label-default" for="segcpf">CPF</label>--}}
                        {!! Form::text('seg_cpfnpj', $segurado->clicpfcnpj,[
                        'class' =>'form-control form-control-sm cpfcnpj',
                        'readonly'=>true,

                        ]) !!}

                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_nomerazao','Razão social',['class'=>'label label-default']) !!}
                        {{--<label class="label label-default" for="segcpf">CPF</label>--}}
                        {!! Form::text('seg_nomerazao',( old('seg_nomerazao') ? old('seg_nomerazao'): strlen($segurado->clinomerazao) > 5 ? $segurado->clinomerazao : NULL ),[
                        'class' =>'form-control form-control-sm',
                        ]) !!}

                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('seg_data_nascimento_inscricao', 'Inscrição',['class'=>'label label-default']) !!}
                    <div class="input-group input-group-sm date nascimento">
                        {!! Form::text('seg_data_nascimento_inscricao', (  old('seg_data_nascimento_inscricao') ? old('seg_data_nascimento_inscricao'):  empty($segurado->clidtnasc) ? date('d/m/Y',strtotime('-18 year')): date('d/m/Y',strtotime($segurado->clidtnasc))),
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
                        ( old('seg_profissao_ramo') ? old('seg_profissao_ramo') : !empty($segurado->clicdprofiramoatividade) ? $segurado->clicdprofiramoatividade : '')
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
                        {!! Form::text('seg_cpfnpj',$segurado->clicpfcnpj,[
                        'class' =>'form-control form-control-sm cpfcnpj',
                        'readonly'=>true,

                        ]) !!}

                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_nomerazao','Nome',['class'=>'label label-default']) !!}
                        {!! Form::text('seg_nomerazao', old('seg_nomerazao') ? old('seg_nomerazao') :  (strlen($segurado->clinomerazao) > 5 ? $segurado->clinomerazao : NULL ),[
                        'class' =>'form-control form-control-sm',
                        ]) !!}

                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('seg_data_nascimento_inscricao', 'Nascimento',['class'=>'label label-default']) !!}
                    <div class="input-group input-group-sm date nascimento">
                        {!! Form::text('seg_data_nascimento_inscricao', ( old('seg_data_nascimento_inscricao') ? old('seg_data_nascimento_inscricao') :  empty($segurado->clidtnasc) ? date('d/m/Y',strtotime('-18 year')): date('d/m/Y',strtotime($segurado->clidtnasc))),
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
                        ( old('seg_sexo') ? old('seg_sexo') :  !empty($segurado->clicdsexo) ? $segurado->clicdsexo : 1),
                        ['class'=>'form-control form-control-sm','id'=>'seg_sexo']) !!}

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_estado_civil','Estado civil',['class'=>'label label-default']) !!}
                        {!! Form::select('seg_estado_civil',
                        $estados_civis,
                        (old('seg_estado_civil') ? old('seg_estado_civil') :   !empty($segurado->clicdestadocivil) ? $segurado->clicdestadocivil : 1),
                        ['class'=>'form-control form-control-sm','id'=>'seg_estado_civil']) !!}

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_rg_numero','RG',['class'=>'label label-default']) !!}
                        {!! Form::text('seg_rg_numero', ( old('seg_rg_numero') ? old('seg_rg_numero') :  !empty($segurado->clinumrg) ? $segurado->clinumrg : NULL),
                        ['class'=>'form-control form-control-sm','id'=>'seg_rg_numero','placeholder'=>'0000000000A']) !!}

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group form-group-sm">
                        {!! Form::label('seg_rg_uf','RG - UF',['class'=>'label label-default']) !!}
                        {!! Form::select('seg_rg_uf',
                        $ufs,
                        ( old('seg_rg_uf') ? old('seg_rg_uf') : !empty($segurado->clicdufemissaorg) ? $segurado->clicdufemissaorg : 1),
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
                        {!! Form::text('seg_rg_emissao', ( old('seg_rg_emissao') ? old('seg_rg_emissao') :  empty($segurado->clidtemissaorg) ? date('d/m/Y',strtotime('-1 year')) : date('d/m/Y',strtotime($segurado->clidtemissaorg))),
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
                        ( old('seg_rg_org') ? old('seg_rg_org') :   !empty($segurado->cliemissorrg) ? $segurado->cliemissorrg : 'SSP'),
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
                        (old('seg_profissao_ramo') ? old('seg_profissao_ramo') : !empty($segurado->clicdprofiramoatividade) ? $segurado->clicdprofiramoatividade : '')
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
                            {!! Form::email('seg_email',(old('seg_email') ? old('seg_email') :  !empty($segurado->cliemail) ? $segurado->cliemail : NULL ),[
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
                            {!! Form::text('seg_cel_ddd',(old('seg_cel_ddd') ? old('seg_cel_ddd') : !empty($segurado->clidddcel) ? $segurado->clidddcel : NULL ),[
                            'class' =>'form-control form-control-sm ddd',
                            'placeholder' =>'99',
                            'id'=>'seg_cel_ddd'

                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group form-group-sm">
                            {!! Form::label('seg_cel_numero','Celular',['class'=>'label label-default']) !!}

                            {!! Form::text('seg_cel_numero',(old('seg_cel_numero') ? old('seg_cel_numero') :  !empty($segurado->clinmcel) ? $segurado->clinmcel : NULL ),[
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
                            {!! Form::text('seg_fixo_ddd',(old('seg_fixo_ddd') ? old('seg_fixo_ddd') :  !empty($segurado->clidddfone) ? $segurado->clidddfone : NULL ),[
                            'class' =>'form-control form-control-sm ddd',
                            'placeholder' =>'99',
                            'id'=>'seg_fixo_ddd'

                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group form-group-sm">
                            {!! Form::label('seg_fixo_numero','Fixo',['class'=>'label label-default']) !!}

                            {!! Form::text('seg_fixo_numero',(old('seg_fixo_numero') ? old('seg_fixo_numero') :  !empty($segurado->clinmfone) ? $segurado->clinmfone : NULL ),[
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
                            {!! Form::text('seg_end_cep',(old('seg_end_cep') ? old('seg_end_cep') :  !empty($segurado->clicep) ? $segurado->clicep : NULL ),[
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
                            {!! Form::text('seg_end_log',(old('seg_end_log') ? old('seg_end_log') : !empty($segurado->clinmend) ? $segurado->clinmend : NULL ),[
                            'class' =>'form-control form-control-sm',
                            'id'=>'seg_end_log'

                            ]) !!}

                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="form-group form-group-sm">
                            {!! Form::label('seg_end_num','Numero',['class'=>'label label-default']) !!}
                            {!! Form::text('seg_end_num',(old('seg_end_num') ? old('seg_end_num') :  !empty($segurado->clinumero) ? $segurado->clinumero : NULL ),[
                            'class' =>'form-control form-control-sm',
                            'id'=>'seg_end_num'

                            ]) !!}

                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="form-group form-group-sm">
                            {!! Form::label('seg_end_cidade','Cidade',['class'=>'label label-default']) !!}
                            {!! Form::text('seg_end_cidade',(old('seg_end_cidade') ? old('seg_end_cidade') : !empty($segurado->clinmcidade)  ? $segurado->clinmcidade : NULL ),[
                            'class' =>'form-control form-control-sm',
                            'id'=>'seg_end_cidade'
                            ]) !!}

                        </div>
                    </div>

                    <div class="col-md-5">

                        <div class="form-group form-group-sm">
                            {!! Form::label('seg_end_bairro','Bairro',['class'=>'label label-default']) !!}
                            {!! Form::text('seg_end_bairro',(old('seg_end_bairro') ? old('seg_end_bairro') :  !empty($segurado->bairro) ? $segurado->bairro : NULL ),[
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
                            (old('seg_end_uf') ? old('seg_end_uf') : !empty($segurado->clicduf) ? $segurado->clicduf : 1),
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
                            {!! Form::text('seg_end_complemento',(old('seg_end_complemento') ? old('seg_end_complemento') : !empty($segurado->cliendcomplet) ? $segurado->cliendcomplet : NULL ),[
                            'class' =>'form-control form-control-sm',
                            'id'=>'seg_end_complemento'
                            ]) !!}

                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Salvar</button>
</div>
{!!Form::close()!!}
