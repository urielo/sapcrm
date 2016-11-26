@extends('layouts.backend')


@section('content')

    <div class="col-md-10 col-md-offset-1 content-body altera-homepage">
        <div class="panel panel-default">


            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        @if(Session::has('sucesso'))
                            <div class="alert alert-info" id="sucesso">
                                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {!! Session::get('sucesso')!!}
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-danger" id="sucesso">
                                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {!! Session::get('error') !!}
                            </div>
                        @elseif(Session::has('atencao'))
                            <div class="alert alert-warning" id="sucesso">
                                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {!! Session::get('atencao')!!}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="panel panel-info titulo">
                            <div class="panel-heading panel-heading-sm">
                                <h2 class="panel-title">Titulo</h2>
                            </div>

                            <div class="panel-body" style="text-align: center">

                                <h5>{{$textos::where('type','h1')->first()->title}}</h5>

                                <div class=" pull-right btn-group btn-group-xs ">
                                    <button data-toggle="modal"
                                            data-target=".modal-show"
                                            class="pull-right btn btn-primary " href="{{route('homepage.modal',$crypt::encrypt('h1'))}}">Alterar <i class="glyphicon glyphicon-edit"></i></button>

                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="panel panel-success subtitulo">
                            <div class="panel-heading panel-heading-sm">
                                <h2 class="panel-title">Subtitulo</h2>
                            </div>

                            <div class="panel-body" style="text-align: center">

                                <p>{{$textos::where('type','p')->first()->text}}</p>

                                <div class=" pull-right btn-group btn-group-xs ">
                                    <button data-toggle="modal"
                                            data-target=".modal-show"
                                            class="pull-right btn btn-primary " href="{{route('homepage.modal',$crypt::encrypt('p'))}}">Alterar <i class="glyphicon glyphicon-edit"></i></button>

                                </div>


                            </div>

                        </div>

                    </div>
                    <div class="col-md-12">

                        <div class="panel panel-success news">
                            <div class="panel-heading panel-heading-sm">
                                <h2 class="panel-title">Novidades</h2>
                            </div>

                            <div class="table-responsive">

                                <div class="panel-body" style="text-align: center">


                                    <div class="pull-right btn-group btn-group-xs">
                                        <button  data-toggle="modal"
                                                 data-target=".modal-show" class=" btn btn-success" href="{{route('homepage.modal',$crypt::encrypt('novo'))}}">
                                            ADD <i class="glyphicon glyphicon-plus"></i>
                                        </button>

                                    </div>





                                </div>

                                <table class="table table-condensed text-center">
                                    <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Texto</th>
                                        <th>Status</th>
                                        <th>Ordem</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($textos::where('type','li')->get() as $li)
                                        <tr>
                                            <td class="col-md-3">{{$li->title}}</td>
                                            <td class="col-md-5">{!! html_entity_decode($li->text) !!}</td>
                                            <td class="col-md-1">{{$li->status->descricao}}</td>
                                            <td class="col-md-1">{{$li->order_li}}</td>
                                            <td class="col-md-2">
                                                <div class="btn-group btn-group-xs ">

                                                    <button  data-toggle="modal"
                                                             data-target=".modal-show"
                                                             class="btn btn-primary " href="{{route('homepage.modal',$crypt::encrypt($li->id))}}">Alterar <i class="glyphicon glyphicon-edit"></i></button>
                                                    <a class="btn btn-danger " href="{{route('homepage.delete',$crypt::encrypt($li->id))}}">Deletar <i class="glyphicon glyphicon-minus"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>

    <div class="modal fade modal-show" tabindex="-1" role="dialog" aria-labelledby="Emissao/Emitidas"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>

@stop