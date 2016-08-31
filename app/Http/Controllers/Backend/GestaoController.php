<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;
use App\Http\Requests\CotacaoRequest;
use Illuminate\Support\Facades\Redirect;


use App\Model\Segurado;
use App\Model\TipoVeiculos;
use App\Model\Cobranca;
use App\Model\Veiculos;
use App\Model\Uf;
use App\Model\TipoUtilizacaoVeic;
use App\Model\EstadosCivis;
use App\Model\Cotacoes;
use App\Model\Propostas;
use App\Model\OrgaoEmissors;
use App\Model\ConfigSeguradora;
use App\Model\CotacoesSeguradora;
use App\Model\PropostasSeguradora;
use App\Model\ApolicesSeguradora;
use App\Model\FormaPagamento;
use App\Model\Cartoes;


class GestaoController extends Controller
{

    public function __construct(Cotacoes $cotacoes, Propostas $propostas, OrgaoEmissors $orgaoemissors, EstadosCivis $estadoscivis, Segurado $segurados, Veiculos $veiculos, TipoVeiculos $tipos, Uf $ufs, TipoUtilizacaoVeic $tipoultiveics)
    {
        $this->tipos = $tipos;
        $this->segurado = $segurados;
        $this->veiculo = $veiculos;
        $this->ufs = $ufs;
        $this->tipoultiveics = $tipoultiveics;
        $this->estadoscivis = $estadoscivis;
        $this->orgaoemissors = $orgaoemissors;
        $this->propostas = $propostas;
        $this->cotacoes = $cotacoes;

        parent::__construct();
    }

    public function index()
    {

    }

    public function apolices()
    {
        $cotacoes = $this->cotacoes->has('proposta')
            ->whereIdstatus(15)
            ->orderBy('idcotacao', 'desc')
            ->get();


        return view('backend.gestao.apolices', compact('cotacoes'));
    }

