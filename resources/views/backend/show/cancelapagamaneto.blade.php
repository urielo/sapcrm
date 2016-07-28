{!!Form::open([ 'method' => 'post', 'route' => ['gestao.cancela']  ]) !!}
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Deseja realmente cancelar a proposta: {{$proposta->idproposta}}
        <h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="radio">
                <div class="col-md-4 col-md-offset-2">
                    <label>
                        {!! Form::radio('status', 13) !!}
                        Renegociação
                    </label>
                </div>
                <div class="col-md-4">
                    <label>
                        {!! Form::radio('status', 12, true) !!}
                        Cancelamento
                    </label>
                </div>
            </div>
        </div>

        {!! Form::hidden('idproposta',$proposta->idproposta) !!}

        <div class="form-group">
            {!! Form::label('motivo', 'Motivo') !!}

            {!! Form::select('motivo', $motivos->lists('descrição', 'id')->toArray(), null, ['class' => 'form-control form-control-sm']) !!}
            {{--<select name="anom" id="anom" class="">--}}

            {{--</select>--}}
        </div>
    </div>
</div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
    <button type="submit" class="btn btn-danger">Sim</button>
</div>
{!!Form::close()!!}
