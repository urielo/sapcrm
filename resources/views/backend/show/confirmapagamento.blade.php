{!!Form::open([ 'method' => 'post', 'route' => ['gestao.confirmapg']  ]) !!}
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
            @if($proposta->idformapg == 1)

                @foreach($proposta->cobranca as $cobranca)
                    <h4 style="text-align: center"> Dados Cartão</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <b>NOME: </b> {{nomeCase($cobranca->cartao->nome)}}
                        </div>

                        <div class="col-md-4">
                            <b>BANDEIRA: </b> {{$cobranca->cartao->bandeira}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <b>NUMERO: </b> {{format('cartao',$cobranca->cartao->numero) }}
                        </div>
                        <div class="col-md-3">
                            <b>CVV: </b> {{ $cobranca->cartao->cvv }}
                        </div>
                        <div class="col-md-4">
                            <b>VALIDAED: </b> {{date('m/Y',strtotime($cobranca->cartao->validade . '01')) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <b>VALOR: </b> R$ {{format('real', $cobranca->vlcartao) }}
                        </div>
                        <div class="col-md-4">
                            <b>PARCELAS: </b> {{ $cobranca->parcelas}}X
                        </div>
                    </div>
                @endforeach



                <hr>
                <h4 style="text-align: center"> Dados Pagamento</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            {!! Form::label('cvrecibocartao', 'Codigo de Verificação') !!}

                            {!! Form::text('cvrecibocartao',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'CV do recibo do cartão', 'id'=>"cvrecibocartao"]) !!}

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('datapgto', 'Data do Pagamamento') !!}

                            {!! Form::text('datapgto',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'DD/MM/YYYY', 'id'=>"datapgto"]) !!}

                        </div>
                    </div>
                </div>

            @else


                @foreach($proposta->cobranca as $cobranca)
                    <div class="row">
                        <div class="col-md-6">
                            <b>VENCIMENTO PRIMEIRA: </b> {!! date('d/m/Y',strtotime($cobranca->dtvencimento)) !!}
                        </div>
                        <div class="col-md-6">
                            <b>VALOR DA PRIMEIRA: </b> R$ {{format('real',$proposta->primeiraparc)}}
                        </div>
                    </div>
                @endforeach

                <hr>
                <h4 style="text-align: center"> Dados Boleto</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            {!! Form::label('bancoboleto', 'Banco Emissor') !!}

                            {!! Form::text('bancoboleto',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'Banco emissor boleto', 'id'=>"bancoboleto"]) !!}

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            {!! Form::label('numboleto', 'Numero Boleto') !!}

                            {!! Form::text('numboleto',
                            '',
                            ['class'=> 'form-control form-control-sm', 'placeholder'=> 'Numero Boleto', 'id'=>"numboleto"]) !!}

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('datapgto', 'Data do Pagamamento') !!}

                            {!! Form::text('datapgto',
                            '',
                            ['class'=> 'form-control form-control-sm', 'tipoinput'=>'data-pagamento-boleto','placeholder'=> 'DD/MM/YYYY', 'id'=>"datapgto"]) !!}

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




