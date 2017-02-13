@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Segurados')
@section('contentSeg')

    <div class="col-md-12">

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p class="mostrando" data-show="{{$offset}}" data-nome="veiculos">Mostrando as últimas {{$offset}} veiculos</p>
            </div>
            <div class="col-md-6 btn-group">
                <button type="button" class="btn-primary btn-xs pull-right load-more" data-mostrando=".mostrando" data-url="{{$url}}" data-offset="0" data-sum="{{$offset}}">Carregar mais {{$offset}}</button>
            </div>
        </div>
        <div class="table-responsive apolice">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Placa</th>
                    <th>Fipe</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Status</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>

                @foreach ($veiculos as $veiculo)
                    <tr>
                        <td><a href="#" data-toggle="modal" data-target=".modal-show" data-url="{{route('veiculo.edit', $crypt::encrypt($veiculo->veicid))}}" class="modal-call"></a>{{$veiculo->veicid}}</td>
                        <td>{{format('placa',$veiculo->veicplaca)}}</td>
                        <td>{{$veiculo->fipe->codefipe}}</td>
                        <td>{{$veiculo->fipe->marca}}</td>
                        <td>{{$veiculo->fipe->modelo}}</td>
                        <td>{{$veiculo->veicano}}</td>
                        <td>{{$veiculo->status->descricao}}</td>
                        <td><div class="btn-group" role="group">

                                <button type="button" class="btn btn-primary btn-xs modal-call" data-toggle="modal"
                                        data-target=".modal-show"
                                        data-url="{{route('veiculo.edit',$crypt::encrypt($veiculo->veicid))}}"
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



