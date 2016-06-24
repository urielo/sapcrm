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
            </tr>
        </thead>
        <tbody style="font-size: 12px;">
            @foreach ($segurados as $segurado)
            <tr>
                <td><a href="{{route('segurado.show', $segurado->clicpfcnpj)}}" class=""></a>{{$segurado->clinomerazao}}</td>
                <td>{{$segurado->clicpfcnpj}}</td>
                <td>{{$segurado->cliemail}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop
@section('pagination')
{{$segurados->render()}}
@stop
