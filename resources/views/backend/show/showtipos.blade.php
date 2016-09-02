{!!Form::open([ 'method' => 'post', 'route' => ['usuarios.alteratipos']  ]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Tipos Usuários</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            @foreach($roles as $role)
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div class="form-check">
                        <label class="form-check-label">
                            {!! Form::checkbox('roles[]',$role->name, ( $usuario->hasRole($role->name) ? true : false ),['class'=>'form-check-input']) !!}
                            {{ $role->display_name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-success">Efetuar</button>
</div>
{!!Form::close()!!}




