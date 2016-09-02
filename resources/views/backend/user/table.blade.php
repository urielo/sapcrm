<table class="table table-xs table-hover table-condensed table-datatable"
       style="text-align: center; padding-top: 0; padding-bottom: 0;" id="table-user">
    <thead>
    <tr>
        <th>#ID</th>
        <th>Usuário</th>
        <th>Tipo</th>
        <th>Email</th>
        <th>Corretor(a)</th>
        <th>Status</th>
        <th></th>

    </tr>

    </thead>
    <tbody>

    @foreach ($usuarios as $usuario)

        <tr>
            <td scope="row">{!! $usuario->id !!}</td>
            <td scope="row"><a href="#" class="">{!! nomeCase($usuario->nome) !!}</a>
            <td>
                <a class="btn btn-xs"  data-toggle="collapse" href="#{{$usuario->id}}tipos">Tipos</a>
                <div class="btn-group" role="group">
                    <button type="button"
                            data-toggle="modal"
                            data-target=".modal-altera"
                            href="{{route('usuarios.tipos',$usuario->id)}}"
                            {{--href="#"--}}
                            class="btn btn-info btn-xs" id="showinfo">Alterar</button>

                </div>
                <div class="panel-collapse collapse" id="{{$usuario->id}}tipos">
                @foreach($usuario->roles as $role)
                    {{$role->display_name}}<br>
                @endforeach
                </div>

            </td>
            <td><a href="#" class="">{{$usuario->email}}</a></td>
            <td>
                {!! nomeCase($usuario->corretor->corrnomerazao) !!}

            </td>
            <td class="{{($usuario->idstatus == 1 ? 'bg-success' : 'bg-danger' )}}">{{$usuario->status->descricao}}

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

<div class="modal fade modal-altera" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>