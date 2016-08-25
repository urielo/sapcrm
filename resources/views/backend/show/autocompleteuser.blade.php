@foreach ($usuarios as $usuario)


        <td><a href="#" class="">{!! nomeCase($usuario->nome) !!}</a>
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
                            class="btn {{ ($usuario->idstatus == 1 ? 'btn-danger' : 'btn-primary' ) }} btn-sm"
                    >{{ ($usuario->idstatus == 1 ? 'Desativar' : 'Ativar' ) }}
                    </button>
                </a>

            </div>


        </td>



@endforeach