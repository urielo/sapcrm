<div class="row">
    <div class="form-group form-group-sm{{ $errors->has('cpfcnpj') ? ' has-error' : '' }} col-md-3">
        {!! Form::label('cpfcnpj','CPF/CNPJ',['class'=>'label label-success']) !!}
        {!! Form::text('cpfcnpj', old('cpfcnpj'), ['class' => 'form-control form-control-sm cpfcnpj','id'=>'cpfcnpj','stats'=>1, 'tipoinput'=>'cpfcnpj']) !!}
        <div id="msg-cpfcnpj"></div>
        @if ($errors->has('cpfcnpj'))
            <span class="help-block">
                                        <small>{{ $errors->first('cpfcnpj') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('nomerazao') ? ' has-error' : '' }} col-md-6">
        {!! Form::label('nomerazao','Nome/Razão Social',['class'=>'label label-success']) !!}
        {!! Form::text('nomerazao', old('nomerazao'), ['class' => 'form-control form-control-sm','id'=>'nomerazao']) !!}

        @if ($errors->has('nomerazao'))
            <span class="help-block">
                                        <small>{{ $errors->first('nomerazao') }}</small>
                                    </span>
        @endif
    </div>


    <div class="form-group form-group-sm{{ $errors->has('susep') ? ' has-error' : '' }} col-md-3">
        {!! Form::label('susep','SUSEP',['class'=>'label label-success']) !!}
        {!! Form::text('susep', old('susep'), ['class' => 'form-control form-control-sm','id'=>'susep', ]) !!}

        @if ($errors->has('susep'))
            <span class="help-block">
                                        <small>{{ $errors->first('susep') }}</small>
                                    </span>
        @endif
    </div>

</div>
<div class="row">
    <div class="form-group form-group-sm{{ $errors->has('dddfixo') ? ' has-error' : '' }} col-md-1">
        {!! Form::label('dddfixo','DDD',['class'=>'label label-success']) !!}
        {!! Form::text('dddfixo', old('dddfixo'), ['class' => 'form-control form-control-sm','id'=>'dddfixo','stats'=>1 ,'tipoinput'=>'ddd']) !!}

        @if ($errors->has('dddfixo'))
            <span class="help-block">
                                        <small>{{ $errors->first('dddfixo') }}</small>
                                    </span>
        @endif
    </div>
    <div class="form-group form-group-sm{{ $errors->has('telfixo') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('telfixo','Tel Fixo',['class'=>'label label-success']) !!}
        {!! Form::text('telfixo', old('telfixo'), ['class' => 'form-control form-control-sm','id'=>'telfixo', 'stats'=>1, 'tipoinput'=>'fone' ]) !!}

        @if ($errors->has('telfixo'))
            <span class="help-block">
                                        <small>{{ $errors->first('telfixo') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('dddcel') ? ' has-error' : '' }} col-md-1">
        {!! Form::label('dddcel','DDD',['class'=>'label label-success']) !!}
        {!! Form::text('dddcel', old('dddcel'), ['class' => 'form-control form-control-sm','id'=>'dddcel','stats'=>1 ,'tipoinput'=>'ddd']) !!}

        @if ($errors->has('dddcel'))
            <span class="help-block">
                                        <small>{{ $errors->first('dddcel') }}</small>
                                    </span>
        @endif
    </div>
    <div class="form-group form-group-sm{{ $errors->has('cel') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('cel','Celular',['class'=>'label label-success']) !!}
        {!! Form::text('cel', old('cel'), ['class' => 'form-control form-control-sm','id'=>'cel', 'stats'=>1, 'tipoinput'=>'cel' ]) !!}

        @if ($errors->has('cel'))
            <span class="help-block">
                                        <small>{{ $errors->first('cel') }}</small>
                                    </span>
        @endif
    </div>


    <div class="form-group form-group-sm{{ $errors->has('corretora-email') ? ' has-error' : '' }} col-md-4">
        {!! Form::label('corretora-email','Email da Corretora',['class'=>'label label-success']) !!}
        {!! Form::text('corretora-email', old('corretora-email'), ['class' => 'form-control form-control-sm','id'=>'corretora-email', 'stats'=>1 ]) !!}

        @if ($errors->has('corretora-email'))
            <span class="help-block">
                                        <small>{{ $errors->first('corretora-email') }}</small>
                                    </span>
        @endif
    </div>
