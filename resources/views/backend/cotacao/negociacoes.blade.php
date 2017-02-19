@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Cotações - '. $title)
@section('contentSeg')

    <div class="col-md-12">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-3 ">
                <form action="" method="GET">
                    <div class="input-group input-group-sm input-daterange">
                        <div class="input-group-addon">De</div>
                        <input type="text" class="form-control" name="date_ini"  id="date_ini" value="{{$data_ini}}" required>
                        <div class="input-group-addon">Até</div>
                        <input type="text" class="form-control" name="date_fim"  id="date_fim" value="{{$data_fim}}" required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">
                                Filtrar
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-6 btn-group col-md-offset-3">
                <button type="button" class="btn-primary btn-sm pull-right load-more" data-ini="#date_ini" data-fim="#date_fim"
                        data-url="{{$url}}" data-carrega="{{$tipo_carrega}}" data-offset="0" data-sum="{{$offset}}">Carregar mais 500
                </button>
            </div>

        </div>

        <div class="row">
            @include('backend.cotacao.table')
        </div>
        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Emissao/Emitidas"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                </div>
            </div>
        </div>

    </div>
@stop