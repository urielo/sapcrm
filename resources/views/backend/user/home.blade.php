@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Usuários')

@section('contentSeg')

    <div class="col-md-12 apolice table-responsive">
        <div class="table">
            @include('backend.user.table')
        </div>

    </div>
@stop