</div>

<div class="row">



    <div class="form-group form-group-sm{{ $errors->has('cep') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('cep','CEP',['class'=>'label label-success']) !!}
        {!! Form::text('cep', old('cep'), ['class' => 'form-control form-control-sm','id'=>'cep', 'stats'=>1, 'tipoinput'=>'cep' ]) !!}

        @if ($errors->has('cep'))
            <span class="help-block">
                                        <small>{{ $errors->first('cep') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('logradouro') ? ' has-error' : '' }} col-md-6">
        {!! Form::label('logradouro','Logradouro',['class'=>'label label-success']) !!}
        {!! Form::text('logradouro', old('logradouro'), ['class' => 'form-control form-control-sm','id'=>'logradouro']) !!}

        @if ($errors->has('logradouro'))
            <span class="help-block">
                                        <small>{{ $errors->first('logradouro') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('endnumero') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('endnumero','Numero',['class'=>'label label-success']) !!}
        {!! Form::text('endnumero', old('endnumero'), ['class' => 'form-control form-control-sm','id'=>'endnumero']) !!}

        @if ($errors->has('endnumero'))
            <span class="help-block">
                                        <small>{{ $errors->first('endnumero') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('complemento') ? ' has-error' : '' }} col-md-4">
        {!! Form::label('complemento','Complemento',['class'=>'label label-success']) !!}
        {!! Form::text('complemento', old('complemento'), ['class' => 'form-control form-control-sm','id'=>'complemento']) !!}

        @if ($errors->has('complemento'))
            <span class="help-block">
                                        <small>{{ $errors->first('complemento') }}</small>
                                    </span>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('cidade') ? ' has-error' : '' }} col-md-4">
        {!! Form::label('cidade','Cidade',['class'=>'label label-success']) !!}
        {!! Form::text('cidade', old('cidade'), ['class' => 'form-control form-control-sm','id'=>'cidade']) !!}

        @if ($errors->has('cidade'))
            <span class="help-block">
                                        <small>{{ $errors->first('cidade') }}</small>
                                    </span>
        @endif
    </div>
    <div class="form-group form-group-sm{{ $errors->has('uf') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('uf','UF',['class'=>'label label-success']) !!}
        {!! Form::select('uf',['1'=>"SP", '2'=>"RJ", '3'=>"MS", '4'=>"MA", '5'=>"TO", '6'=>"RO", '8'=>"AL",
        '9'=>"SE", '11'=>"SC", '12'=>"PI", '13'=>"BA", '14'=>"PE", '15'=>"DF",
        '17'=>"MG", '18'=>"PB", '20'=>"PA", '21'=>"ES", '22'=>"GO", '23'=>"RS",
        '24'=>"MT", '26'=>"RR", '59'=>"AC", '60'=>"AM", '61'=>"AP", '62'=>"CE", '63'=>"PR", '64'=>"RN"],
         old('uf'), ['class' => 'form-control form-control-sm','id'=>'uf']) !!}

        @if ($errors->has('uf'))
            <span class="help-block">
                                        <small>{{ $errors->first('uf') }}</small>
                                    </span>
        @endif
    </div>


    <div class="form-group form-group-sm{{ $errors->has('comissao') ? ' has-error' : '' }} col-md-2">
        {!! Form::label('comissao','Comissao Padrão',['class'=>'label label-success']) !!}
        {!! Form::number('comissao', old('comissao'), ['class' => 'form-control form-control-sm','id'=>'comissao']) !!}

        @if ($errors->has('comissao'))
            <span class="help-block">
                                        <small>{{ $errors->first('comissao') }}</small>
                                    </span>
        @endif
    </div>
</div>
