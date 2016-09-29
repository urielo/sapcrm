@extends('layouts.pdf')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <htmlpageheader class="pull-right" name="page-header">
                <img src="{{ theme('images/logo-qbe.png') }}" alt="" style="width: 100px">
            </htmlpageheader>
        </div>

        <div class="col-md-12 title">
            <h4>CERTIFICADO DO SEGURO QBE AUTO</h4>
            <h6>Seguradora: QBE Brasil Seguros S/A - CNPJ: 96.348.677/0001-94 - Processo SUSEP n°
                15414.901946/2014-12</h6>
            <h6>Estipulante: SKYPROTECTION TECNOLOGIA DE INFORMAÇÃO VEICULAR - CNPJ: 17.241.995/0001-85</h6>

        </div>

        <div class="col-md-12">
            <table class="table">

                <tbody>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr class="spacing">
                                <td><b>Proposta: </b> $idproposta</td>
                                <td><b>Apólice: </b> $idapolice</td>
                                <td><b>Certifica: </b> $idcertificado</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr class="spacing">
                                <td><b>Produto:</b> Seguro AUTOPRATICO</td>
                                <td><b>Data de Emissão: </b> $dataemissao</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>

                </tbody>
            </table>

            {{-- Incio dados do segurado--}}
            <table class="table">
                <thead>
                <tr>
                    <th>Dados do segurado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr class="spacing">
                                <td><b>Nome: </b> $idproposta</td>
                                <td><b>CPF: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Endereço: </b> $idproposta</td>
                                <td><b>Complemento: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Bairro: </b> $idproposta</td>
                                <td><b>Cidade: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Estado: </b> $idproposta</td>
                                <td><b>CEP: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Telefone Residencial: </b> $idproposta</td>
                                <td><b>Telefone Celular: </b> $idapolice</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>


                </tbody>
            </table>
            {{-- Fim dados do segurado--}}

            {{-- Inico dados do veiculo--}}
            <table class="table">

                <tbody>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr>
                                <td><b>Vigência da cobertura: </b> A partir das 24:00 horas do dia 00/00/00 (data de
                                    emissão) e terminará às 24:00 do dia 00/00/00 (1 ano a partir da data de início)
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr class="spacing">
                                <td><b>Marca: </b> $idproposta</td>
                                <td><b>Modelo: </b> $idapolice</td>
                                <td><b>Veículo 0 Km: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Chassi: </b> $idproposta</td>
                                <td><b>Renavam: </b> $idapolice</td>
                                <td><b>Ano: </b> $idapolice</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Placa: </b> $idproposta</td>
                                <td><b>Cor: </b> $idapolice</td>
                                <td><b>Combustível: </b> $idapolice</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <table class="table-bordered">
                            <tbody>
                            <tr>
                                <td><b>Valor do veículo:</b></td>
                                <td><b>Faixa de valor selecionada: </b></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>


                </tbody>
            </table>
            {{-- Fim dados do veiculo--}}

            {{-- Incio Quadro de cobertura--}}
            <table class="table">
                <thead>
                <tr>
                    <th>Quadro de Cobertura</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <table class="table-bordered pdf-center">
                            <tbody>
                            <tr class="">
                                <td><b>Cobertura </b></td>
                                <td><b>Prêmio<br>(cobertura) </b><br></td>
                                <td><b>Carência </b></td>
                                <td><b>Franquia </b></td>
                                <td><b>Limite Máximo de Indenização</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Roubo ou Furto Total</b></td>
                                <td><b>R$ 000,00</b></td>
                                <td><b>Não Há</b></td>
                                <td><b> Não Há </b></td>
                                <td rowspan="2"><b>100% do valor referenciado pela Tabela FIPE *, exceto para Taxi e
                                        veículos salvados**.</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Indenização Integral por Colisão </b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Não Há </b></td>
                            </tr>
                            <tr class="">
                                <td><b>Assistência 24 Horas Veículos</b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Não Há </b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Assistência 24 Horas Residencial Completa</b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Não Há </b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Assistência a Vidros(Reparo/Troca de Vidros - para veículo importado a cobertura
                                        de troca de vidro não está inclusa).</b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Franquia para-brisa ou vigia R$ 180,00 / Franquia vidros laterais R$ 80,00 </b>
                                </td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Reparo de Para-choque</b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Reparo de para-choque de veículos nacionais R$120,00 / Franquia Reparo de
                                        para-choque de veículos importados R$ 180,00</b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Serviço de Reparo de Pintura</b></td>
                                <td><b>X Un²</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Haverá cobrança por peça reparada conforme quadro a seguir: Franquias SRA. /
                                        Franquia 1º peça reparada R$ 50,00. / Franquia a partir da 2º peça reparada
                                        (cada peça) R$ 10,00.</b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>


                </tbody>
            </table>
            {{-- Fim Quadro de cobertura--}}

            {{-- Incio Quadro de valor--}}
            <table class="table table-bordered">

                <tbody>
                <tr>
                    <td>
                        <b>Prêmio Líquido:</b>
                    </td>
                    <td>
                        <b>IOF:</b>
                    </td>
                    <td>
                        <b>Prêmio Total:</b>
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <b>Forma de pagamento:</b>
                    </td>
                    <td>
                        <b>Periodicidade:</b>
                    </td>


                </tr>


                </tbody>
            </table>
            {{-- Fim Quadro de valor--}}


        </div>

        <div class="col-md-12 obs">
            <p>
                (*) O valor de mercado referenciado será aquele determinado na tabela FIPE, divulgada no site <a
                        href="">www.fipe.com.br</a> e na revista Motor Show. Caso a tabela FIPE esteja extinta na
                ocasião do sinistro, será utilizada como referência para o cálculo da importância segurada a tabela
                MOLICAR, divulgada no site
                <a href="">www.molicar.com.br</a>.<br>
                (**) Taxi: Importância Máxima Segurada de 70% do valor referenciado pela Tabela FIPE.
            </p>
        </div>

        <div class="seguro">
            <p>
                Seguro garantido pela QBE Brasil Seguros S/A – CNPJ 96.348.677/0001-94 – Código SUSEP: 594-1. Este
                documento contém um resumo das condições gerais aplicáveis ao seguro. As disposições aqui referidas são
                uma breve descrição do produto. Restrições se aplicam. Para mais informações, consulte as condições
                gerais do seguro com o regulamento do sorteio, à disposição no site <a href="">www.qbe.com.br</a>. O
                plano de seguro
                também pode ser consultado no site da SUSEP: <a href="">
                    http://www.susep.gov.br/menu/informacoes-ao-publico/planos-e-produtos/consulta-publica-de-produtos-1</a>.
                <b>A
                    contratação do seguro é opcional, sendo possível a desistência da contratação em até 7(sete) dias
                    corridos com a devolução integral do valor pago, pelo mesmo meio exercido para a contratação. É
                    proibido
                    condicionar desconto no preço do bem à aquisição do seguro, vincular a aquisição de bem à
                    contratação
                    compulsória de qualquer tipo de seguro ou ofertar bens em condições mais vantajosas para quem
                    contrata
                    plano de seguro.</b> Estipulante: SKYPROTECTION TECNOLOGIA DE INFORMAÇÃO VEICULAR- CNPJ
                17.241.995/0001-85,
                Endereço: Rua Vieira de Morais, N.1495 – Campo Belo - São Paulo/SP, CEP 04617-015, Telefone: (11)
                2770-1600. Corretora: Lógica Corretora de Seguros Ltda, Código SUSEP 100.196.452, CNPJ:
                58795055/0001-15, 1Título de Capitalização, da modalidade incentivo, emitido pela Sul América
                Capitalização S.A. - Sulacap, CNPJ 03.558.096/0001-04, Processo SUSEP 15414.901526/2013-47. Prêmio no
                valor bruto de R$ 30.000,00 com incidência de 25% de IR, conforme legislação vigente. <b>SUSEP:</b>
                Superintendência de Seguros Privados – Autarquia Federal responsável pela fiscalização, normatização e
                controles dos mercados de seguro, previdência complementar aberta, capitalização, resseguro e corretagem
                de seguros. O registro do produto e a aprovação do título de capitalização na SUSEP não implica, por
                parte da Autarquia, incentivo ou recomendação à sua comercialização, representando, exclusivamente, sua
                adequação às normas em vigor. Será pago ao estipulante, a título de pró-labore, 0% (zero). Tenho ciência
                que poderei consultar a situação cadastral do corretor de seguros no site <a
                        href=""><b>www.susep.gov.br</b></a>, por meio de
                seu nº de registro na SUSEP, nome completo, CNPJ ou CPF. <b>Este seguro é por prazo determinado tendo a
                    seguradora a faculdade de não renovar a apólice ao final da vigência, sem devolução dos prêmios
                    pagos
                    nos termos da apólice.</b> QBE Brasil Seguros S/A – Ouvidoria 0800 770 0824 Cx. Postal 29217 – CEP:
                04561-970 – São Paulo – SP – E-mail: <a href="">ouvidoria@qbe.com.br</a>. SAC QBE: 0800 774 4419. <b>Central
                    de
                    Atendimento a Sinistro: 0800 723 2886. Central de Atendimento Gratuito SUSEP – 0800 021 8484 -
                    Atendimento Exclusivo ao Consumidor (9h30 às 17h00).</b>
            </p>
        </div>
        <div class="title">
            <h4>ESPECIFICAÇÕES DO SEGURO QBE AUTO</h4>
        </div>
        <div>
            <ol>
                <li><b>Coberturas</b></li>
                <ol>
                    <li class="sub">
                        <p>
                            <b>Roubo ou Furto Total:</b> garante ao segurado o pagamento de indenização por Roubo ou
                            Furto
                            Total do veículo segurado não localizado até a data de pagamento do sinistro, exceto se
                            decorrentes de riscos excluídos e observados os demais itens da Condição Geral. Estão
                            abrangidos também os prejuízos resultantes de um mesmo sinistro de Roubo e/ou Furto de um
                            veículo segurado localizado que, somados sejam iguais ou superiores a 75% (setenta e cinco
                            por cento) do valor do veículo conforme modalidade contratada.
                        </p>
                    </li>
                    <li class="sub">
                        <p>
                            <b>Indenização Integral por Colisão: </b> garante ao segurado o
                            pagamento de indenização integral do veículo segurado, quando os prejuízos, resultantes de
                            um mesmo sinistro, atingirem ou ultrapassarem a quantia apurada a partir de determinado
                            percentual (máximo de 75%) sobre o valor definido na apólice ou sobre o valor de cotação do
                            veículo segurado, de acordo com a tabela de referência contratualmente estabelecida e em
                            vigor na data do aviso do sinistro, multiplicado pelo fator de ajuste, exceto se decorrentes
                            de riscos excluídos e observados os demais itens desta Condição Especial e das Condições
                            Gerais do Plano de Seguro de Automóvel.
                        </p>
                    </li>
                </ol>
            </ol>
        </div>
    </div>








@stop