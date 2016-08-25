@extends('layouts.cotacao')


@section('panelcolor','info')
@section('heading')

    <div class="form-group row" style="margin: 0px ">
        <div class="col-md-2 col-md-offset-2">Usuários</div>

        <div class="col-md-3 pull-right">
            {!! Form::text('search',null,['class'=>'search form-control','placeholder'=>'Search', 'id'=>'buscaruser']) !!}
        </div>
    </div>

@stop
@section('contentSeg')

    <div class="col-md-12 apolice table-responsive">
        <div class="table">
            <table class="table table-xs table-hover  results" style="text-align: center; padding-top: 0; padding-bottom: 0;">
                <thead>
                <tr >
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Corretor(a)</th>
                    <th>Status</th>
                    <th></th>

                </tr>
                <tr class="warning no-result">
                    <td colspan="4"><i class="fa fa-warning"></i>Usuário não encontradot</td>
                </tr>
                </thead>
                <tbody>

                @foreach ($usuarios as $usuario)

                    <tr>
                        <td scope="row"><a href="#" class="">{!! nomeCase($usuario->nome) !!}</a>
                        <td><a href="#" class="">{{$usuario->email}}</a></td>
                        </td>
                        <td>
                            {!! nomeCase($usuario->corretor->corrnomerazao) !!}

                        </td>
                        <td class="{{($usuario->idstatus == 1 ? 'alert-success' : 'alert-danger' )}}">{{$usuario->status->descricao}}

                        </td>
                        <td>


                            <div class="btn-group" role="group">
                                <a href="{{route('usuarios.alterstatus',$usuario->id)}}">
                                    <button type="button"
                                            class="btn {{ ($usuario->idstatus == 1 ? 'btn-danger' : 'btn-primary' ) }} btn-xs"
                                    >{{ ($usuario->idstatus == 1 ? 'Desativar' : 'Ativar' ) }}
                                    </button>
                                </a>

                            </div>


                        </td>


                    </tr>

                @endforeach
                </tbody>
            </table>
            <center>{{$usuarios->render()}}</center>
        </div>




@stop