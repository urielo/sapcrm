@extends('layouts.backend')

@section('content')
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            @foreach($roles as $role)

                <li><a href="?role={{$role->name}}">{{$role->display_name}}</a></li>

                @if(!isset($request->role) && $role->id == 1)
                    <?php
                    $role_permisson = $role;
                        $role_name = $role->display_name;
                    ?>
                @elseif($request->role == $role->name)
                    <?php
                    $role_name = $role->display_name;
                    $role_permisson = $role;
                    ?>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="col-md-8 col-md-offset-2" style="padding: 2%" >
        <h3 style="text-align: center">{{$role_name}}</h3>

        @if(Session::has('sucesso'))
            <div class="alert alert-info" id="sucesso">
                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{Session::get('sucesso')}}
            </div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger" id="sucesso">
                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{Session::get('error')}}
            </div>
        @elseif(Session::has('atencao'))
            <div class="alert alert-warning" id="sucesso">
                <button type="button" class="close" aria-label="Close" id="fechasecesso">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{Session::get('atencao')}}
            </div>
        @endif

        <div class="row">


            {!!Form::open([ 'method' => 'post', 'route' => ['grupos.update']  ]) !!}

            {!! Form::hidden('role_id',$role_permisson->id) !!}
            @foreach($permissions as $permission )
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div class="form-check">
                        <label class="form-check-label">
                            {!! Form::checkbox('permissions[]',$permission->id,
                            ($role_permisson->perms()->where('id',$permission->id)->first()->id  ? true : false)
                            ,['class'=>'form-check-input']) !!}
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
            <div class="btn-group btn-group-xs pull-right">
                <button type="submit" class="btn btn-primary btn-xs">
                    Salvar
                </button>
            </div>
            {!!Form::close()!!}
        </div>



{{--( $role_permisson->has($permission->name) ? true : false )--}}
    </div>


@stop


