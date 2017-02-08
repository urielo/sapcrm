@extends('layouts.segurado')


@section('heading', 'Segurados')
@section('contentSeg')

<div class="table-responsive">
    <table class="table table-striped" >
        <thead style="font-size: 13px;">
            <tr>
                <th>NOME/RAZAO</th>
                <th>CPF/CNPJ</th>
                <th>EMAIL</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="font-size: 12px;">
            @foreach ($segurados as $segurado)
            <tr>
                <td><a href="{{route('segurado.show', $segurado->clicpfcnpj)}}" class=""></a>{{$segurado->clinomerazao}}</td>
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

@stop
@section('pagination')
{{$segurados->render()}}
@stop
