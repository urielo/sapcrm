@extends('layouts.busca')


@section('panelcolor','info')
@section('panel_class','table-responsive apolice')
@section('heading','Buscar')
@section('content_body')

    <div class="col-md-12">
        @if($pesquisa == 'proposta')
            @include('backend.search.filtro_proposta')
        @endif

    </div>
@stop
@section('table')

    <div id="result">

    </div>
@stop
@section('modal')
    <div class="modal fade modal-show" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
@stop


@section('script')

@stop



