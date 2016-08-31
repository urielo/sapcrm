@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Usuários')

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