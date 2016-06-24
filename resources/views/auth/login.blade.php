@extends('layouts.auth')

@section('title', 'Login')

@section('heading','Bem Vindo ao Seguro AutoPratico')

@section('content')
        {!! Form::open() !!}
        
        <div class="form-group">
            {!! Form::label('email') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('senha') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        
        {!! Form::submit('Login',['class'=>'btn btn-primary']) !!}
        
        <a href="#" class="small">Recuperar senha!</a>
        {!! Form::close() !!}
@endsection
