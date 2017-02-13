@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Segurados')
@section('contentSeg')

    <div class="col-md-12">

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p class="mostrando" data-show="{{$offset}}" data-nome="segurados">Mostrando as últimas {{$offset}} segurados</p>
            </div>
            <div class="col-md-6 btn-group">
                <button type="button" class="btn-primary btn-xs pull-right load-more" data-mostrando=".mostrando" data-url="{{$url}}" data-offset="0" data-sum="{{$offset}}">Carregar mais {{$offset}}</button>
            </div>
        </div>
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

                                <button type="button" class="btn btn-primary btn-xs modal-call" data-toggle="modal"
                                        data-target=".modal-show"
                                        data-url="{{route('segurado.edit',$crypt::encrypt($segurado->id))}}"
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

@section('script')
{{--    <script src="{{ theme('js/cotacao.js') }}"></script>--}}
@stop



