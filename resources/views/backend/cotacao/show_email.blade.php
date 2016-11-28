{!!Form::open([ 'method' => 'post', 'route' => ['cotacao.sendemail']  ]) !!}
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Cotação - Email<h4>
</div>
<div class="modal-body">
    <div class="container-fluid">

        {!! Form::hidden('cotacao_id',Crypt::encrypt($cotacao->idcotacao)) !!}

        <div class="form-group">
            {!! Form::label('email', 'E-mail',['class'=>'label label-info']) !!}
            <div class="input-group input-group-sm">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                {!! Form::email('email', (strlen($cotacao->segurado->cliemail) > 5 ? strtolower($cotacao->segurado->cliemail): ''),  ['class' => 'form-control']) !!}
            </div>

        </div>
    </div>
</div>

</div>
<div class="modal-footer">
    <div class="btn-group btn-group-xs">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    </div>
    <div class="btn-group btn-group-xs">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>

</div>
{!!Form::close()!!}
