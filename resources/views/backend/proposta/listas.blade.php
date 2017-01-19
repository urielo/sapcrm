@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading','Propostas - ' . $title)
@section('contentSeg')

    <div class="col-md-12">
        <div class="table-responsive apolice">
            <table class="table table-hover table-condensed table-datatable">
                <thead>
                <tr>
                    <th>#Proposta</th>
                    <th>CPF/CNPJ</th>
                    <th>Emissão</th>
                    <th>Validade</th>
                    <th>Status</th>
                    @if($motivo)
                        <th>Motivos</th>
                    @endif
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach ($propostas as $proposta)
                    <tr>
                        <th><a href="#" class="">{{$proposta->idproposta}}</a></th>
                        <th><a href="#" class="">{{format('cpfcnpj',$proposta->cotacao->segurado->clicpfcnpj)}}</a></th>
                        <td>{!! date('d/m/Y', strtotime($proposta->dtcreate)) !!}</td>
                        <td>{!! date('d/m/Y', strtotime($proposta->dtvalidade)) !!}</td>

                        <td>{{$proposta->status->descricao}}</td>
                        @if($motivo)
                            <td> {{$proposta->motivos->descrição}}</td>
                        @endif

                        <td>
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-info"
                                   href="{{route('proposta.pdf',$crypt::encrypt($proposta->idproposta))}}"
                                   target="_blank">
                                    <span
                                            class="glyphicon glyphicon glyphicon-print"
                                            aria-hidden="true"></span> PDF

                                </a>

                                @if(in_array($proposta->idstatus,[10,14]))
                                    <a class="btn btn-danger"
                                       href="{{route('proposta.cancela',$crypt::encrypt($proposta->idproposta))}}"
                                       target="_blank">
                                        Cancelar

                                    </a>
                                @endif

                                {{--<a class="btn btn-success"--}}
                                {{--href="{{route('cotacao.reemitir',$crypt::encrypt($cotacao->idcotacao))}}"--}}
                                {{-->--}}
                                {{--<span--}}
                                {{--class="glyphicon glyphicon glyphicon-edit"--}}
                                {{--aria-hidden="true"></span> Reemitir--}}

                                {{--</a>--}}
                                {{--@if(!$cotacao->proposta && $cotacao->idstatus == 9)--}}
                                {{--<a class="btn btn-primary "--}}
                                {{--href="{{route('proposta.index',$crypt::encrypt($cotacao->idcotacao))}}">--}}
                                {{--<span--}}
                                {{--class="glyphicon glyphicon-expand" aria-hidden="true"></span>--}}
                                {{--Emitir proposta--}}
                                {{--</a>--}}

                                {{--@endif--}}

                            </div>


                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop
