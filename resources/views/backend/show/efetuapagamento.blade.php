{!!Form::open([ 'method' => 'post', 'route' => ['cobranca.salvarpga']  ]) !!}
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Confirmar Pagamento
        <h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            {!! Form::hidden('idproposta',$proposta->idproposta) !!}
            <div class="row">
                <div class="col-md-6">
                    <b>Forma de Pagamento: </b> {{$proposta->formapg->descformapgto}}
                </div>
                <div class="col-md-6">
                    <b>Parcelas: </b> {{$proposta->quantparc}}x
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <b>Premio: </b>R$ {!! format('real',$proposta->premiototal) !!}
                </div>
                <div class="col-md-4">
                    <b> Primeira: </b>R$ {!! format('real',$proposta->primeiraparc) !!}
                </div>
                <div class="col-md-4">
                    <b> Demais: </b>R$ {!! format('real',$proposta->demaisparc) !!}
                </div>

            </div>
            <hr>
            @if($proposta->idformapg == 1)
                <h4 style="text-align: center"> Dados Cartão</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            {!! Form::label('nomecartao', 'Nome') !!}

                            {!! Form::text('nomecartao',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'Nome do mesmo jeito do cartão ', 'id'=>"nomecartao"]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">

                            {!! Form::label('bandeiracartao', 'Bandeira') !!}

                            {!! Form::text('bandeiracartao',
                            (strlen($proposta->nmbandeira) > 0 ? $proposta->nmbandeira :'' ),
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'Bandeira', 'id'=>"bandeiracartao"]) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            {!! Form::label('nnmcartao', 'Numero') !!}

                            {!! Form::text('nnmcartao',
                            (strlen($proposta->numcartao) == 16 ? format('cartao',$proposta->numcartao) :'' ),
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> '0000 0000 0000 0000', 'id'=>"nnmcartao"]) !!}


                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">

                            {!! Form::label('valcartao', 'Validade') !!}

                            {!! Form::text('valcartao',
                            (strlen($proposta->validadecartao) > 0 ? date('m/Y', strtotime($proposta->validadecartao)) :'' ),
                            ['class'=> 'form-control form-control-sm cartao',
                            'data-date-format'=> 'mm/yyyy',
                            'placeholder'=> 'MM/YYYY',
                            'id'=>"valcartao",
                            ]) !!}


                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">

                            {!! Form::label('cvvcartao', 'CVV') !!}

                            {!! Form::text('cvvcartao',
                            (strlen($proposta->cvvcartao) > 0 ? $proposta->cvvcartao :'' ),
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> '000', 'id'=>"cvvcartao"]) !!}

                        </div>
                    </div>

                </div>

            @else
                <h4 style="text-align: center"> Dados Boleto</h4>
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <div class="form-group">

                            {!! Form::label('dataprimeira', 'Data Primeira') !!}

                            {!! Form::text('dataprimeira',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'DD/MM/YYYY', 'id'=>"dataprimeira"]) !!}

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('datademais', 'Dia Vecto. Demais') !!}

                            {!! Form::text('datademais',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'DD', 'id'=>"datademais"]) !!}

                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-success">Efetuar</button>
</div>
{!!Form::close()!!}




