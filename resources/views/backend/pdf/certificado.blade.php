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
                                <td><b>Proposta: </b> {{$proposta->idproposta}}</td>
                                <td><b>Apólice: </b> 3620</td>
                                <td><b>Certificado: </b> {{$certificado->id}}</td>
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
                                <td><b>Data de Emissão: </b> {{ showDate($certificado->dt_emissao) }}</td>
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
                                <td><b>Nome: </b> {{nomeCase($proposta->cotacao->segurado->clinomerazao)}}</td>
                                <td><b>CPF: </b> {!! format('cpfcnpj',$proposta->cotacao->segurado->clicpfcnpj) !!}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Endereço: </b> {{$proposta->cotacao->segurado->clinmend}}
                                    , {{$proposta->cotacao->segurado->clinumero}} </td>
                                <td><b>Complemento: </b> {{$proposta->cotacao->segurado->cliendcomplet}}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Bairro: </b></td>
                                <td><b>Cidade: </b> {{nomeCase($proposta->cotacao->segurado->clinmcidade)}}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Estado: </b> {{$proposta->cotacao->segurado->uf->nm_uf}}</td>
                                <td><b>CEP: </b> {!! format('cep',$proposta->cotacao->segurado->clicep) !!}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Telefone
                                        Residencial: </b> {!! (strlen($proposta->cotacao->segurado->clinmfone) > 4 ? '('.$proposta->cotacao->segurado->clidddfone.') '. format('fone',$proposta->cotacao->segurado->clinmfone) : '') !!}
                                </td>
                                <td><b>Telefone
                                        Celular: </b> {!! (strlen($proposta->cotacao->segurado->clinmfone) > 4 ? '('.$proposta->cotacao->segurado->clidddcel.') '. format('fone',$proposta->cotacao->segurado->clinmcel) : '') !!}
                                </td>
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
                                <td><b>Vigência da cobertura: </b> A partir das 24:00 horas do
                                    dia {{ showDate($certificado->dt_inicio_virgencia) }} e terminará às 24:00 do
                                    dia {{ showDate($certificado->dt_inicio_virgencia,'+1 year') }}
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
                                <td><b>Marca: </b> {{$proposta->cotacao->veiculo->fipe->marca}}</td>
                                <td><b>Modelo: </b> {{$proposta->cotacao->veiculo->fipe->modelo}}</td>
                                <td><b>Veículo 0
                                        Km: </b> {!! ($proposta->cotacao->veiculo->veicautozero ? 'Sim':'Não') !!}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Chassi: </b> {{$proposta->cotacao->veiculo->veicchassi}}</td>
                                <td><b>Renavam: </b> {{$proposta->cotacao->veiculo->veicrenavam}}</td>
                                <td><b>Ano: </b> {{$proposta->cotacao->veiculo->veicano}}</td>
                            </tr>
                            <tr class="spacing">
                                <td><b>Placa: </b> {{format('placa',$proposta->cotacao->veiculo->veicplaca)}}</td>
                                <td><b>Cor: </b> {{$proposta->cotacao->veiculo->veicor}} </td>
                                <td><b>Combustível: </b> {{$proposta->cotacao->veiculo->combustivel->nm_comb}}</td>
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
                                @foreach($proposta->cotacao->veiculo->fipe->anovalor as $valor)
                                    @if($valor->ano == $proposta->cotacao->veiculo->veicano && $valor->idcombustivel == $proposta->cotacao->veiculo->veictipocombus)
                                        <td><b>Valor do veículo:</b> R$ {{format('real',$valor->valor)}}</td>
                                    @endif
                                @endforeach

                                @foreach($proposta->cotacao->produtos as $produto)



                                    @foreach($produto->produto->precoproduto as $preco)
                                        @if($preco->idprecoproduto == $produto->idprecoproduto && $produto->idproduto == 1)
                                            <td><b>Faixa de valor
                                                    selecionada: </b>R$ {{format('real',$preco->vlrfipeminimo)}} -
                                                R$ {{format('real',$preco->vlrfipemaximo)}} </td>
                                        @endif
                                    @endforeach

                                @endforeach

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
                                <td><b>{!!  $custos[1]->custo !!} </b></td>
                                <td><b>Não Há</b></td>
                                <td><b> Não Há </b></td>
                                <td rowspan="2"><b>100% do valor referenciado pela Tabela FIPE *, exceto para
                                        Taxi e
                                        veículos salvados**.</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Indenização Integral por Colisão </b></td>
                                <td><b>{!! $custos[19]->custo  !!} </b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Não Há </b></td>
                            </tr>
                            <tr class="">
                                <td><b>Assistência 24 Horas Veículos</b></td>
                                <td><b>{!!$custos[4]->custo !!} </b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Não Há </b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Assistência a Vidros(Reparo/Troca de Vidros - para veículo importado a
                                        cobertura
                                        de troca de vidro não está inclusa).</b></td>
                                <td><b>{!! $custos[5]->custo !!}</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Franquia para-brisa ou vigia R$ 180,00 / Franquia vidros laterais R$
                                        80,00 </b>
                                </td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Reparo de Para-choque</b></td>
                                <td><b> {!! $custos[6]->custo !!}</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Reparo de para-choque de veículos nacionais R$120,00 / Franquia Reparo de
                                        para-choque de veículos importados R$ 180,00</b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            <tr class="">
                                <td><b>Serviço de Reparo de Pintura</b></td>
                                <td><b>{!! $custos[7]->custo !!}</b></td>
                                <td><b>Não Há</b></td>
                                <td><b>Haverá cobrança por peça reparada conforme quadro a seguir: Franquias
                                        SRA. /
                                        Franquia 1º peça reparada R$ 50,00. / Franquia a partir da 2º peça
                                        reparada
                                        (cada peça) R$ 10,00.</b></td>
                                <td><b>Limites da Assistência</b></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td>
                        <small style="color: red">S/C: Sem Cobertura</small>
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
                        <b>Prêmio Líquido: </b> R$ {{ format('real',$custos['premioLiquido']) }}
                    </td>
                    <td>
                        <b>IOF:</b> {{str_replace('.',',',$certificado->iof)}}%
                    </td>
                    <td>
                        <b>Prêmio Total:</b> R$ {{format('real',$custos['premioTotal']) }}
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <b>Forma de pagamento: </b> {{$proposta->quantparc}}x no {{$proposta->formapg->descformapgto}}
                    </td>
                    <td>
                        <b>Periodicidade:</b> Anual
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
                gerais do seguro, à disposição no site <a href="">www.qbe.com.br</a>. O
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
                58795055/0001-15. <b>SUSEP:</b>
                Superintendência de Seguros Privados – Autarquia Federal responsável pela fiscalização, normatização e
                controles dos mercados de seguro, previdência complementar aberta, capitalização, resseguro e corretagem
                de seguros. O registro do produto na SUSEP não implica, por parte da Autarquia, incentivo ou
                recomendação à sua comercialização, representando, exclusivamente, sua adequação às normas em vigor.
                Será pago ao estipulante, a título de pró-labore, 0% (zero). Tenho ciência que poderei consultar a
                situação cadastral do corretor de seguros no site <a
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
                <li><b>Coberturas</b>
                    <ol>
                        <li class="sub">
                            <p>
                                <b>Roubo ou Furto Total:</b> garante ao segurado o pagamento de indenização por Roubo ou
                                Furto
                                Total do veículo segurado não localizado até a data de pagamento do sinistro, exceto se
                                decorrentes de riscos excluídos e observados os demais itens da Condição Geral. Estão
                                abrangidos também os prejuízos resultantes de um mesmo sinistro de Roubo e/ou Furto de
                                um
                                veículo segurado localizado que, somados sejam iguais ou superiores a 75% (setenta e
                                cinco
                                por cento) do valor do veículo conforme modalidade contratada.
                            </p>
                        </li>
                        <li class="sub">
                            <p>
                                <b>Indenização Integral por Colisão: </b> garante ao segurado o
                                pagamento de indenização integral do veículo segurado, quando os prejuízos, resultantes
                                de
                                um mesmo sinistro, atingirem ou ultrapassarem a quantia apurada a partir de determinado
                                percentual (máximo de 75%) sobre o valor definido na apólice ou sobre o valor de cotação
                                do
                                veículo segurado, de acordo com a tabela de referência contratualmente estabelecida e em
                                vigor na data do aviso do sinistro, multiplicado pelo fator de ajuste, exceto se
                                decorrentes
                                de riscos excluídos e observados os demais itens desta Condição Especial e das Condições
                                Gerais do Plano de Seguro de Automóvel.
                            </p>
                        </li>
                    </ol>
                </li>
                <li><b>Principais Riscos Excluídos:</b>
                    <ol type="a">
                        <li>Sinistros não
                            decorrentes de Roubo ou Furto Total do veículo segurado;
                        </li>
                        <li>Lucros cessantes ou quaisquer prejuízos financeiros pela paralisação do veículo, mesmo
                            quando
                            causados por risco coberto;
                        </li>
                        <li>Perdas parciais, ou seja, quaisquer danos causados ao veículo roubado ou furtado quando o
                            montante dos prejuízos não seja igual ou superior a 75% (setenta e cinco por cento) do valor
                            do
                            veículo, conforme modalidade contratada;
                        </li>
                        <li>Quaisquer bens ou acessórios no interior ou instalados no veículo, mesmo que em decorrência
                            de
                            sinistro coberto;
                        </li>
                        <li>Custos relativos à blindagem do veículo segurado;</li>
                        <li>Danos causados a terceiros;</li>
                        <li>Desvalorização do veículo segurado, em virtude da remarcação do chassi, bem como qualquer
                            outra
                            forma de depreciação que o mesmo venha a sofrer, inclusive àquela decorrente do sinistro,
                            uso do
                            bem ou ainda decorrente de anotação no documento do veículo segurado.
                        </li>
                    </ol>
                    <p>Os Riscos excluídos na íntegra constam nas Condições Gerais do Plano de Seguro de Automóvel,
                        disponível no site:
                        <a href="">www.qbe.com.br</a></p>
                </li>
                <li>
                    <b>Segurado</b>
                    <p>
                        É considerada a pessoa física com idade mínima de 18 (dezoito) anos na data de ingresso ao
                        seguro e que seja cliente do estipulante.
                    </p>
                </li>
                <li><b>Beneficiários</b>
                    <p>O beneficiário deste seguro é o próprio Segurado.</p></li>
                <li><b> Suspensão e Reabilitação do Seguro</b>
                    <p>Ocorrendo a falta de pagamento do prêmio ou de parcela dele na data prevista, as coberturas deste
                        seguro ficarão automaticamente suspensas a partir das 24hrs desta data, voltando a vigorar a
                        partir das 24hrs do dia da regularização do pagamento do prêmio, desde que não tenha
                        ultrapassado o prazo de 60 (sessenta) dias, sendo vedada a cobrança de prêmio pelo período de
                        suspensão da cobertura.
                        <br>
                        <b>Decorrido o prazo de 60 (sessenta) dias da data do inadimplemento, sem que o prêmio tenha
                            sido pago, o seguro será cancelado, sendo o segurado/estipulante notificado com antecedência
                            mínima de 15 (quinze) dias corridos antes do término do referido prazo.
                            <br> </b> Qualquer indenização/reembolso somente será devida se o prêmio relativo ao período
                        de ocorrência do sinistro houver sido pago na data avençada, a cobertura não estiver suspensa e
                        desde que o seguro já não esteja cancelado.</p></li>
                <li><b>Cancelamento do Seguro</b>
                    <p>Decorrido o prazo referido de 60 (sessenta) dias, sem que tenha sido quitado o prêmio do seguro,
                        o contrato ou aditamento a ele referente ficará automaticamente e de pleno direito cancelado,
                        independentemente de qualquer interpelação judicial ou extrajudicial; <br>
                        Se o estipulante deixar de recolher à seguradora prêmios recebidos, tal fato não ensejará o
                        cancelamento dos respectivos certificados individuais e nem a suspensão de suas coberturas,
                        ficando o estipulante sujeito às sanções penais, civis e administrativas que forem cabíveis;
                        <br>
                        O segurado é obrigado a comunicar a seguradora, logo que saiba qualquer fato suscetível de
                        agravar o risco coberto. </p></li>
                <li><b>Cessação da Cobertura Individual</b>
                    <ol type="a">
                        <li> Automaticamente com o desaparecimento do vínculo entre segurado e estipulante;</li>
                        <li>Quando o segurado solicitar expressamente sua exclusão da apólice ou quando deixar de
                            contribuir com sua parte no prêmio;
                        </li>
                        <li>Com o fim de vigência da apólice, respeitado o período correspondente ao prêmio pago, se
                            esta não for renovada;
                        </li>
                        <li>Pela seguradora ou estipulante no aniversário da apólice com aviso prévio de 60 (sessenta)
                            dias no mínimo;
                        </li>
                        <li>Se o segurado, seus prepostos ou seus beneficiários agirem com dolo, culpa grave, cometerem
                            fraude ou simulação no ato da contratação ou durante a vigência do contrato ou ainda para
                            obter ou para majorar a indenização, não cabendo qualquer restituição de prêmio, ficando a
                            sociedade seguradora isenta de qualquer responsabilidade.
                        </li>
                    </ol>
                </li>
                <li>
                    <b>Perda de Direito à Indenização</b>
                    <p>A seguradora não pagará qualquer indenização com base no presente seguro, caso haja por parte do
                        estipulante, do segurado, seus prepostos ou beneficiários:</p>
                    <ol type="a">
                        <li>Inexatidão ou omissão nas declarações prestadas pelo estipulante, pelo segurado ou pelo
                            corretor de seguros, que influam na aceitação da proposta ou no valor do prêmio, no ato da
                            contratação deste seguro ou durante toda sua vigência, bem como por ocasião da regulação do
                            sinistro, ficando obrigado o segurado ao pagamento do prêmio vencido; <br>
                            Se a inexatidão ou a omissão nas declarações não resultar de má fé do segurado, a sociedade
                            seguradora poderá:
                            <ol type="I">
                                <li><b>Na hipótese de não ocorrência de sinistro:</b>
                                    <ul>
                                        <li>
                                            <p>Cancelar o seguro retendo, do prêmio originalmente pactuado, a parcela
                                                proporcional
                                                ao tempo decorrido;</p>
                                        </li>
                                    </ul>
                                </li>
                                <li><b>Na hipótese de ocorrência de sinistro com pagamento parcial do capital
                                        segurado:</b>
                                    <ul>
                                        <li>
                                            <p>Cancelar o seguro, após o pagamento da indenização, retendo, do prêmio
                                                originalmente pactuado, acrescido da diferença cabível, a parcela
                                                calculada proporcionalmente ao tempo decorrido; ou</p>
                                        </li>
                                    </ul>
                                </li>
                                <li><b>Na hipótese de ocorrência de sinistro com pagamento integral do capital segurado,
                                        cancelar o seguro, após o pagamento da indenização, deduzindo, do valor a ser
                                        indenizado, a diferença de prêmio cabível.</b></li>
                            </ol>
                        </li>
                        <li>Inobservância das obrigações convencionadas neste seguro e na lei, inclusive a de comunicar
                            à seguradora, logo que saiba, qualquer fato suscetível de agravar o risco coberto pela
                            apólice, se comprovado que silenciou de má fé;
                        </li>
                        <li>Dolo, fraude ou tentativa de fraude, simulação ou culpa grave para obter ou majorar a
                            indenização;
                        </li>
                        <li>O segurado agravar intencionalmente o risco objeto do contrato, incluindo os casos de
                            dependência química de álcool, drogas ou medicamentos;
                        </li>
                        <li> Não fornecimento da documentação solicitada. <br>
                            Em qualquer das hipóteses acima não haverá restituição de prêmio, ficando a seguradora
                            isenta de quaisquer responsabilidades.
                        </li>
                    </ol>
                </li>
                <li><b>Sinistros</b>
                    <p>Ocorrendo sinistro, a <b>Central de Atendimento SKYPROTECTION (0800 7725 099)</b> deve ser <b>comunicada
                            direta e imediatamente</b> pelos beneficiários do seguro e se dentro do prazo de 15 dias,
                        não for
                        localizado seu veículo, os beneficiários deverão ligar para a <b>Central de Atendimento QBE
                            (0800
                            723 2886)</b> – <b>opção ”3” = “SINISTRO” </b>e depois <b>opção “2” = “DAR ENTRADA EM SEU
                            SINISTRO”</b> – para dar
                        entrada no seu SINISTRO, assim como deverão enviar os seguintes documentos necessários para a
                        análise dos eventos:</p>
                    <p><b>Para a abertura do sinistro enviar os seguintes documentos básicos:</b>
                    <ol type="a">
                        <li>Cópia simples do RG, CPF ou CNH do segurado reclamante;</li>
                        <li>Cópia simples do comprovante de residência (qualquer comprovante de residência atual em nome
                            do segurado reclamante, com prazo máximo de 90 dias. Na ausência deste, enviar declaração de
                            residência assinada);
                        </li>
                        <li> Comunicação do sinistro através do Formulário de Aviso de Sinistro (caso não seja fonado),
                            contendo os detalhes sobre a causa e consequências do evento;
                        </li>
                        <li>Autorização para crédito em conta (comprovante bancário);</li>
                        <li>Cópia simples do certificado do seguro.</li>
                    </ol>
                    </p>
                    <p><b>Além dos documentos básicos, o segurado deverá apresentar ainda de acordo com a cobertura de
                            roubo ou furto total:</b>
                    <ol type="a">
                        <li>Boletim de Ocorrência Policial original ou cópia autenticada, no qual devem ser
                            especificados detalhadamente, o local do sinistro, bem como sua respectiva descrição, data e
                            hora;
                        </li>
                        <li>Cópia do CRLV – Certificado de Registro e Licenciamento do Veículo;</li>
                        <li>IPVA – Imposto sobre a propriedade de veículos automotores, exercício atual e anteriores (no
                            mínimo os 02 últimos anos)
                        </li>
                        <li>Chaves do veículo (se possível);</li>
                        <li>Manual do Proprietário (se possível);</li>
                        <li>Nota Fiscal de Saída com destaque do ICMS (para pessoa jurídica) ou Carta de Isenção com
                            firma reconhecida;
                        </li>
                        <li>
                            Liberação alfandegária definitiva e 4ª via da Declaração de Importação (quando se tratar de
                            veículo importado);
                        </li>
                        <li>Cópia autenticada do Contrato Social e todas as alterações com seus respectivos registros na
                            Junta Comercial (para pessoa jurídica);
                        </li>
                        <li>Termo de Quitação e Responsabilidade por Multas;</li>
                        <li> Comprovante de instalação, no veículo segurado, do equipamento de segurança, bem como cópia
                            do pagamento da mensalidade, em dia;
                        </li>
                        <li>Veículos alienados: instrumento de liberação de alienação, com firma reconhecida e/ou baixa
                            do gravame;
                        </li>
                        <li>Certidão negativa de débito para veículos em nome de pessoa jurídica;</li>
                        <li>Certidão de não localização do veículo emitido por órgão policial;</li>
                        <li>Certificado de Propriedade do Veículo DUT (Documento Único de Transferência) com firma
                            reconhecida (original) e devidamente preenchido com os dados de seu proprietário e da
                            seguradora;
                        </li>
                    </ol>

                    </p>


                    <p>
                        <b>Além dos documentos básicos, o segurado deverá apresentar ainda de acordo com a cobertura de
                            Perda Total por Colisão:</b>
                    <ol type="a">
                        <li>Boletim de Ocorrência Policial original ou cópia autenticada, no qual devem ser
                            especificados detalhadamente, o local do sinistro, bem como sua respectiva descrição, data e
                            hora;
                        </li>
                        <li>Cópia do CRLV – Certificado de Registro e Licenciamento do Veículo;</li>
                        <li>IPVA – Imposto sobre a propriedade de veículos automotores, exercício atual e anteriores (no
                            mínimo os 02 últimos anos)
                        </li>
                        <li>Chaves do veículo (se possível);</li>
                        <li> Manual do Proprietário (se possível);</li>
                        <li>Nota Fiscal de Saída com destaque do ICMS (para pessoa jurídica) ou Carta de Isenção com
                            firma reconhecida;
                        </li>
                        <li>Liberação alfandegária definitiva e 4ª via da Declaração de Importação (quando se tratar de
                            veículo importado);
                        </li>
                        <li>Cópia autenticada do Contrato Social e todas as alterações com seus respectivos registros na
                            Junta Comercial (para pessoa jurídica);
                        </li>
                        <li>Termo de Quitação e Responsabilidade por Multas;</li>
                        <li>Comprovante de instalação, no veículo segurado, do equipamento de segurança, bem como cópia
                            do pagamento da mensalidade, em dia;
                        </li>
                        <li>Veículos alienados: instrumento de liberação de alienação, com firma reconhecida e/ou baixa
                            do gravame;
                        </li>
                        <li>Certidão negativa de débito para veículos em nome de pessoa jurídica;</li>
                        <li>Certificado de Propriedade do Veículo DUT (Documento Único de Transferência) com firma
                            reconhecida (original) e devidamente preenchido com os dados de seu proprietário e da
                            seguradora;
                        </li>
                    </ol>
                    </p>

                    <p>A documentação deverá ser enviada como CARTA REGISTRADA ou via SEDEX para QBE BRASIL SEGUROS,
                        Praça General Gentil Falcão, N.108 – 1º. And. Bairro Cidade Monções – São Paulo/SP – CEP
                        04571-150</p>

                    <p><b> A documentação citada acima é referencial, pois, durante a análise e regulação do sinistro,
                            outros documentos poderão ser solicitados para a elucidação e/ou comprovação do sinistro,
                            ficando, desde já, reservado à Seguradora o direito de exigi-los.</b>
                    </p>
                    <p>Caso haja solicitação de nova documentação o prazo para liquidação de sinistros sofrerá
                        suspensão, assim, a contagem do prazo voltará a correr a partir do dia útil subsequente àquele
                        em que forem completamente atendidas as exigências. <br>
                        Após a apresentação de toda a documentação necessária, por parte do Segurado, para a liquidação
                        do sinistro, a Seguradora efetuará o pagamento da indenização devida no prazo de até 30 (trinta)
                        dias.</p>
                </li>
                <li>
                    <b>Demais Condições</b>
                    <p>“SUSEP – Superintendência de Seguros Privados – Autarquia Federal responsável pela fiscalização,
                        normatização e controle dos mercados de seguro, previdência complementar aberta, capitalização,
                        resseguro e corretagem de seguros”. <br>
                        O segurado poderá consultar a situação cadastral do corretor de seguros, no site
                        <a href="">www.susep.gov.br</a>, por meio do número de seu registro na Susep, nome, CNPJ ou CPF.
                        O plano de
                        seguro também pode ser consultado no site da SUSEP <a href="">
                            http://www.susep.gov.br/menu/informacoes-ao-publico/planos-e-produtos/consulta-publica-de-produtos-1</a>.
                        A aceitação do seguro estará sujeita a análise de risco. O registro deste plano na Susep não
                        implica, por parte da Autarquia, incentivo ou recomendação a sua comercialização.</p>
                    <p><b>Este seguro é opcional, sendo possível a desistência do contrato em até 7(sete) dias corridos
                            da contratação com a devolução integral do valor pago, pelo mesmo meio exercido para a
                            contratação. <br>
                            É proibido condicionar desconto no preço de bem à aquisição do seguro vincular a aquisição
                            de bem à contratação compulsória de qualquer tipo de seguro ou ofertar bens em condições
                            mais vantajosas para quem contrata plano de seguro.</b></p>
                </li>
                <li><b>Foro</b>
                    <p>Fica eleito o foro de domicílio do cliente segurado para dirimir quaisquer dúvidas que decorram
                        da execução do presente resumo do seguro Auto.
                    </p></li>
            </ol>

        </div>

        <div class="contato">
            Aviso de Sinistro em Caso de Roubo e Furto: 0800 77 25099 | (11) 2770-1601<br>
            Central de Atendimento 0800 723 2886; <br>
            Central de Atendimento Exclusivo SUSEP 0800 021 8484;<br>
            SAC QBE 0800 774 4419;<br>
            Ouvidoria 0800 770 0824<br>
        </div>

        <table class="table-data">
            <tr>
                <td class="td-title-local">Local:</td>
                <td class="td-content-local"></td>
                <td class="td-title-data">Data Emissão:</td>
                <td class="td-content-data"></td>
            </tr>
        </table>

        <div class="assinatura-segurado">
            <div>Assinatura do Segurado</div>
        </div>

        <table class="table-assinatura">
            <tr>
                <td>
                    <table>
                        <tr class="title-ass">
                            <td>Estipulante:</td>
                        </tr>

                        <tr class="logo-ass">
                            <td><img src="{{ theme('images/logo-skyprotection.png') }}"></td>
                        </tr>
                        <tr class="info-ass">
                            <td>

                                SKYPROTECTION TECNOLOGIA DE INFORMAÇÃO VEICULAR
                                CNPJ 17.241.995/0001-85 <br>
                                Endereço: Rua Vieira de Morais, N.1495 <br>
                                Telefone: (11) 2770-1600 <br></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr class="title-ass">
                            <td>Garantia:</td>
                        </tr>

                        <tr class="logo-ass">
                            <td><img src="{{ theme('images/logo-qbe.png') }}"></td>
                        </tr>
                        <tr class="info-ass">
                            <td>
                                QBE Brasil Seguros S/A <br>
                                CNPJ: 96.348.677/0001-94 <br>
                                Registro SUSEP: 594-1 <br>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr class="title-ass">
                            <td>Administração:</td>
                        </tr>

                        <tr class="logo-ass">
                            <td><img src="{{ theme('images/logo-logica.png') }}"></td>
                        </tr>
                        <tr class="info-ass">
                            <td>
                                Lógica Corretora de Seguros Ltda <br>
                                CNPJ: 58795055/0001-15 <br>
                                Registro SUSEP: 100196452 <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <img src="{{ theme('images/assinatura-qbe.png') }}">
                    <div>
                        Raphael Swierczynski
                        CEO
                        QBE Brasil Seguros S.A.
                    </div>
                </td>
            </tr>
        </table>

        <p class="texto-final">
            “Em atendimento à Lei 12.741/12 informamos que incidem as alíquotas de 0,65% de PIS/Pasep e de 4% de COFINS
            sobre os prêmios de seguros/as contribuições a planos de caráter previdenciário/os pagamentos destinados a
            planos de capitalização, deduzidos do estabelecido em legislação específica.” “A FRAUDE CONTRA SEGUROS É
            CRIME DENUNCIE, (21) 2253-1177 OU 181 - <a href="">www.fenaseg.org.br</a>.”
        </p>

    </div>








@stop