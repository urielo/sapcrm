@extends('layouts.cotacao')


@section('panelcolor','success')
@section('heading','Apolices')

@section('contentSeg')

    <div class="col-md-12 col-xs-12 apolice">
        <div class="table-responsive">
            <table class="table table-hover table-condensed  table-datatable">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Segurado</th>
                    <th>Placa</th>
                    <th>Certificado</th>
                    <th class="hidden-xs">Corretor</th>
                    <th>{{isset($status) && $status ? 'Status': null}}</th>
                </thead>
                <tbody>


                @foreach($propostas as $proposta)
                    <tr>
                        <th>{{$proposta->idproposta}}</th>
                        <td><a href="#{{$proposta->cotacao->segurado->clicpfcnpj}}">
                                {{nomeCase($proposta->cotacao->segurado->clinomerazao)}}
                            </a></td>
                        <td><a href="#{{$proposta->cotacao->veiculo->veicid}}">
                                {{format('placa',$proposta->cotacao->veiculo->veicplaca)}}
                            </a></td>
                        <td>{{$proposta->certificado->id}}</td>
                        <td><a href="#{{$proposta->cotacao->corretor->idcorretor}}">
                                {{nomeCase($proposta->cotacao->corretor->corrnomerazao)}}
                            </a></td>
                        <td>

                            <div class="btn-group" role="group">

                                @if($status)
                                    {{$proposta->certificado->status->descricao }}
                                @else
                                    @if($proposta->idstatus == 15)
                                        <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                           data-target=".modal-show"
                                           href="{{route('apolices.show',$proposta->idproposta)}}"
                                           id="showinfo">Emitir
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm"
                                           {{--data-toggle="modal"--}}
                                           {{--data-target=".modal-show"--}}
                                           href="#"
                                           id="">Cancelar
                                        </a>
                                    @elseif($proposta->idstatus == 24)
                                        <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                           data-target=".modal-show"
                                           href="{{route('apolices.show',$proposta->idproposta)}}"
                                           id="showinfo">Emitir
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm"
                                           {{--data-toggle="modal"--}}
                                           {{--data-target=".modal-show"--}}
                                           href="#"
                                           id="">Cancelar
                                        </a>
                                    @elseif($proposta->idstatus == 18)
                                        <a type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                           data-target=".modal-show"
                                           href="{{route('apolices.showemiditas',$proposta->idproposta)}}"
                                           id="showinfo">Apolices
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm"
                                           {{--data-toggle="modal"--}}
                                           {{--data-target=".modal-show"--}}
                                           href="#"
                                           id="">Cancelar
                                        </a>

                                    @endif
                                @endif


                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Emissao/Emitidas"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>




@stop

