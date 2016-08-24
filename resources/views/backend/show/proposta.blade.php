<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-title" style="text-align: center;">
        <h4 class="modal-title" style="text-align: center;">DADOS DA PROPOSTA</h4>

    </div>
    <div class="modal-body" style="min-height: 50%;">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-3">
                    <b>Proposta:</b> {{$proposta->idproposta}}
                </div>

                <div class="col-md-3">
                    <b>Cotacao:</b> {{$proposta->cotacao->idcotacao}}
                </div>

                <div class="col-md-6">
                    <b>Parceiro:</b> {!!nomeCase($proposta->cotacao->parceiro->nomerazao)!!}</div>

                <div class="col-md-7"><b>Forma de Pagamento:</b>  {!!$proposta->formapg->descformapgto!!}</div>
                <div class="col-md-12"><b>Premium:</b> R$ {!!format('real',$proposta->premiototal)!!} em {{$proposta->quantparc}}x (1x de R$ {!!format('real',$proposta->primeiraparc)!!} e {!! $proposta->quantparc - 1 !!}x de R$ {!!format('real',$proposta->demaisparc)!!})</div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>


            </div>
        </div>


    </div>
    <hr>


    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#segurado">Segurado</a>
                </h4>
            </div>
            <div id="segurado" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <b> {!! (strlen($proposta->cotacao->segurado->clicpfcnpj) > 11 ?  'CNPJ' : 'CPF' ) !!}
                                : </b> {!!  format('cpfcnpj', $proposta->cotacao->segurado->clicpfcnpj)!!}
                        </div>
                        <div class="col-md-6">
                            <b> {!! (strlen($proposta->cotacao->segurado->clicpfcnpj) > 11  ?  'Abertura' : 'Nascimento') !!}
                                : </b> {!!  date('d/m/Y', strtotime($proposta->cotacao->segurado->clidtnasc))!!}
                        </div>

                    </div>

                    @if(strlen($proposta->cotacao->segurado->clicpfcnpj) < 12)
                        <div class="row">
                            <div class="col-md-5">
                                <b>
                                    Sexo: </b> {!! ($proposta->cotacao->segurado->clicdsexo == 1  ? 'Masculino' : 'Feminino') !!}
                            </div>
                            <div class="col-md-6">
                                <b> Estado Civil: </b> {{$proposta->cotacao->segurado->estadocivil->nmestadocivil }}
                            </div>
                        </div>
                    @endif
                    @if($proposta->cotacao->segurado->profissao || $proposta->cotacao->segurado->ramosatividade)
                        <div class="row">
                            @if(strlen($proposta->cotacao->segurado->clicpfcnpj) < 14)
                                <div class="col-md-12">
                                    <b>
                                        Profissão: </b> {!! nomeCase($proposta->cotacao->segurado->profissao->nm_ocupacao) !!}
                                </div>
                            @else
                                <div class="col-md-12">
                                    <b> Ramo de
                                        Atividade: </b> {!! nomeCase($proposta->cotacao->segurado->ramosatividade->nome_atividade)!!}
                                </div>
                            @endif

                        </div>
                    @else
                        <div class="row">
                            @if(strlen($proposta->cotacao->segurado->clicpfcnpj) < 12)
                                <div class="col-md-12">
                                    <b> Profissão: </b> Nenhum
                                </div>
                            @else
                                <div class="col-md-12">
                                    <b> Ramo de Atividade: </b>Nenhum
                                </div>
                            @endif

                        </div>
                    @endif


                </div>

                <hr style=" margin-top: 0px">
                <div class="container-fluid">
                    <div class="row">

                        @if(strlen($proposta->cotacao->segurado->clinmfone) > 4)
                            <div class="col-md-6">
                                <b> Telefone: </b>({{$proposta->cotacao->segurado->clidddfone}}
                                ) {!! format('fone', $proposta->cotacao->segurado->clinmfone) !!}
                            </div>
                        @endif

                        @if(strlen($proposta->cotacao->segurado->clinmfone) > 4)
                            <div class="col-md-6">
                                <b> Celular: </b>({{$proposta->cotacao->segurado->clidddcel}}
                                ) {!! format('fone', $proposta->cotacao->segurado->clinmcel) !!}
                            </div>
                        @endif

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <b> Email: </b> <a
                                    href="mailto:{!! strtolower($proposta->cotacao->segurado->cliemail) !!}"
                                    target="_top">{!! strtolower($proposta->cotacao->segurado->cliemail) !!}</a>
                        </div>

                    </div>
                </div>

                <hr style=" margin-top: 0px">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <b> Logradouro: </b> {!! nomeCase($proposta->cotacao->segurado->clinmend) !!}
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <b> Nº: </b> {{$proposta->cotacao->segurado->clinumero}}
                        </div>

                        <div class="col-md-9">
                            <b> Complemento: </b> {!! nomeCase($proposta->cotacao->segurado->cliendcomplet) !!}
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <b> Cidade: </b> {!! nomeCase($proposta->cotacao->segurado->clinmcidade) !!}
                        </div>
                        @if($proposta->cotacao->segurado->uf)
                            <div class="col-md-3">
                                <b> UF: </b> {!! $proposta->cotacao->segurado->uf->nm_uf !!}
                            </div>
                        @endif
                        <div class="col-md-3">
                            <b> CEP: </b> {!! format('cep',$proposta->cotacao->segurado->clicep) !!}
                        </div>

                    </div>


                </div>

            </div>
        </div>

    </div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#veiculo">Veiculo</a>
                </h4>
            </div>
            <div id="veiculo" class="panel-collapse collapse">
                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-4">
                            <b> Fipe: </b> {!!  $proposta->cotacao->veiculo->veiccodfipe !!}
                        </div>

                        <div class="col-md-8">
                            <b> Marca: </b> {!!  $proposta->cotacao->veiculo->fipe->marca !!}
                        </div>

                        <div class="col-md-10">
                            <b> Modelo: </b> {!!  $proposta->cotacao->veiculo->fipe->modelo !!}
                        </div>

                        <div class="col-md-3">
                            <b> Ano: </b> {!!  $proposta->cotacao->veiculo->veicano!!}
                        </div>
                        <div class="col-md-5">
                            <b> Placa: </b> {!!  format('placa',$proposta->cotacao->veiculo->veicplaca) !!}
                        </div>


                    </div>


                    <hr style=" margin-top: 0px">


                </div>

            </div>
        </div>
    </div>

</div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