    public function emitir($idproposta)
    {
        $config = ConfigSeguradora::find(3);
        $proposta = Propostas::find($idproposta);
        $proposta->cotacao->veiculo->categoria = 10;


//        return $proposta->cotacao->veiculo;

        $SoapClient = new \SoapClient('http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl');


        if (!$proposta->cotacaoseguradora) {
            $response = Getcall($SoapClient, 'GerarCotacaoAutoConfiguravel', gerarXml('cotacao', $config, $proposta));

            $objresponse = simplexml_load_string($response);

            $cotacaoSeguradora = new \App\Model\CotacoesSeguradora;

            $cotacaoSeguradora->id_config_seguradora = $config->id;
            $cotacaoSeguradora->id_cotacao_seguradora = (int)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->nr_cotacao_i4pro;
            $cotacaoSeguradora->premio_tarifario_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_premio_tarifario;
            $cotacaoSeguradora->lmi_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_lmi;
            $cotacaoSeguradora->iof_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_iof;
            $cotacaoSeguradora->franquia_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_franquia;
            $cotacaoSeguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $cotacaoSeguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $cotacaoSeguradora->dt_criacao = date('Y-m-d H:i:s');
            $cotacaoSeguradora->xml_saida = htmlentities(gerarXml('cotacao', $config, $proposta));
            $cotacaoSeguradora->xml_retorno = htmlentities($response);


            $proposta->cotacaoseguradora()->save($cotacaoSeguradora);
            $proposta = Propostas::find($idproposta);
//            return $proposta->cotacaoseguradora;
//            CotacoesSeguradora::firstOrCreate($cotacaoSeguradora);
//            $proposta->id_cotacao_seguradora = (int)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->nr_cotacao_i4pro;

        } elseif ($proposta->cotacaoseguradora->cd_retorno_seguradora != 0) {

            $response = Getcall($SoapClient, 'GerarCotacaoAutoConfiguravel', gerarXml('cotacao', $config, $proposta));
            $objresponse = simplexml_load_string($response);

            $proposta->cotacaoseguradora->id_config_seguradora = $config->id;
            $proposta->cotacaoseguradora->id_cotacao_seguradora = (int)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->nr_cotacao_i4pro;
            $proposta->cotacaoseguradora->premio_tarifario_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_premio_tarifario;
            $proposta->cotacaoseguradora->lmi_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_lmi;
            $proposta->cotacaoseguradora->iof_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_iof;
            $proposta->cotacaoseguradora->franquia_seguradora = (float)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_franquia;
            $proposta->cotacaoseguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $proposta->cotacaoseguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $proposta->cotacaoseguradora->dt_update = date('Y-m-d H:i:s');
            $proposta->cotacaoseguradora->xml_saida = htmlentities(gerarXml('cotacao', $config, $proposta));
            $proposta->cotacaoseguradora->xml_retorno = htmlentities($response);

            $proposta->cotacaoseguradora->save();

            $proposta->cotacaoseguradora;

//            $proposta->id_cotacao_seguradora = (int)$objresponse->identificacao->gerar_cotacao_auto_configuravel->attributes()->nr_cotacao_i4pro;

//
        }


        if ($proposta->cotacaoseguradora && $proposta->cotacaoseguradora->cd_retorno_seguradora == 0 && !$proposta->propostaseguradora) {

            $response = Getcall($SoapClient, 'GerarPropostaAutoConfiguravel', gerarXml('proposta', $config, $proposta));
//            return htmlentities(gerarXml('proposta', $config, $proposta));

            $objresponse = simplexml_load_string($response);

            $propostaseguradora = new PropostasSeguradora;
            $propostaseguradora->id_config_seguradora = $config->id;
            $propostaseguradora->id_cotacao_seguradora = $proposta->cotacaoseguradora->id_cotacao_seguradora;
            $propostaseguradora->id_proposta_seguradora = (int)$objresponse->identificacao->gerar_proposta_auto_configuravel->attributes()->id_proposta;
            $propostaseguradora->id_endesso_seguradora = (int)$objresponse->identificacao->gerar_proposta_auto_configuravel->attributes()->id_endosso;
            $propostaseguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $propostaseguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $propostaseguradora->dt_criacao = date('Y-m-d H:i:s');
            $propostaseguradora->xml_saida = htmlentities(gerarXml('proposta', $config, $proposta));
            $propostaseguradora->xml_retorno = htmlentities($response);


            $proposta->propostaseguradora()->save($propostaseguradora);
            $proposta = Propostas::find($idproposta);


        } else if ($proposta->cotacaoseguradora->cd_retorno_seguradora == 0 && $proposta->propostaseguradora->cd_retorno_seguradora != 0) {
//            return htmlentities(gerarXml('proposta', $config, $proposta));

            $response = Getcall($SoapClient, 'GerarPropostaAutoConfiguravel', gerarXml('proposta', $config, $proposta));
            $objresponse = simplexml_load_string($response);

            $proposta->propostaseguradora->id_config_seguradora = $config->id;
            $proposta->propostaseguradora->id_cotacao_seguradora = $proposta->cotacaoseguradora->id_cotacao_seguradora;
            $proposta->propostaseguradora->id_proposta_seguradora = (int)$objresponse->identificacao->gerar_proposta_auto_configuravel->attributes()->id_proposta;
            $proposta->propostaseguradora->id_endesso_seguradora = (int)$objresponse->identificacao->gerar_proposta_auto_configuravel->attributes()->id_endosso;
            $proposta->propostaseguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $proposta->propostaseguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $proposta->propostaseguradora->dt_update = date('Y-m-d H:i:s');
            $proposta->propostaseguradora->xml_saida = htmlentities(gerarXml('proposta', $config, $proposta));
            $proposta->propostaseguradora->xml_retorno = htmlentities($response);
            $proposta->propostaseguradora->save();

            $proposta = Propostas::find($idproposta);

        }


        if ($proposta->propostaseguradora && $proposta->propostaseguradora->cd_retorno_seguradora == 0 && !$proposta->apoliceseguradora) {

            $response = Getcall($SoapClient, 'EfetivarVendaAutoConfiguravel', gerarXml('venda', $config, $proposta));
            $objresponse = simplexml_load_string($response);
//            echo $proposta->cotacaoseguradora->xml_saida;
//            echo $proposta->propostaseguradora->xml_saida;
//            return htmlentities(gerarXml('venda', $config, $proposta));

            $apoliceseguradora = New ApolicesSeguradora;
            $apoliceseguradora->id_proposta_sap = $idproposta;
            $apoliceseguradora->id_config_seguradora = $config->id;
            $apoliceseguradora->id_cotacao_seguradora = $proposta->cotacaoseguradora->id_cotacao_seguradora;
            $apoliceseguradora->id_apolice_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->id_apolice;
            $apoliceseguradora->cd_apolice_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->cd_apolice;
            $apoliceseguradora->id_proposta_seguradora = $proposta->propostaseguradora->id_proposta_seguradora;
            $apoliceseguradora->id_endosso_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->id_endosso;
            $apoliceseguradora->dt_instalacao_rastreador = date('Ymd');
            $apoliceseguradora->dt_ativa_rastreador = date('Ymd');
            $apoliceseguradora->dt_inicio_comodato = date('Ymd');
            $apoliceseguradora->dt_fim_comodato = date('Ymd', strtotime('+1 year'));
            $apoliceseguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $apoliceseguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $apoliceseguradora->dt_criacao = date('Y-m-d H:i:s');
            $apoliceseguradora->xml_saida = htmlentities(gerarXml('venda', $config, $proposta));
            $apoliceseguradora->xml_retorno = htmlentities($response);
            $apoliceseguradora->save();


        } elseif ($proposta->propostaseguradora && $proposta->propostaseguradora->cd_retorno_seguradora == 0 && $proposta->apoliceseguradora->cd_retorno_seguradora != 0) {
            $response = Getcall($SoapClient, 'EfetivarVendaAutoConfiguravel', gerarXml('venda', $config, $proposta));
            $objresponse = simplexml_load_string($response);

            $proposta->apoliceseguradora->id_config_seguradora = $config->id;
            $proposta->apoliceseguradora->id_cotacao_seguradora = $proposta->cotacaoseguradora->id_cotacao_seguradora;
            $proposta->apoliceseguradora->id_apolice_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->id_apolice;
            $proposta->apoliceseguradora->cd_apolice_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->cd_apolice;
            $proposta->apoliceseguradora->id_proposta_seguradora = $proposta->propostaseguradora->id_proposta_seguradora;
            $proposta->apoliceseguradora->id_endosso_seguradora = (int)$objresponse->identificacao->efetivar_venda_auto_configuravel->attributes()->id_endosso;
            $proposta->apoliceseguradora->dt_instalacao_rastreador = date('Y-m-d H:i:s');
            $proposta->apoliceseguradora->dt_ativa_rastreador = date('Y-m-d H:i:s');
            $proposta->apoliceseguradora->dt_inicio_comodato = date('Y-m-d H:i:s');
            $proposta->apoliceseguradora->dt_fim_comodato = date('Y-m-d H:i:s');
            $proposta->apoliceseguradora->cd_retorno_seguradora = (int)$objresponse->retorno->attributes()->cd_retorno;
            $proposta->apoliceseguradora->nm_retorno_seguradora = $objresponse->retorno->attributes()->nm_retorno;
            $proposta->apoliceseguradora->dt_update = date('Y-m-d H:i:s');
            $proposta->apoliceseguradora->xml_saida = gerarXml('venda', $config, $proposta);
            $proposta->apoliceseguradora->xml_retorno = htmlentities($response);
            $proposta->apoliceseguradora->save();


        }


        return back();

    }

