@extends('layouts.backend')
@section('style')
@parent
        <link rel="stylesheet" href="{{ theme('css/input.css') }}">
@stop

@section('content')
<div class="col-md-12">
    <div class="center">
        <div class="col-md-5">
            <div class="panel panel-{{ Session::has('message') ? 'info': 'default' }}">
                <div class="panel-heading">
                    <h3 class="panel-title">FIPE ANO VALOR</h3>
                </div>
                <div class="panel-body">
                    @if(Session::has('message'))
                    <div class="alert alert-info">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    {!! Form::open(array ('action' => "Backend\Config\UploadController@postUploadFipeAnoValor", 'enctype' => "multipart/form-data"))!!}
                    <div class="form-group">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <span class="btn btn-primary btn-file"><span class="fileupload-new">Procurar</span>
                                <span class="fileupload-exists">Trocar</span>{!!Form::file('xlsfipe')!!}</span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div>
                    </div>
                    {!!Form::submit('Enviar', $attributes = ['class' => "btn btn-primary"])!!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-{{ Session::has('message1') ? 'info': 'default' }}">
                <div class="panel-heading">
                    <h3 class="panel-title">FIPE</h3>
                </div>
                <div class="panel-body">
                    @if(Session::has('message1'))
                    <div class="alert alert-info">
                        {{Session::get('message1')}}
                    </div>
                    @endif
                    {!! Form::open(array ('action' => "Backend\Config\UploadController@postUploadFipe", 'enctype' => "multipart/form-data"))!!}
                    <div class="form-group">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <span class="btn btn-primary btn-file"><span class="fileupload-new">Procurar</span>
                                <span class="fileupload-exists">Trocar</span>{!!Form::file('xlsfipe')!!}</span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div>

                    </div>
                    {!!Form::submit('Enviar', $attributes = ['class' => "btn btn-primary"])!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop


