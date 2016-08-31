<table class="table table-xs table-hover table-condensed results" style="text-align: center; padding-top: 0; padding-bottom: 0;" id="table-user">
    <thead>
    <tr >
        <th>#ID</th>
        <th>Usuário</th>
        <th>Email</th>
        <th>Corretor(a)</th>
        <th>Status</th>
        <th></th>

    </tr>
    {{--<tr class="warning no-result">--}}
    {{--<td colspan="4"><i class="fa fa-warning"></i>Usuário não encontradot</td>--}}
    {{--</tr>--}}
    </thead>
    <tbody>

    @foreach ($usuarios as $usuario)

        <tr>
            <td scope="row">{!! $usuario->id !!}</td>
            <td scope="row"><a href="#" class="">{!! nomeCase($usuario->nome) !!}</a>
            <td><a href="#" class="">{{$usuario->email}}</a></td>
            </td>
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