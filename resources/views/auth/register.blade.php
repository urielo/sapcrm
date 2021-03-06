@extends('layouts.auth')

@section('title', 'Registrar')


@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar</div>

                <div class="panel-body">
                    {!! Form::open() !!}

                    <div class="panel panel-success">
                        <div class="panel-heading">Dados da Corretora</div>

                        <div class="panel-body">

                            <div class="row" id="forms-tipocadastro">
                                <div class="col-md-12">

                                    @include('auth.formusers.corretor')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-info">
                        <div class="panel-heading">Dados do Login</div>

                        <div class="panel-body">

                            {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">--}}
                            <div class="row">

                                <div class="form-group form-group-sm{{ $errors->has('nome') ? ' has-error' : '' }} col-md-6">
                                    {!! Form::label('nome','Nome',['class'=>'label label-info']) !!}
                                    {!! Form::text('nome', old('nome'), ['class' => 'form-control form-control-sm','id'=>'nome']) !!}

                                    @if ($errors->has('nome'))
                                        <span class="help-block">
                                        <small>{{ $errors->first('nome') }}</small>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group form-group-sm{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">

                                    {!! Form::label('email','Email',['class'=>'label label-info']) !!}
                                    {!! Form::email('email', old('email'), ['class' => 'form-control form-control-sm required','id'=>'email']) !!}

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <small>{{ $errors->first('email') }}</small>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group form-group-sm{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">

                                    {!! Form::label('password','Senha',['class'=>'label label-info']) !!}
                                    {!! Form::password('password', ['class' => 'form-control form-control-sm','id'=>'password']) !!}

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <small>{{ $errors->first('password') }}</small>
                                    </span>
                                    @endif

                                </div>

                                <div class="form-group form-group-sm{{ $errors->has('password_confirmation') ? ' has-error' : '' }} col-md-6">
                                    {!! Form::label('password-confirm','Confirmação de Senha',['class'=>'label label-info']) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control form-control-sm','id'=>'password-confirm']) !!}

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <small>{{ $errors->first('password_confirmation') }}</small>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group">


                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">Cancelar</button>

                    </div>


                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>



@endsection
