@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Segurados')
@section('contentSeg')

    <div class="col-md-12">
        <div class="table-responsive apolice">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th>Segurado</th>
                    <th>CPF/CNPJ</th>
                    <th>Email</th>

                    <th></th>

                </tr>
                </thead>
                <tbody>

                @foreach ($segurados as $segurado)
                    <tr>
                        <td><a href="{{route('segurado.edit', $segurado->clicpfcnpj)}}" class=""></a>{{$segurado->clinomerazao}}</td>
                        <td>{{$segurado->clicpfcnpj}}</td>
                        <td>{{$segurado->cliemail}}</td>
                        <td><div class="btn-group" role="group">

                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                        data-target=".modal-show"
                                        href="{{route('segurado.edit',$crypt::encrypt($segurado->id))}}"
                                        id="editar">Editar
                                </button>


                            </div></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Editar segurado!!!"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                </div>
            </div>
        </div>

    </div>
@stop



