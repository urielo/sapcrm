@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Usuários')

@section('contentSeg')

    <div class="col-md-12 apolice ">
        <div class="table-responsive">
            @include('backend.user.table')
        </div>

    </div>
@stop

