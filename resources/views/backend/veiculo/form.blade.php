@extends('layouts.segurado')


@section('heading', 'Cotar')


@section('contentSeg')

{!!Form::model($segurados, [ 'method' => $segurados->exixts ? 'put' : 'post', 'route' => $segurados->exixts ? ['cotacao.gerar'] : ['cotacao.gerar']  ]) !!}

<div class="row">
    <div class="col-md-12">

        <div class="row">

            <!--Incio - Escolha Veiculo-->
            <div class="col-md-12" id="c-veiculo">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="text-align: center;">Dados do Veiculo</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">

                                <div class="col-md-2 col-lg-offset-1">
                                    <div class="radio">         
                                        <b>Tipo Veiculo:</b>
                                    </div>
                                </div>

                                <?php $frist = TRUE; ?>
                                @foreach($tipos::all() as $tipo)               

                                <div class="col-md-2">
                                    <div class="radio">
                                        <label >
                                            <input type="radio" name="tipoveiculo" id="tipoveiculo" value="{{$tipo->idtipoveiculo}}" {!! $frist ? 'checked' : '' !!}>
                                            {{$tipo->desc}}
                                        </label>
                                    </div>
                                </div>
                                <?php $frist = FALSE; ?>

                                @endforeach

                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md-8">
                                <div class="form-group" >
                                    <label for="veiculo">Codigo Fipe - Veiculo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="codefip-text">000000-0</span>
                                        <input class="form-control form-control-sm" type="text" data="veic" name="veiculo" aria-describedby="basic-addon1" id="veiculo" />
                                    </div>
                                    <input type="hidden" name="codefipe" id="codefip-value" value=""/>
                                </div>
                            </div>

                            <div class="col-md-4 " id="divano">
                                <div class="form-group">
                                    <label for="anom" >Ano Modelo - Combustivel - Valor</label>
                                    <select name="anom"  id="anom" class="form-control form-control-sm">

                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row" id="dadosveiculos">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="anof">Fabricação</label>
                                            <select name="anof" id="anof" class="form-control form-control-sm">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="placa">Placa</label>
                                            <input class="form-control form-control-sm" type="text" name="placa" id="placa" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="munplaca">Município </label>
                                            <input class="form-control form-control-sm" type="text" name="munplaca" id="placa" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="placauf">UF</label>
                                            <select name="placauf" id="placauf" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                                @foreach($ufs::all() as $uf)
                                                <option value="{{$uf->cd_uf}}" style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 15%;">         
                                                <b>Auto 0KM? </b>
                                                <label >
                                                    <input type="radio" name="indautozero" id="indautozero" value="1">
                                                    Sim
                                                </label>
                                                <label >
                                                    <input type="radio" name="indautozero" id="indautozero" value="0">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="renavan">Renavan</label>
                                            <input class="form-control form-control-sm" type="text" name="renavan" id="renavan" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="anorenav">Ano Renavan</label>
                                            <select name="anorenav" id="anorenav" class="form-control form-control-sm">
                                                <?php for ($i = 1989; $i <= date('Y') + 1; $i++): ?>
                                                    <option value="{{$i}}">{{$i}}</option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="chassi">Chassi </label>
                                            <input class="form-control form-control-sm" type="text" name="chassi" id="chassi" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="placauf">Tipo Ultilização</label>
                                            <select name="placauf" id="placauf" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                                @foreach($tipoultiveics::all() as $tipoulti)
                                                <option value="{{$tipoulti->idutilveiculo}}" style="font-size: 12px;">{{$tipoulti->descutilveiculo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="radio">         
                                                <b>Acidentado? </b>
                                                <label >
                                                    <input type="radio" name="indacidentado" id="indacidentado" value="1">
                                                    Sim
                                                </label>
                                                <label >
                                                    <input type="radio" name="indacidentado" id="indacidentado" value="0">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio">         
                                                <b>Alienado? </b>
                                                <label >
                                                    <input type="radio" name="indaliendado" id="indaliendado" value="1">
                                                    Sim
                                                </label>
                                                <label >
                                                    <input type="radio" name="indaliendado" id="indaliendado" value="0">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" >
                                            <div class="radio">         
                                                <b>Chassi R.? </b>
                                                <label >
                                                    <input type="radio" name="indcahssiremarc" id="indcahssiremarc" value="1">
                                                    Sim
                                                </label>
                                                <label >
                                                    <input type="radio" name="indcahssiremarc" id="indcahssiremarc" value="0">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio">         
                                                <b>Leilão? </b>
                                                <label >
                                                    <input type="radio" name="indleilao" id="indleilao" value="1">
                                                    Sim
                                                </label>
                                                <label >
                                                    <input type="radio" name="indleilao" id="indleilao" value="0">
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

            <div class="col-md-3" id="produtopagamento">
                <div class="row">

                    <!--Incio - Escolha Produtos-->
                    <div class="col-md-12">

                        <div class="panel panel-default " id="panelprodutos">
                            <div class="panel-heading">
                                <h2 class="panel-title" style="text-align: center;">Produtos</h2>
                            </div>
                            <div class="panel-body produto-scroll">
                                <div class="row produto" id="produtos">


                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Fim- Escolha Produtos-->

                    <!--Inicio - Escolha Forma Pagamento-->
                    <div class="col-md-12">

                        <div class="panel panel-default " id="panelpagamento">
                            <div class="panel-heading">
                                <h2 class="panel-title" style="text-align: center;">Forma Pagamento</h2>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong id="valortotal">

                                        </strong>
                                        <div class="btn-group" data-toggle="buttons">
                                            @foreach($formapagamentos::all() as $forma)
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="formapagamento" id="formapagamento"
                                                           value='{!!json_encode(["idforma"=>$forma->idformapgto, "maxparc" =>$forma->nummaxparc, "parcsemjuros"=>  $forma->numparcsemjuros, "juros"=>  $forma->taxamesjuros])!!}'
                                                           checked>{{$forma->descformapgto}}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="row produto" id="parcelas">


                                </div>

                            </div>
                        </div>


                    </div>
                    <!--Fim- Escolha Forma Pagamento-->
                </div>
            </div>

        </div>




        <!--Incio - Dados Cliente-->

        <div class="panel panel-default" id="panelsegurado">
            <div class="panel-heading">
                <h2 class="panel-title" style="text-align: center;">Dados do Segurado</h2>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-lg-offset-4">
                            <div class="radio">         
                                <b>Tipo de Pessoa? </b>
                                <label >
                                    <input type="radio" name="tipopessoa" id="tipopessoa" value="1" checked>
                                    Física
                                </label>
                                <label >
                                    <input type="radio" name="tipopessoa" id="tipopessoa" value="2">
                                    Jurídica
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="dadospessoafisca">

                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="segnome">Nome Completo </label>
                                    <input class="form-control form-control-sm" type="text" name="nomesegurado" id="nomesegurado" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segdatanasc">Data Nascimento</label>
                                    <input class="form-control form-control-sm" type="text" data="nascimento" name="segdatanasc" id="segdatanasc" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segsexo">Sexo</label>
                                    <select name="segsexo" id="segsexo" class="form-control form-control-sm" >

                                        <option value="1" >Masculino</option>
                                        <option value="2" >Feminino</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segestadocivil">Estado Civil</label>
                                    <select name="segestadocivil" id="segestadocivil" class="form-control form-control-sm" >
                                        @foreach($estadoscivis::all() as $estadoscivil)
                                        <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segcpf">CPF</label>
                                    <input class="form-control form-control-sm" tipo="cpf" type="text" name="segcpf" id="segcpf" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segrg">RG</label>
                                    <input class="form-control form-control-sm" type="text" name="segrg" id="segrg" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="segrgoe">Orgão Emissor</label>
                                    <select name="segrgoe" id="segrgoe" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                        @foreach($orgaoemissors::all() as $orgaoemissor)
                                        <option value="{{$orgaoemissor->cd_oe}}" style="font-size: 12px;">{{$orgaoemissor->desc_oe}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="segrguf">UF</label>
                                    <select name="segrguf" id="segrguf" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                        @foreach($ufs::all() as $uf)
                                        <option value="{{$uf->cd_uf}}" style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segrgdtemissao">Data Emissão</label>
                                    <input class="form-control form-control-sm" type="text" name="segrgdtemissao" data="emissao" id="segrgdtemissao" />
                                </div>
                            </div>                           
                        </div>

                        <div class="row">

                            <div class="col-md-1"   >
                                <div class="form-group" >         
                                    <label for="segdddcel">DDD</label>
                                    <input type="text" name="segdddcel" id="segdddcel" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  >
                                    <label for="segnmcel">Celular</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmcel" id="segnmcel" />
                                </div>
                            </div>                 

                            <div class="col-md-1"   >
                                <div class="form-group" >
                                    <label for="segdddfone">DDD</label>
                                    <input type="text" name="segdddfone" id="segdddfone" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  >
                                    <label for="segnmfone">Fone</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmfone" id="segnmfone" />
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group"  >
                                    <label for="segemail">Email</label>
                                    <input class="form-control form-control-sm" type="email" name="segemail" id="segemail" />
                                </div>
                            </div>   

                        </div>
                        <div class="row">

                            <div class="col-md-2"   >
                                <div class="form-group" >         
                                    <label for="segcep">CEP</label>
                                    <input type="text" name="segcep" id="segcep" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group"  >
                                    <label for="segnmend">Numero</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmend" id="segnmend" />
                                </div>
                            </div>                 

                            <div class="col-md-4"   >
                                <div class="form-group" >
                                    <label for="segendcompl">Complemento</label>
                                    <input type="text" name="segendcompl" id="segendcompl" class="form-control form-control-sm" value=""/>
                                </div>
                            </div> 

                            <div class="col-md-5"   >
                                <div class="form-group" >
                                    <label for="segprofissao">Profissao</label>
                                    <input type="text" name="segprofissao" id="segprofissao" class="form-control form-control-sm" value=""/>
                                    <input type="hidden" name="segcdprofissao" id="segcdprofissao" value=""/>
                                </div>
                            </div>  

                        </div>
                    </div>
                </div>


                <div class="row" id="dadospessoajuridica">

                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="segrazao">Razão Social </label>
                                    <input class="form-control form-control-sm" type="text" name="segrazao" id="nomesegurado" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="segdatanasc">Data Fundação</label>
                                    <input class="form-control form-control-sm" type="text" name="segdatanasc" id="segdatanasc" />
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="segcnpj">CNPJ</label>
                                    <input class="form-control form-control-sm" type="text" name="segcnpj" id="segcnpj" />
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-1"   >
                                <div class="form-group" >         
                                    <label for="segdddcel">DDD</label>
                                    <input type="text" name="segdddcel" id="segdddcel" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  >
                                    <label for="segnmcel">Celular</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmcel" id="segnmcel" />
                                </div>
                            </div>                 

                            <div class="col-md-1"   >
                                <div class="form-group" >
                                    <label for="segdddfone">DDD</label>
                                    <input type="text" name="segdddfone" id="segdddfone" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"  >
                                    <label for="segnmfone">Fone</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmfone" id="segnmfone" />
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group"  >
                                    <label for="segemail">Email</label>
                                    <input class="form-control form-control-sm" type="email" name="segemail" id="segemail" />
                                </div>
                            </div>   

                        </div>

                        <div class="row">

                            <div class="col-md-2"   >
                                <div class="form-group" >         
                                    <label for="segcep">CEP</label>
                                    <input type="text" name="segcep" id="segcep" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group"  >
                                    <label for="segnmend">Numero</label>
                                    <input class="form-control form-control-sm" type="text" name="segnmend" id="segnmend" />
                                </div>
                            </div>                 

                            <div class="col-md-4"   >
                                <div class="form-group" >
                                    <label for="segendcompl">Complemento</label>
                                    <input type="text" name="segendcompl" id="segendcompl" class="form-control form-control-sm" value=""/>
                                </div>
                            </div>   

                            <div class="col-md-5"   >
                                <div class="form-group" >
                                    <label for="segramoatividade">Ramo Atividade</label>
                                    <input type="text" name="segramoatividade" id="segramoatividade" class="form-control form-control-sm" value=""/>
                                    <input type="hidden" name="segcdramoatividade" id="segcdramoatividade" value=""/>
                                </div>
                            </div>                                            
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!--Fim - Dados Cliente-->

        <div class="row" id="pergunta">
            <div class="form-group">

                <div class="col-md-4 col-md-offset-2">
                    <div class="radio">         
                        <b>Segurado é o Proprietário? </b>
                        <label >
                            <input type="radio" name="indproprietario" id="indproprietario" value="1">
                            Sim
                        </label>
                        <label >
                            <input type="radio" name="indproprietario" id="indproprietario" value="0">
                            Não
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="radio">         
                        <b>Segurado é o  Condutor? </b>
                        <label >
                            <input type="radio" name="indcondutor" id="indcondutor" value="1">
                            Sim
                        </label>
                        <label >
                            <input type="radio" name="indcondutor" id="indcondutor" value="0">
                            Não
                        </label>
                    </div>
                </div>

            </div>
        </div>
        <!--Inicio - Dados Proprietario-->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default" id="panelproprietario">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="text-align: center;">Proprietário do Veiculo</h2>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4 col-lg-offset-4">
                                    <div class="radio">         
                                        <b>Tipo de Pessoa? </b>
                                        <label >
                                            <input type="radio" name="proptipopessoa" id="tipopessoa" value="1" checked>
                                            Física
                                        </label>
                                        <label >
                                            <input type="radio" name="proptipopessoa" id="tipopessoa" value="2">
                                            Jurídica
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="propripessoafisca">

                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="propnome">Nome Completo </label>
                                            <input class="form-control form-control-sm" type="text" name="propnome" id="propnome" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="propdatanasc">Data Nascimento</label>
                                            <input class="form-control form-control-sm" type="text" name="propdatanasc" id="propdatanasc" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="propsexo">Sexo</label>
                                            <select name="propsexo" id="propsexo" class="form-control form-control-sm" >

                                                <option value="1" >Masculino</option>
                                                <option value="2" >Feminino</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="propestadocivil">Estado Civil</label>
                                            <select name="propestadocivil" id="propestadocivil" class="form-control form-control-sm" >
                                                @foreach($estadoscivis::all() as $estadoscivil)
                                                <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="propcpf">CPF</label>
                                            <input class="form-control form-control-sm" type="text" tipo='cpf' name="propcpf" id="propcpf" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="proprg">RG</label>
                                            <input class="form-control form-control-sm" type="text" name="proprg" id="proprg" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="proprgoe">Orgão Emissor</label>
                                            <select name="proprgoe" id="proprgoe" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                                @foreach($orgaoemissors::all() as $orgaoemissor)
                                                <option value="{{$orgaoemissor->cd_oe}}" style="font-size: 12px;">{{$orgaoemissor->desc_oe}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="proprguf">UF</label>
                                            <select name="proprguf" id="proprguf" class="form-control form-control-sm" style="font-size: 12px; padding: 0;">
                                                @foreach($ufs::all() as $uf)
                                                <option value="{{$uf->cd_uf}}" style="font-size: 12px;">{{$uf->nm_uf}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="proprgdtemissao">Data Emissão</label>
                                            <input class="form-control form-control-sm" type="text" iden="emissao" name="proprgdtemissao" id="proprgdtemissao" />
                                        </div>
                                    </div>                           
                                </div>

                                <div class="row">

                                    <div class="col-md-1"   >
                                        <div class="form-group" >         
                                            <label for="propdddcel">DDD</label>
                                            <input type="text" name="propdddcel" id="propdddcel" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"  >
                                            <label for="propnmcel">Celular</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmcel" id="propnmcel" />
                                        </div>
                                    </div>                 

                                    <div class="col-md-1"   >
                                        <div class="form-group" >
                                            <label for="propdddfone">DDD</label>
                                            <input type="text" name="propdddfone" id="propdddfone" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"  >
                                            <label for="propnmfone">Fone</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmfone" id="propnmfone" />
                                        </div>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="form-group"  >
                                            <label for="propemail">Email</label>
                                            <input class="form-control form-control-sm" type="email" name="propemail" id="propemail" />
                                        </div>
                                    </div>   

                                </div>
                                <div class="row">

                                    <div class="col-md-2"   >
                                        <div class="form-group" >         
                                            <label for="propcep">CEP</label>
                                            <input type="text" name="propcep" id="propcep" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group"  >
                                            <label for="propnmend">Numero</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmend" id="propnmend" />
                                        </div>
                                    </div>                 

                                    <div class="col-md-4"   >
                                        <div class="form-group" >
                                            <label for="propendcompl">Complemento</label>
                                            <input type="text" name="propendcompl" id="propendcompl" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div> 

                                    <div class="col-md-5"   >
                                        <div class="form-group" >
                                            <label for="propprofissao">Profissao</label>
                                            <input type="text" name="propprofissao" id="propprofissao" class="form-control form-control-sm" value=""/>
                                            <input type="hidden" name="propcdprofissao" id="propcdprofissao" value=""/>
                                        </div>
                                    </div>  

                                </div>
                            </div>
                        </div>


                        <div class="row" id="propripessoajuridica">

                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="proprazao">Razão Social </label>
                                            <input class="form-control form-control-sm" type="text" name="proprazao" id="nomepropurado" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="propdatanasc">Data Fundação</label>
                                            <input class="form-control form-control-sm" type="text" iden="nascimento" name="propdatanasc" id="propdatanasc" />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="propcnpj">CNPJ</label>
                                            <input class="form-control form-control-sm" type="text" name="propcnpj" id="propcnpj" />
                                        </div>
                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-md-1"   >
                                        <div class="form-group" >         
                                            <label for="propdddcel">DDD</label>
                                            <input type="text" name="propdddcel" id="propdddcel" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"  >
                                            <label for="propnmcel">Celular</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmcel" id="propnmcel" />
                                        </div>
                                    </div>                 

                                    <div class="col-md-1"   >
                                        <div class="form-group" >
                                            <label for="propdddfone">DDD</label>
                                            <input type="text" name="propdddfone" id="propdddfone" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"  >
                                            <label for="propnmfone">Fone</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmfone" id="propnmfone" />
                                        </div>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="form-group"  >
                                            <label for="propemail">Email</label>
                                            <input class="form-control form-control-sm" type="email" name="propemail" id="propemail" />
                                        </div>
                                    </div>   

                                </div>

                                <div class="row">

                                    <div class="col-md-2"   >
                                        <div class="form-group" >         
                                            <label for="propcep">CEP</label>
                                            <input type="text" name="propcep" id="propcep" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group"  >
                                            <label for="propnmend">Numero</label>
                                            <input class="form-control form-control-sm" type="text" name="propnmend" id="propnmend" />
                                        </div>
                                    </div>                 

                                    <div class="col-md-4"   >
                                        <div class="form-group" >
                                            <label for="propendcompl">Complemento</label>
                                            <input type="text" name="propendcompl" id="propendcompl" class="form-control form-control-sm" value=""/>
                                        </div>
                                    </div>   

                                    <div class="col-md-5"   >
                                        <div class="form-group" >
                                            <label for="propramoatividade">Ramo Atividade</label>
                                            <input type="text" name="propramoatividade" id="propramoatividade" class="form-control form-control-sm" value=""/>
                                            <input type="hidden" name="propcdramoatividade" id="propcdramoatividade" value=""/>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--Fim - Dados Proprietario-->

        <!--Inicio - Dados Condutor-->
        <div class="panel panel-default" id="panelcondutor">
            <div class="panel-heading">
                <h2 class="panel-title" style="text-align: center;">Principal Condutor</h2>
            </div>
            <div class="panel-body">



                <div class="row" id="conddados">

                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="condnome">Nome Completo </label>
                                    <input class="form-control form-control-sm" type="text" name="condnome" id="condnome" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="conddatanasc">Data Nascimento</label>
                                    <input class="form-control form-control-sm" type="text" name="conddatanasc" id="conddatanasc" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="condsexo">Sexo</label>
                                    <select name="condsexo" id="condsexo" class="form-control form-control-sm" >

                                        <option value="1" >Masculino</option>
                                        <option value="2" >Feminino</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="condestadocivil">Estado Civil</label>
                                    <select name="condestadocivil" id="condestadocivil" class="form-control form-control-sm" >
                                        @foreach($estadoscivis::all() as $estadoscivil)
                                        <option value="{{$estadoscivil->idestadocivil}}">{{$estadoscivil->nmestadocivil}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="condcpf">CPF</label>
                                    <input class="form-control form-control-sm" type="text" tipo='cpf' name="condcpf" id="condcpf" />
                                </div>
                            </div>

                            <div class="col-md-5"   >
                                <div class="form-group" >
                                    <label for="condprofissao">Profissao</label>
                                    <input type="text" name="condprofissao" id="condprofissao" class="form-control form-control-sm" value=""/>
                                    <input type="hidden" name="condcdprofissao" id="condcdprofissao" value=""/>
                                </div>
                            </div>  

                        </div>


                    </div>
                </div>



            </div>

        </div>

        <!--Fim - Dados Condutor-->

        <!--Incio - Botão-->
        <div class="row produto" id="btnproposta">

            <div class="col-md-12">
                <div class="form-group" style="float: right;">
                    <label for="btnvender">        
                        <button type="button" class="btn btn-primary" style="float: right;" id="btnvender">Vender</button>
                    </label>
                </div>
                <div class="form-group" style="float: right;">
                    <label for="btnsubmit">        
                        <button type="submit" class="btn btn-primary" style="float: right;" id="btnsubmit">Enviar</button>
                    </label>
                </div>
            </div>
        </div>
        <!--Fim - Botão-->

    </div>








</div>





{!!Form::close()!!}
@stop