<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">{!!nomeCase($segurado->clinomerazao)!!}</h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <b> {!! ($segurado->tipop == 1 ? 'CPF' : 'CNPJ') !!}
                    : </b> {!!  format('cpfcnpj', $segurado->clicpfcnpj)!!}
            </div>
            <div class="col-md-6">
                <b> {!! ($segurado->tipop == 1 ? 'Nascimento' : 'Abertura') !!}
                    : </b> {!!  date('d/m/Y', strtotime($segurado->clidtnasc))!!}
            </div>

        </div>
        @if($segurado->tipop == 1)
            <div class="row">
                <div class="col-md-5">
                    <b> Sexo: </b> {!! ($segurado->clicdsexo == 1  ? 'Masculino' : 'Feminino') !!}
                </div>
                <div class="col-md-6">
                    <b> Estado Civil: </b> {{$segurado->estadocivil->nmestadocivil }}
                </div>
            </div>
        @endif
        @if($segurado->profissao || $segurado->ramosatividade)
            <div class="row">
                @if($segurado->tipop == 1)
                    <div class="col-md-12">
                        <b> Profissão: </b> {!! nomeCase($segurado->profissao->nm_ocupacao) !!}
                    </div>
                @else
                    <div class="col-md-12">
                        <b> Ramo de Atividade: </b> {!! nomeCase($segurado->ramosatividade->nome_atividade)!!}
                    </div>
                @endif

            </div>
        @else
            <div class="row">
                @if($segurado->tipop == 1)
                    <div class="col-md-12">
                        <b> Profissão: </b> Nenhum
                    </div>
                @else
                    <div class="col-md-12">
                        <b> Ramo de Atividade: Nenhum
                    </div>
                @endif

            </div>
        @endif


    </div>

    <h4 style="text-align: center">Contato</h4>
    <hr style=" margin-top: 0px">
    <div class="container-fluid">
        <div class="row">

            @if(strlen($segurado->clinmfone) > 4)
                <div class="col-md-6">
                    <b> Telefone: </b>({{$segurado->clidddfone}}) {!! format('fone', $segurado->clinmfone) !!}
                </div>
            @endif

            @if(strlen($segurado->clinmfone) > 4)
                <div class="col-md-6">
                    <b> Celular: </b>({{$segurado->clidddcel}}) {!! format('fone', $segurado->clinmcel) !!}
                </div>
            @endif

        </div>

        <div class="row">
            <div class="col-md-12">
                <b> Email: </b> <a href="mailto:{!! strtolower($segurado->cliemail) !!}"
                                   target="_top">{!! strtolower($segurado->cliemail) !!}</a>
            </div>

        </div>
    </div>

    <h4 style="text-align: center">Endereço</h4>
    <hr style=" margin-top: 0px">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <b> Logradouro: </b> {!! nomeCase($segurado->clinmend) !!}
            </div>

        </div>
        <div class="row">

            <div class="col-md-3">
                <b> Nº: </b> {{$segurado->clinumero}}
            </div>

            <div class="col-md-9">
                <b> Complemento: </b> {!! nomeCase($segurado->cliendcomplet) !!}
            </div>

        </div>
        <div class="row">

            <div class="col-md-6">
                <b> Cidade: </b> {!! nomeCase($segurado->clinmcidade) !!}
            </div>
            @if($segurado->uf)
                <div class="col-md-3">
                    <b> UF: </b> {!! $segurado->uf->nm_uf !!}
                </div>
            @endif
            <div class="col-md-3">
                <b> CEP: </b> {!! format('cep',$segurado->clicep) !!}
            </div>

        </div>


    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
</div>
