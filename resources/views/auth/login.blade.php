@extends('layouts.auth')

@section('title', 'Login')

@section('content')


    <div class="row vertical-center">
        <div class="col-md-4">
            <div class="panel panel-{{ $errors->any() ? 'danger': 'default' }} transparent">
                {{--<div class="panel-heading">--}}
                {{--<h2 class="panel-title">Bem Vindo ao SeguroAutoPratico</h2>--}}
                {{--</div>--}}
                <div class="panel-body">


                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif(Session::has('sucesso'))
                        <div class="alert alert-info" id="sucesso">
                            <button type="button" class="close" aria-label="Close" id="fechasecesso">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{Session::get('sucesso')}}
                        </div>
                    @endif
                    {!! Form::open() !!}
                    <div class="form-group">

                        {!! Form::label('email','Email',['class'=>'label label-info']) !!}
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('senha','Senha',['class'=>'label label-info']) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>

                    <a href="register" class="btn btn-info">Cadastre-se</a>
                    <a class="small btn btn-link" href="{{ url('/password/reset') }}">Recuperar senha!</a>


                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>

@endsection
