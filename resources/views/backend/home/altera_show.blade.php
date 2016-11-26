{!!Form::open([ 'method' => 'post', 'route' => ['backend.altera']  ]) !!}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$texto != false ? 'Altera': 'Novo'}}</h4>


</div>


<div class="modal-body">


    @if($texto)
        {!! Form::hidden('id',$texto->id) !!}

        <div class="form-group form-group-sm">
            {!!  Form::label(($texto->type != 'p' ? 'title' :'text'),($texto->type != 'p' ? 'Title' :'Subtitle'),['class'=>'label label-info'])!!}

            {!! Form::text(($texto->type != 'p' ? 'title' :'text'),($texto->type != 'p' ? $texto->title : $texto->text),
            ['class'=>'form-control']) !!}
        </div>

        @if($texto->type == 'li')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        {!!  Form::label('status_id','Status',['class'=>'label label-info'])!!}
                        {!! Form::select('status_id',[1=>'Ativo',2=>'Inativo'], $texto->status_id,['class'=>'form-control']) !!}
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        {!!  Form::label('order_li','Ordem',['class'=>'label label-info'])!!}
                        {!! Form::select('order_li',[1=>1,2=>2,3=>3,4=>4,5=>5], $texto->order_li,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group form-group-sm">
            {!!  Form::label('text','Novidades',['class'=>'label label-info'])!!}

                {!! Form::textArea('text', $texto->text,
                ['class'=>'form-control']) !!}
            </div>
        @endif

    @else
        {!! Form::hidden('type','li') !!}

        <div class="form-group form-group-sm">
            {!!  Form::label('title','Title',['class'=>'label label-info'])!!}
            {!! Form::text('title','', ['class'=>'form-control']) !!}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    {!!  Form::label('status_id','Status',['class'=>'label label-info'])!!}
                    {!! Form::select('status_id',[1=>'Ativo',2=>'Inativo'], 1,['class'=>'form-control']) !!}
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    {!!  Form::label('order_li','Ordem',['class'=>'label label-info'])!!}
                    {!! Form::select('order_li',[1=>1,2=>2,3=>3,4=>4,5=>5], 1,['class'=>'form-control']) !!}
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!!  Form::label('text','Novidades',['class'=>'label label-info'])!!}
            {!! Form::textArea('text', '',
            ['class'=>'form-control']) !!}
        </div>

    @endif


</div>

<div class="modal-footer">

    <div class="btn-group btn-group-xs">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

    </div>

    <div class="btn-group btn-group-xs">
    <button type="submit" class="btn btn-success" target="_blank">Salvar</button>

    </div>

</div>
{!!Form::close()!!}