    /**
     * @return Cotacoes
     */
    public function apolicepdf($idproposta)
    {
        $proposta = Propostas::find($idproposta);

        $proposta->cotacao->veiculo->veicplaca;


        $id_endosso = $proposta->apoliceseguradora->id_endosso_seguradora;
        $tipo = 793;

        $client = new \SoapClient('http://usebens.com.br/i4pro/webservice/i4prowebservice.asmx?wsdl');//http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl

        $function = 'Executar';

        $arguments = array('Executar' => array(
            'Servico' => 'RelatórioPDF',
            'conteudoXML' => "<i4proerp><obter_relatorio_pdf id_relatorio  ='$tipo' cd_empresa  ='80' id_endosso  ='$id_endosso'> </obter_relatorio_pdf></i4proerp>"

        ));
        #$options = array('location' => 'http://usebens.com.br/i4pro/webservice/i4prowebservice.asmx');//http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx
        $options = array('location' => 'http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx');//http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx
        $result = $client->__soapCall($function, $arguments, $options);
        $str_pdf_base64 = $result->ExecutarResult;
        $tempfile = 'apolice-' . $proposta->cotacao->veiculo->veicplaca . '.pdf';


        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . $tempfile . "\";");
        echo base64_decode($result->ExecutarResult);

    }

    /**
     * @return Cotacoes
     */

    public function cobranca()
    {
        $propostas = $this->propostas
            ->whereIdstatus(10)
            ->orderBy('idproposta', 'asc')
            ->get();


        return view('backend.gestao.cobranca', compact('propostas'));
    }

    public function aprovacao()
    {
        $propostas = Cobranca::distinct()->select('idproposta')
            ->whereIdstatus(14)
            ->orderBy('idproposta', 'asc')
            ->get();


        return view('backend.gestao.aprovacao', compact('propostas'));
    }

    /**
     * @return Cotacoes
     */
    public function cancelar(Request $request)
    {
        $proposta = Propostas::find($request->idproposta);
        $proposta->idmotivo = $request->motivo;
        $proposta->idstatus = $request->status;
        $proposta->save();
        $proposta->cotacao->idstatus = $request->status;
        $proposta->cotacao->save();

        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!!');
    }


    public function salvarpagamento(Request $request)
    {

        $numero = str_replace(' ', '', $request->nnmcartao);
        $proposta = Propostas::find($request->idproposta);


        if ($proposta->idformapg == 1) {

            $cartao = Cartoes::where('numero', $numero)
                ->where('cvv', $request->cvvcartao)
                ->where('validade', getDateFormat($request->valcartao, 'valcartao'))
                ->first();

            $dados = [
                'vlcartao' => $proposta->premiototal,
                'idstatus' => 14,
                'parcelas' => $proposta->quantparc
            ];


            if ($cartao) {
                $dados['idcartao'] = $cartao->id;
            } else {
                $cartao = new Cartoes([
                    'nome' => strtoupper($request->nomecartao),
                    'bandeira' => $request->bandeiracartao,
                    'numero' => $numero,
                    'validade' => getDateFormat($request->valcartao, 'valcartao'),
                    'cvv' => $request->cvvcartao,
                ]);

                $cartao->save();

                $dados['idcartao'] = $cartao->id;
            }


        } else {

            $dados = [
                'dtvencimento' => getDateFormat($request->dataprimeira, 'nascimento'),
                'idstatus' => 14,
                'diasdemais' => $request->datademais,
            ];


        }

        $cobranca = new Cobranca($dados);

        $proposta->cobranca()->save($cobranca);


        $proposta->idstatus = 14;
        $proposta->save();

        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!!');
    }

    public function recusapagamento($idproposta)
    {

        $proposta = Propostas::find($idproposta);

        foreach ($proposta->cobranca as $cobranca) {

            if ($cobranca->idstatus == 14) {

                $cobranca->idstatus = 20;
                $cobranca->save();
            }
        }


        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!!');
    }

    public function confirmapagamento(Request $request)
    {

        $proposta = Propostas::find($request->idproposta);

        foreach ($proposta->cobranca as $cobranca):
            if ($cobranca->idstatus == 14) {

                if ($proposta->idformapg == 1) {
                    $cobranca->numpagamento = $request->cvrecibocartao;

                } else {
                    $cobranca->numpagamento = $request->numboleto;
                    $cobranca->operadora = $request->numboleto;
                }

                $cobranca->dtpagamento = getDateFormat($request->datapgto,'nascimento');
                $cobranca->idstatus = 15;
                $cobranca->save();
            }

        endforeach;

        $proposta->idstatus = 15;
        $proposta->cotacao->idstatus = 15;
        $proposta->cotacao->save();
        $proposta->save();

        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!!');
    }


}
