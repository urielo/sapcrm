{!!Form::open([ 'method' => 'post', 'route' => ['apolices.emitir']  ]) !!}
{!! Form::hidden('proposta',$proposta->idproposta) !!}


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Emissão</h4>
    <div class="row">
        <div class="col-md-4">
            <b>Proposta:</b> {{$proposta->idproposta}}
        </div>
        <div class="col-md-8"><b>Corretor(a): </b>{{nomeCase($proposta->cotacao->corretor->corrnomerazao)}}</div>
        <div class="col-md-8"><b>Segurado(a): </b>{{nomeCase($proposta->cotacao->segurado->clinomerazao)}}</div>
    </div>


    <div class="row">

        <div class="col-md-4 pull-right">
            {!! Form::label('datavirgencia', 'Inicio Virgencia') !!}

            <div class="input-group date">
                {!! Form::text('datavirgencia',date('d/m/Y'),
                                           ['class'=> 'form-control form-control-sm',
                                           'data-date-format'=> 'dd/mm/yyyy',
                                           'placeholder'=> 'DD/MM/YYYY',
                                           'readonly'=>true,
                                           'id'=>"datavirgencia",
                                           ]) !!}
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>

        </div>
    </div>
</div>


<div class="modal-body">

    <?php $count_retorno = count($retorno)?>
    @foreach($retorno as $custos)
        <div class="row">
            <?php $count_custos = count($custos)?>
            <?php $first = TRUE;?>
            @foreach($custos as $custo)
                <div class="col-md-12">
                    <div class="row">
                        @if($first)

                            <div class="col-md-6 col-md-offset-4 radio">
                                <label>
                                    {!! Form::radio('seguradora', $custo->seguradora->idseguradora, true,['class'=>'radio']) !!}
                                    {{$custo->seguradora->segnome}}
                                </label>
                            </div>

                            <?php $first = FALSE;?>
                        @endif

                        <div class="col-md-12"><b>Produto: </b>{{$custo->produto->nomeproduto}}</div>
                        <div class="col-md-6"><b>Custo Anual: </b>R$ {{format('real',$custo->custo_anual)}} </div>
                        <div class="col-md-6"><b>Custo Mensal: </b>R$ {{format('real',$custo->custo_mensal)}}</div>
                    </div>

                    @if($count_custos > 1)
                        <br>
                        <?php $count_custos = $count_custos - 1 ?>
                    @endif

                </div>

            @endforeach

        </div>
        @if($count_retorno > 1)
            <hr>
            <?php $count_retorno = $count_retorno - 1 ?>

        @endif

    @endforeach
</div>

<div class="modal-footer">

    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-success">Emitir</button>

</div>
{!!Form::close()!!}
