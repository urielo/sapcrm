@extends('layouts.segurado')



@section('panelcolor','info')
@section('heading','Negociações')
@section('contentSeg')

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
    <div class="table-responsive">
        <table class="table table-striped" >
            <thead style="font-size: 13px;">
                <tr>
                    <th>NOME/RAZAO</th>
                    <th>CPF/CNPJ</th>
                    <th>EMAIL</th>
                    <th>DATA NASCIMENTO</th>

                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                @foreach ($segurados as $segurado)
                <tr>
                    <td><a href="{{route('segurado.show', $segurado->clinomerazao)}}" class=""></a>{{$segurado->clinomerazao}}</td>
                    <td>{{$segurado->clicpfcnpj}}</td>
                    <td>{{$segurado->clidtnasc}}</td>
                    <td>{{$segurado->cliemail}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <center>{{$segurados->render()}}</center>
    </div>

</div>
@stop