@extends('layouts.cotacao')

@section('panelcolor','default')
@section('heading', 'Cotar')


@section('contentSeg')



    {!!Form::open([ 'method' =>'post', 'route' =>['cotacao.gerar'] , 'id' => 'formcotacao' ]) !!}

    <div class="row">
        <div class="col-md-12 ">

            <div class="row">
                <div class="col-md-12 " id="c-veiculo">
                    <div class="row">
                        <!--Incio - Escolha Veiculo-->
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-title" style="text-align: center;">Dados do Veiculo</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group form-group-sm">
                                        <div class="row" id="rowtipoveiculo">

                                            <div class="col-md-2  col-lg-offset-1">
                                                <div class="radio">
                                                    <b>Tipo Veiculo:</b>
                                                </div>
                                            </div>

                                            <?php $first = TRUE; ?>
                                            @foreach($tipos::all() as $tipo)

                                                <div class="col-md-2 ">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="radi radio-success"
                                                                   name="tipoveiculo" id="tipoveiculo"
                                                                   value="{{$tipo->idtipoveiculo}}" {!! $first ? 'checked' : '' !!}>
                                                            {{$tipo->desc}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $first = FALSE; ?>

                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="col-md-8 ">
                                            <div class="form-group form-group-sm">
                                                <label for="veiculo" class="label label-default">Codigo Fipe -
                                                    Veiculo</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="codefip-text">000000-0</span>
                                                    <input class="form-control form-control-sm form-control-danger"
                                                           type="text"
                                                           name="veiculo" aria-describedby="basic-addon1" id="veiculo"/>
                                                </div>
                                                <input type="hidden" name="codefipe" id="codefip-value" value=""/>
                                            </div>
                                        </div>

                                        <div class="col-md-4  hide" id="divano">
                                            <div class="form-group form-group-sm">
                                                <label for="anom" class="label label-default">Ano Modelo - Combustivel -
                                                    Valor</label>
                                                <select name="anom" id="anom" class="form-control form-control-sm">

                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row hide" id="dadosveiculos">
                                        <div class="col-md-12 ">

                                            <div class="row">
                                                <div class="col-md-2  ">
                                                    <div class="form-group form-group-sm">
                                                        <label for="anof" class="label label-default">Fabricação</label>
                                                        <select name="anof" id="anof"
                                                                class="form-control form-control-sm">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="placa">Placa</label>
                                                        <input class="form-control form-control-sm" type="text"
                                                               tipoinput="placa" stats="1" name="placa" id="placa"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default"
                                                               for="munplaca">Município </label>
                                                        <input class="form-control form-control-sm" type="text"
                                                               name="munplaca" id="placa"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="placauf">UF</label>
                                                        <select name="placauf" id="placauf"
                                                                class="form-control form-control-sm"
                                                                style="font-size: 12px; padding: 0;">
                                                            @foreach($ufs::all() as $uf)
                                                                <option value="{{$uf->cd_uf}}"
                                                                        style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-sm">
                                                    <div class="col-md-3 ">
                                                        <div class="radio" style="margin-top: 15%;">
                                                            <b>Auto 0KM? </b>
                                                            <label>
                                                                <input type="radio" name="indautozero" id="indautozero"
                                                                       value="1">
                                                                Sim
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="indautozero" id="indautozero"
                                                                       value="0" checked>
                                                                Não
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="renavan">Renavan</label>
                                                        <input class="form-control form-control-sm" type="text"
                                                               tipoinput="renavan" stats="1" name="renavan"
                                                               id="renavan"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="anorenav">Ano
                                                            Renavan</label>
                                                        <select name="anorenav" id="anorenav"
                                                                class="form-control form-control-sm">
                                                            <?php for ($i = 1989; $i <= date('Y') + 1; $i++): ?>
                                                            <option value="{{$i}}">{{$i}}</option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="chassi">Chassi </label>
                                                        <input class="form-control form-control-sm" stats="1"
                                                               tipoinput="chassi" type="text"
                                                               name="chassi" id="chassi"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2  ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="veiccor">Cor</label>
                                                        <input class="form-control form-control-sm" type="veiccor"
                                                               name="veiccor" id="chassi"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 ">
                                                    <div class="form-group form-group-sm">
                                                        <label class="label label-default" for="veicultilizacao">Ultilização</label>
                                                        <select name="veicultilizacao" id="veicultilizacao"
                                                                class="form-control form-control-sm"
                                                                style="font-size: 12px; padding: 0;">
                                                            @foreach($tipoultiveics::orderBy('idutilveiculo', 'ASC')->get() as $tipoulti)
                                                                <option value="{{$tipoulti->idutilveiculo}}"
                                                                        style="font-size: 12px;">{{$tipoulti->descutilveiculo}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm">
                                                <div class="row">

                                                    <div class="col-md-4  col-md-offset-2 -2">
                                                        <div class="radio">
                                                            <b>Chassi Remarcado? </b>
                                                            <label>
                                                                <input type="radio" name="indcahssiremarc"
                                                                       id="indcahssiremarc" value="1">
                                                                Sim
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="indcahssiremarc"
                                                                       id="indcahssiremarc" value="0" checked>
                                                                Não
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4  ">
                                                        <div class="radio">
                                                            <b>Comprado em Leilão? </b>
                                                            <label>
                                                                <input type="radio" name="indleilao" id="indleilao"
                                                                       value="1">
                                                                Sim
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="indleilao" id="indleilao"
                                                                       value="0" checked>
                                                                Não
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim - Escolha Veiculo-->
                    </div>

                    <!--Incio - Dados Cliente-->

                    <div class="panel panel-default hide" id="panelsegurado">
                        <div class="panel-heading">
                            <h2 class="panel-title" style="text-align: center;">Dados do Segurado</h2>
                        </div>
                        <div class="panel-body">

                            <div class="form-group form-group-sm">
                                <div class="row">
                                    <div class="col-md-4  col-lg-offset-4">
                                        <div class="radio">
                                            <b>Tipo de Pessoa? </b>
                                            <label>
                                                <input type="radio" name="tipopessoa" id="tipopessoa" value="1" checked>
                                                Física
                                            </label>
                                            <label>
                                                <input type="radio" name="tipopessoa" id="tipopessoa" value="2">
                                                Jurídica
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="dadospessoafisca">

                                <div class="col-md-12 ">

                                    <div class="row" id="fisica1">
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segcpf">CPF</label>
                                                <input class="form-control form-control-sm" stats="1" tipoinput="cpf"
                                                       type="text" pessoa="segurado" data-msg="#msg-segcpf"
                                                       name="segcpf"
                                                       id="segcpf"/>
                                                <div id="msg-segcpf"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segnome">Nome Completo </label>
                                                <input class="form-control form-control-sm" type="text" name="segnome"
                                                       id="segnome"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segdatanasc">Data
                                                    Nascimento</label>
                                                <input class="form-control form-control-sm" type="text" value=""
                                                       tipoinput="data-nascimento" stats="1" name="segdatanasc"
                                                       id="segdatanasc"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segsexo">Sexo</label>
                                                <select name="segsexo" id="segsexo"
                                                        class="form-control form-control-sm">

                                                    <option value="1">Masculino</option>
                                                    <option value="2">Feminino</option>

                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row" id="juridica1">
                                        <div class="col-md-3 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segcnpj">CNPJ</label>
                                                <input class="form-control form-control-sm" type="text" name="segcnpj"
                                                       stats="1" pessoa="segurado" tipoinput="cnpj" id="segcnpj"/>

                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrazao">Razão Social </label>
                                                <input class="form-control form-control-sm" type="text" name="segrazao"
                                                       id="segrazao"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segdatafund">Data
                                                    Fundação</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="data-normal" stats="1" name="segdatafund"
                                                       id="segdatafund"/>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row" id="fisica2">

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segestadocivil">Estado
                                                    Civil</label>
                                                <select name="segestadocivil" id="segestadocivil"
                                                        class="form-control form-control-sm">
                                                    @foreach($estadoscivis::orderBy('idestadocivil','asc')->get() as $estadoscivil)
                                                        @if($estadoscivil->idestadocivil !=0)
                                                            <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrg">RG</label>
                                                <input class="form-control form-control-sm" type="text" name="segrg"
                                                       stats="1" tipoinput="rg"
                                                       id="segrg"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrgoe">Orgão Emissor</label>
                                                <select name="segrgoe" id="segrgoe"
                                                        class="form-control form-control-sm">
                                                    @foreach($orgaoemissors::all() as $orgaoemissor)
                                                        <option value="{{$orgaoemissor->sigla}}">{{$orgaoemissor->desc_oe}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrguf">UF</label>
                                                <select name="segrguf" id="segrguf" class="form-control form-control-sm"
                                                        style="font-size: 12px; padding: 0;">
                                                    @foreach($ufs::all() as $uf)
                                                        <option value="{{$uf->cd_uf}}"
                                                                style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrgdtemissao">Data
                                                    Emissão</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       stats="1" tipoinput="data-normal" name="segrgdtemissao"
                                                       id="segrgdtemissao"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segdddcel">DDD</label>
                                                <input type="text" name="segdddcel" id="segdddcel"
                                                       stats="1" tipoinput="ddd" class="form-control form-control-sm"
                                                       value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segnmcel">Celular</label>
                                                <input class="form-control form-control-sm" type="text" name="segnmcel"
                                                       stats="1" tipoinput="cel" id="segnmcel"/>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segdddfone">DDD</label>
                                                <input type="text" name="segdddfone" id="segdddfone"
                                                       stats="1" tipoinput="ddd" class="form-control form-control-sm"
                                                       value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segnmfone">Fone</label>
                                                <input class="form-control form-control-sm" type="text" name="segnmfone"
                                                       stats="1" tipoinput="fone" id="segnmfone"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segemail">Email</label>
                                                <input class="form-control form-control-sm"
                                                       placeholder="email@email.com" type="email" name="segemail"
                                                       id="segemail"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segcep">CEP</label>
                                                <input type="text" name="segcep" id="segcep"
                                                       stats="1" tipoinput="cep" class="form-control form-control-sm"
                                                       value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segendlog">Logradouro</label>
                                                <input type="text" name="segendlog" id="segendlog"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segnmend">Numero</label>
                                                <input class="form-control form-control-sm" type="text" name="segnmend"
                                                       id="segnmend"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segendcompl">Complemento</label>
                                                <input type="text" name="segendcompl" id="segendcompl"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segendcidade">Cidade</label>
                                                <input type="text" name="segendcidade" id="segendcidade"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segrguf">UF</label>
                                                <select name="segenduf" id="segenduf"
                                                        title="Escolha o estado"
                                                        class="selectpicker form-control form-control-sm"
                                                        style="font-size: 12px; padding: 0;">
                                                    @foreach($ufs::all() as $uf)
                                                        <option id="{{$uf->nm_uf}}"
                                                                value="{{$uf->cd_uf}}">{{$uf->nm_uf}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 " id="profissao">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segprofissao">Profissao</label>
                                                <input type="text" name="segprofissao" id="segprofissao"
                                                       class="form-control form-control-sm" value=""/>
                                                <input type="hidden" name="segcdprofissao" id="segcdprofissao"
                                                       value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 " id="ramoatividade">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="segramoatividade">Ramo
                                                    Atividade</label>
                                                <input type="text" name="segramoatividade" id="segramoatividade"
                                                       class="form-control form-control-sm" value=""/>
                                                <input type="hidden" name="segcdramoatividade" id="segcdramoatividade"
                                                       value=""/>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <!--Fim - Dados Cliente-->
                    <div class="row">
                        <div class="form-group form-group-sm hide" id="pergunta">
                            <div class="col-md-4  col-md-offset-2">
                                <div class="radio">
                                    <b>Segurado é o Proprietário? </b>
                                    <label>
                                        <input type="radio" name="indproprietario" id="indproprietario" value="1"
                                               checked>
                                        Sim
                                    </label>
                                    <label>
                                        <input type="radio" name="indproprietario" id="indproprietario" value="0">
                                        Não
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="radio">
                                    <b>Segurado é o Condutor? </b>
                                    <label>
                                        <input type="radio" name="indcondutor" id="indcondutor" value="1" checked>
                                        Sim
                                    </label>
                                    <label>
                                        <input type="radio" name="indcondutor" id="indcondutor" value="0">
                                        Não
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!--Inicio - Dados Proprietario-->
                    <div class="panel panel-default hide" id="panelproprietario">
                        <div class="panel-heading">
                            <h2 class="panel-title" style="text-align: center;">Proprietário do Veiculo</h2>
                        </div>
                        <div class="panel-body">

                            <div class="form-group form-group-sm">
                                <div class="row">
                                    <div class="col-md-4  col-lg-offset-4">
                                        <div class="radio">
                                            <b>Tipo de Pessoa? </b>
                                            <label>
                                                <input type="radio" name="proptipopessoa" id="tipopessoa"
                                                       value="1"
                                                       checked>
                                                Física
                                            </label>
                                            <label>
                                                <input type="radio" name="proptipopessoa" id="tipopessoa"
                                                       value="2">
                                                Jurídica
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="propripessoafisca">

                                <div class="col-md-12 ">

                                    <div class="row" id="propfisica1">

                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propnome">Nome
                                                    Completo </label>
                                                <input class="form-control form-control-sm" type="text"
                                                       name="propnome"
                                                       id="propnome"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propdatanasc">Data
                                                    Nascimento</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       stats="1" tipoinput="data-nascimento" name="propdatanasc"
                                                       id="propdatanasc"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propsexo">Sexo</label>
                                                <select name="propsexo" id="propsexo"
                                                        class="form-control form-control-sm">

                                                    <option value="1">Masculino</option>
                                                    <option value="2">Feminino</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propestadocivil">Estado
                                                    Civil</label>
                                                <select name="propestadocivil" id="propestadocivil"
                                                        class="form-control form-control-sm">
                                                    @foreach($estadoscivis::all() as $estadoscivil)
                                                        <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" id="propjuridica1">

                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="proprazao">Razão
                                                    Social </label>
                                                <input class="form-control form-control-sm" type="text"
                                                       name="proprazao"
                                                       id="nomepropurado"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propdatafund">Data
                                                    Fundação</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       stats="1" tipoinput="data-normal" name="propdatafund"
                                                       id="propdatafund"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propcnpj">CNPJ</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       stats="1" pessoa="proprietario" tipoinput="cnpj"
                                                       name="propcnpj"
                                                       id="propcnpj"/>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" id="propfisica2">

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propcpf">CPF</label>
                                                <input class="form-control form-control-sm"
                                                       pessoa="proprietario" type="text"
                                                       tipoinput="cpf" stats="2"
                                                       name="propcpf"

                                                       id="propcpf"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="proprg">RG</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="rg" stats="1" name="proprg"
                                                       id="proprg"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="proprgoe">Orgão
                                                    Emissor</label>
                                                <select name="proprgoe" id="proprgoe"
                                                        class="form-control form-control-sm"
                                                        style="font-size: 12px; padding: 0;">
                                                    @foreach($orgaoemissors::all() as $orgaoemissor)
                                                        <option value="{{$orgaoemissor->cd_oe}}"
                                                                style="font-size: 12px;">{{$orgaoemissor->desc_oe}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="proprguf">UF</label>
                                                <select name="proprguf" id="proprguf"
                                                        class="form-control form-control-sm"
                                                        style="font-size: 12px; padding: 0;">
                                                    @foreach($ufs::all() as $uf)
                                                        <option value="{{$uf->cd_uf}}"
                                                                style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="proprgdtemissao">Data
                                                    Emissão</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="data-normal"
                                                       name="proprgdtemissao" stats="1" id="proprgdtemissao"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propdddcel">DDD</label>
                                                <input type="text" name="propdddcel" id="propdddcel"
                                                       tipoinput="DDD" stats="1"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propnmcel">Celular</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="cel" stats="1" name="propnmcel"
                                                       id="propnmcel"/>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propdddfone">DDD</label>
                                                <input type="text" name="propdddfone" id="propdddfone"
                                                       tipoinput="ddd" stats="1"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propnmfone">Fone</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="fone" stats="1"
                                                       name="propnmfone" id="propnmfone"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propemail">Email</label>
                                                <input class="form-control form-control-sm" type="email"
                                                       placeholder="email@email.com" name="propemail"
                                                       id="propemail"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propcep">CEP</label>
                                                <input type="text" name="propcep" id="propcep"
                                                       tipoinput="cep" stats="1"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propendlog">Logradouro</label>
                                                <input type="text" name="propendlog" id="propendlog"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propnmend">Numero</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       name="propnmend"
                                                       id="propnmend"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propendcompl">Complemento</label>
                                                <input type="text" name="propendcompl" id="propendcompl"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>


                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propendcidade">Cidade</label>
                                                <input type="text" name="propendcidade" id="propendcidade"
                                                       class="form-control form-control-sm" value=""/>
                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propenduf"  >UF</label>
                                                <select name="propenduf" id="propenduf"
                                                        title="Escolha o estado"
                                                        class="selectpicker form-control form-control-sm"
                                                        style="font-size: 12px; padding: 0;"
                                                >
                                                    @foreach($ufs::all() as $uf)
                                                        <option id="{{$uf->nm_uf}}"
                                                                value="{{$uf->cd_uf}}">{{$uf->nm_uf}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-5 " id="propprofissao">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default"
                                                       for="propprofissao">Profissao</label>
                                                <input type="text" name="propprofissao" id="propprofissao"
                                                       class="form-control form-control-sm" value=""/>
                                                <input type="hidden" name="propcdprofissao" id="propcdprofissao"
                                                       value=""/>
                                            </div>
                                        </div>

                                        <div class="col-md-5 " id="propramoatividade">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="propramoatividade">Ramo
                                                    Atividade</label>
                                                <input type="text" name="propramoatividade"
                                                       id="propramoatividade"
                                                       class="form-control form-control-sm" value=""/>
                                                <input type="hidden" name="propcdramoatividade"
                                                       id="propcdramoatividade"
                                                       value=""/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <!--Fim - Dados Proprietario-->

                    <!--Inicio - Dados Condutor-->
                    <div class="panel panel-default hide" id="panelcondutor">
                        <div class="panel-heading">
                            <h2 class="panel-title" style="text-align: center;">Principal Condutor</h2>
                        </div>
                        <div class="panel-body">


                            <div class="row" id="conddados">

                                <div class="col-md-12 ">

                                    <div class="row">

                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="condnome">Nome Completo </label>
                                                <input class="form-control form-control-sm" type="text" name="condnome"
                                                       id="condnome"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="conddatanasc">Data
                                                    Nascimento</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="data-nascimento" stats="1" name="conddatanasc"
                                                       id="conddatanasc"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="condsexo">Sexo</label>
                                                <select name="condsexo" id="condsexo"
                                                        class="form-control form-control-sm">

                                                    <option value="1">Masculino</option>
                                                    <option value="2">Feminino</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="condestadocivil">Estado
                                                    Civil</label>
                                                <select name="condestadocivil" id="condestadocivil"
                                                        class="form-control form-control-sm">
                                                    @foreach($estadoscivis::all() as $estadoscivil)
                                                        <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-2 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="condcpf">CPF</label>
                                                <input class="form-control form-control-sm" type="text" name="condcpf"
                                                       tipoinput="cpf" pessoa="condutor" stats="3" id="condcpf"/>
                                            </div>
                                        </div>

                                        <div class="col-md-5 ">
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="condprofissao">Profissao</label>
                                                <input type="text" name="condprofissao" id="condprofissao"
                                                       class="form-control form-control-sm" value=""/>
                                                <input type="hidden" name="condcdprofissao" id="condcdprofissao"
                                                       value=""/>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>


                        </div>

                    </div>
                    <!--Fim - Dados Condutor-->

                    <div class="row">
                        <div class="col-md-12" id="condutor-proprietario">

                            <div class="row">

                            </div>


                        </div>


                    </div>

                </div>

                <div class="col-md-3 hide" id="produtopagamento">
                    <div class="row">
                        <!--Incio - Escolha Produtos Master-->
                        <div class="col-md-12 ">
                            <div class="panel panel-default " id="panelprodutosmaster">
                                <div class="panel-heading">
                                    <h2 class="panel-title" style="text-align: center;">Produtos</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="row produto" id="produtos">

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--Fim- Escolha Produtos Master-->
                        <!--Incio - Escolha Produtos Opcional-->
                        <div class="col-md-12 ">
                            <div class="panel panel-default " id="panelprodutosopcional">
                                <div class="panel-heading">
                                    <h2 class="panel-title" style="text-align: center;">Opcionais</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="row produto" id="produtosopcionais">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim- Escolha Produtos Opcional-->

                    @role('altera-comissao')
                    <!--Inicio - Escolha Margem-->

                        <div class="col-md-12 ">
                            <div class="panel panel-default hide" id="panelmargem">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3  col-md-offset -2">
                                            <p class="form-control-static" style="font-weight: bold;">Margem:</p>
                                        </div>
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-5 ">
                                                <div class="form-inline">
                                                    <div class="input-group">
                                                        <select name="comissao" id="comissao"
                                                                class="selectpicker form-control form-control-sm"
                                                                style="padding: 0;">
                                                            <option value="{{Auth::user()->corretor->corrcomissaopadrao}}"
                                                                    selected>{{Auth::user()->corretor->corrcomissaopadrao}}</option>
                                                            <option value="{{Auth::user()->corretor->corrcomissaomin}}">{{Auth::user()->corretor->corrcomissaomin}}</option>
                                                        </select>
                                                        <span class="input-group-addon" id="porcentsimbol">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endrole
                    <!--Fim- Escolha Margem-->


                        <!--Inicio - Escolha Forma Pagamento-->
                        <div class="col-md-12 ">

                            <div class="panel panel-success hide" id="panelpagamento">
                                <div class="panel-heading">
                                    <h2 class="panel-title" style="text-align: center;">Total a pagar: <strong
                                                id="valortotal"></strong></h2>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 ">

                                            @foreach($formapagamentos::all() as $forma)
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-info btn-xs {!! ($first ? 'active':'') !!}">
                                                        <input type="radio" name="formapagamento" id="formapagamento"
                                                               value='{!!json_encode(["idforma"=>$forma->idformapgto, "maxparc" =>$forma->nummaxparc, "parcsemjuros"=>  $forma->numparcsemjuros, "juros"=>  $forma->taxamesjuros])!!}'
                                                                {!! ($first ? 'checked':'') !!}>{{$forma->descformapgto}}
                                                    </label>
                                                    <?php $first = TRUE; ?>
                                                </div>
                                            @endforeach
                                            <div id="parcelas">
                                                <label class="label label-default">
                                                    <input type="radio" name="quantparcela" id="formapagamento"
                                                           value="1">1
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row produto" id="parcelas">


                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--Fim- Escolha Forma Pagamento-->

                        <!--Inicio - Dados Cartao-->
                        <div class="col-md-12 " id="dadoscartao">

                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    <h2 class="panel-title" style="text-align: center;">Dados do Cartão</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 ">

                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="cartaonumero">Nº Cartão</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       tipoinput="num-cartao" stats="1" name="cartaonumero"
                                                       id="cartaonumero"/>
                                            </div>
                                            <div class="form-group form-group-sm">
                                                <label class="label label-default" for="cartaonumero">Titular do
                                                    Cartão</label>
                                                <input class="form-control form-control-sm" type="text"
                                                       placeholder="Nome proprietario do cartão" name="cartaonome"
                                                       id="cartaonome"/>
                                            </div>


                                        </div>

                                        <div class="form-group form-group-sm col-md-6 ">
                                            <label class="label label-default" for="cartaobandeira">Bandeira
                                                Cartão</label>
                                            <select name="cartaobandeira" id="cartaobandeira"
                                                    class="form-control form-control-sm">

                                                <option value="visa">Visa</option>
                                                <option value="mastercard">MasterCard</option>

                                            </select>
                                        </div>

                                        <div class="form-group form-group-sm col-md-6 ">
                                            <label class="label label-default" for="cartaovalidade">Data
                                                Validade</label>
                                            <input class="form-control form-control-sm" type="text"
                                                   tipoinput="data-validade-cartao" stats="1" name="cartaovalidade"
                                                   id="cartaovalidade"/>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            <!--Fim- Dados do cartao-->
                        </div>

                    </div>
                </div>

            </div>


            <!--Incio - Botão-->
            <div class="row produto hide" id="btnproposta">

                <div class="col-md-12 ">
                    <div class="form-group form-group-sm" style="float: right;">
                        <label for="btnvender">
                            <button type="button" class="btn btn-primary" style="float: right;" id="btnvender">Vender
                            </button>
                        </label>
                    </div>
                    <div class="form-group form-group-sm" style="float: right;">
                        <label for="btnsubmit">
                            <button type="submit" class="btn btn-lg btn-success  pull-right" id="btnsubmit">Confirmar
                            </button>
                        </label>
                    </div>
                </div>
            </div>
            <!--Fim - Botão-->

        </div>
    </div>


    {!!Form::close()!!}
@stop