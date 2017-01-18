@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Movimentos')
@section('contentSeg')

    <div class="col-md-12">
        <div class="table-responsive apolice">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th>#Certificado</th>
                    <th>Segurado</th>
                    <th>Placa</th>
                    <th>Data - Envio</th>
                    <th>Data - Retorno</th>
                    <th>Desc - Retorno</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Lote</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($dados as $movimento)
                    <tr>
                        <th>#{{$movimento['certificado']}}</th>
                        <td>{{$movimento['segurado']}}</td>
                        <td>{{$movimento['placa']}}</td>
                        <td>{{$movimento['enviado']}}</td>
                        <td>{{$movimento['retorno']}}</td>
                        <td>{{$movimento['desc_retorno']}}</td>
                        <td>{{$movimento['tipo']}}</td>
                        <td>{{$movimento['status']}}</td>
                        <td>{{$movimento['lote']}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop