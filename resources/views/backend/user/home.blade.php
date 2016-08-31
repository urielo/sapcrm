@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading')

    <div class="form-group form-group-sm row" style="vertical-align: middle;">
        <div class="col-md-2 col-md-offset-3">Usuários</div>

        <div class="col-md-3 pull-right">
            {!! Form::text('search',null,['class'=>'search1 form-control ','href'=>route('usuarios.search',''),'placeholder'=>'Search', 'id'=>'buscaruser']) !!}
        </div>
    </div>

@stop

@section('contentSeg')

    <div class="col-md-12 apolice table-responsive">
        <div class="table result">

            @include('backend.user.table')


        </div>

    </div>
@stop

@section('pagination')
            {{$usuarios->render()}}
@stop