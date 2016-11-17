<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests;
use App\Model\Segurado;
use App\Model\Config;
use App\Model\TipoVeiculos;
use App\Model\FipeAnoValor;
use App\Model\Veiculos;
use App\Model\Uf;
use App\Model\TipoUtilizacaoVeic;
use App\Model\EstadosCivis;
use App\Model\Cotacoes;
use App\Model\Propostas;
use App\Model\OrgaoEmissors;
use App\Model\FormaPagamento;
use App\Http\Requests\CotacaoRequest;
use Illuminate\Support\Facades\Redirect;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use phpDocumentor\Reflection\Types\Null_;

class CotacaoController extends Controller
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

    public function index(TipoUtilizacaoVeic $tipoutilizacao, TipoVeiculos $tipos, FormaPagamento $formas)
    {

        return view('backend.cotacao.cotar', compact('tipos', 'tipoutilizacao', 'formas'));

    }

    public function negociacoes()
    {
        $cotacoes = $this->cotacoes->has('proposta')
            ->whereIdcorretor(Auth::user()->corretor->idcorretor)
            ->orderBy('idcotacao', 'desc')
            ->paginate(10);


        return view('backend.cotacao.negociacoes', compact('cotacoes'));
    }

    public function negociar($idcotacao, FormaPagamento $formapagamentos)
    {
        $veiculos = $this->veiculo;
        $segurados = $this->segurado;
        $tipos = $this->tipos;
        $ufs = $this->ufs;
        $tipoultiveics = $this->tipoultiveics;
        $estadoscivis = $this->estadoscivis;
        $orgaoemissors = $this->orgaoemissors;

        $cotacao = Cotacoes::find($idcotacao);
        $anovalor = FipeAnoValor::class;


        return view('backend.cotacao.formnegociar', compact('anovalor', 'cotacao', 'segurados', 'orgaoemissors', 'veiculos', 'tipos', 'ufs', 'tipoultiveics', 'estadoscivis', 'formapagamentos'));

    }

    public function cotar(FormaPagamento $formapagamentos)
    {
        $veiculos = $this->veiculo;
        $segurados = $this->segurado;
        $tipos = $this->tipos;
        $ufs = $this->ufs;
        $tipoultiveics = $this->tipoultiveics;
        $estadoscivis = $this->estadoscivis;
        $orgaoemissors = $this->orgaoemissors;


        return view('backend.cotacao.form', compact('segurados', 'orgaoemissors', 'veiculos', 'tipos', 'ufs', 'tipoultiveics', 'estadoscivis', 'formapagamentos'));
    }

    public function gerar(CotacaoRequest $request)
    {


        $configws = Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first();
        $url = $configws->url;
//        return view('backend.cotacao.sucesso', ['message' => 'Cotação realizada com sucesso!']);
        $segurado = ["segurado" =>
            ["segNomeRazao" => ($request->tipopessoa == 1 ? $request->segnome : $request->segrazao),
                "segCpfCnpj" => ($request->tipopessoa == 1 ? getDataReady($request->segcpf) : getDataReady($request->segcnpj)),
                "segDtNasci" => ($request->tipopessoa == 1 ? getDateFormat($request->segdatanasc, 'nascimento') : getDateFormat($request->segdatafund, 'nascimento')),
                "segCdSexo" => ($request->tipopessoa == 1 ? $request->segsexo : NULL),
                "segCdEstCivl" => ($request->tipopessoa == 1 ? $request->segestadocivil : 0),
                "segProfRamoAtivi" => ($request->tipopessoa == 1 ? (int)$request->segcdprofissao : (int)$request->segcdramoatividade),
                "segEmail" => $request->segemail,
                "segCelDdd" => getDataReady($request->segdddcel),
                "segCelNum" => getDataReady($request->segnmcel),
                "segFoneDdd" => getDataReady($request->segdddfone),
                "segFoneNum" => getDataReady($request->segnmfone),
                "segEnd" => $request->segendlog,
                "segEndNum" => $request->segnmend,
                "segEndCompl" => $request->segendcompl,
                "segEndCep" => getDataReady($request->segcep),
                "segEndCidade" => $request->segendcidade,
                "segEndCdUf" => $request->segenduf,
                "segNumRg" => ($request->tipopessoa == 1 ? $request->segrg : NULL),
                "segDtEmissaoRg" => ($request->tipopessoa == 1 ? getDateFormat($request->segrgdtemissao, 'nascimento') : Null),
                "segEmissorRg" => ($request->tipopessoa == 1 ? $request->segrgoe : NULL),
                "segBairro" => $request->segendbairro,
                "segCdUfRg" => ($request->tipopessoa == 1 ? $request->segrguf : NULL),]
        ];
        $perfilsegurado = ["perfilSegurado" =>
            ["cepPernoite" => null,
                "garagemPernoite" => NULL,
                "cepTrabalho" => NULL,
                "garagemTrabalho" => Null,
                "seguradoEstuda" => null,
                "garagemEscola" => NULL,
                "outrosMotoristasApolice" => NULL,
                "motoristaJovem" => NULL,
                "seguradoAcidenteUltAno" => NULL,
                "seguradoRoubadoUltAno" => NULL,
                "renovaApolice" => NULL,
                "renovaSeguradora" => NULL,
                "bonusApoliceUltAno" => NULL,
                "kmPorDia" => NULL,
                "outrosCarros" => NULL,]
        ];
        $condutor = ["condutor" =>
            ["condutNomeRazao" => $request->condnome,
                "condutCpfCnpj" => getDataReady($request->condcpf),
                "condutDtNasci" => getDateFormat($request->conddatanasc, 'nascimento'),
                "condutCdSexo" => $request->condsexo,
                "condutCdEstCivl" => $request->condestadocivil,
                "condutProfRamoAtivi" => $request->condcdprofissao,]
        ];
        $proprietario = ["proprietario" =>
            ["proprNomeRazao" => ($request->proptipopessoa == 1 ? $request->propnome : $request->proprazao),
                "proprCpfCnpj" => ($request->proptipopessoa == 1 ? getDataReady($request->propcpf) : getDataReady($request->propcnpj)),
                "proprDtNasci" => ($request->proptipopessoa == 1 ? getDateFormat($request->propdatanasc, 'nascimento') : getDateFormat($request->propdatafund, 'nascimento')),
                "proprCdSexo" => ($request->proptipopessoa == 1 ? $request->propsexo : NULL),
                "proprCdEstCivl" => ($request->proptipopessoa == 1 ? $request->propestadocivil : 0),
                "proprPrfoRamoAtivi" => ($request->proptipopessoa == 1 ? (int)$request->propcdprofissao : (int)$request->propcdramoatividade),
                "proprCdRelDepSegurado" => 11,
                "proprdescRelDepSegurado" => "Primo",
                "proprEmail" => $request->propemail,
                "proprCelDdd" => getDataReady($request->propdddcel),
                "proprCelNum" => getDataReady($request->propnmcel),
                "proprFoneDdd" => getDataReady($request->propdddfone),
                "proprFoneNum" => getDataReady($request->propnmfone),
                "proprEnd" => $request->propendlog,
                "proprEndNum" => $request->propnmend,
                "proprEndCompl" => $request->propendcompl,
                "proprEndCep" => getDataReady($request->propcep),
                "proprEndCidade" => $request->propendcidade,
                "proprEndCdUf" => $request->propenduf,]
        ];
        $anoveic = json_decode($request->anom);
        $veiculo = ["veiculo" =>
            ["veiCodFipe" => $request->codefipe,
                "veiAno" => $anoveic->ano,
                "veiAnoFab" => $request->anof,
                "veiCor" => $request->veiccor,
                "veiIndZero" => $request->indautozero,
                "veiCdUtiliz" => $request->veicultilizacao,
                "veiCdTipo" => $request->tipoveiculo,
                "veiCdCombust" => $anoveic->combus,
                "veiPlaca" => getDataReady($request->placa),
                "veiMunPlaca" => $request->munplaca,
                "veiCdUfPlaca" => $request->placauf,
                "veiRenav" => $request->renavan,
                "veiAnoRenav" => $request->anorenav,
                "veiChassi" => $request->chassi,
                "veiIndChassiRema" => $request->indcahssiremarc,
                "veiIndLeilao" => $request->indleilao,
                "veiIndAcidentado" => $request->indacidentado,
                "veiIndAlienado" => $request->indaliendado,]
        ];
        $corretor = ["corretor" => ["correSusep" => Auth::user()->corretor->corresusep,
            "correNomeRazao" => Auth::user()->corretor->corrnomerazao,
            "correCpfCnpj" => Auth::user()->corretor->corrcpfcnpj,
            "correDtNasci" => Auth::user()->corretor->corrdtnasc,
            "correCdSexo" => Auth::user()->corretor->corrcdsexo,
            "correCdEstCivl" => Auth::user()->corretor->corrcdestadocivil,
            "correProfRamoAtivi" => Auth::user()->corretor->corrcdprofiramoatividade,
            "correEmail" => Auth::user()->corretor->corremail,
            "correCelDdd" => Auth::user()->corretor->corrdddcel,
            "correCelNum" => Auth::user()->corretor->corrnmcel,
            "correFoneDdd" => Auth::user()->corretor->corrdddfone,
            "correFoneNum" => Auth::user()->corretor->corrnmfone,
            "correEnd" => Auth::user()->corretor->corrnmend,
            "correEndNum" => Auth::user()->corretor->corrnumero,
            "correEndCep" => Auth::user()->corretor->corrcep,
            "correEndCompl" => Auth::user()->corretor->correndcomplet,
            "correEndCidade" => Auth::user()->corretor->corrnmcidade,
            "correEndCdUf" => Auth::user()->corretor->corrcduf],
        ];

        foreach ($request->produtos as $produto):
            $ids = json_decode($produto);
            $produtos["produto"][] = ["idProduto" => $ids->idproduto, 'valorLmiProduto' => $ids->vllmi];
        endforeach;


        $cotacao = ["idParceiro" => 99,
            "nmParceiro" => "Seguro AUTOPRATICO",
            "indCondutorVeic" => $request->indproprietario,
            "indProprietVeic" => $request->indcondutor,
            "comissao" => (isset($request->comissao) ? $request->comissao : Auth::user()->corretor->corrcomissaopadrao),];

//        return json_encode(array_merge($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado));
//
//     return webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado);

        $wscotacao = json_decode(webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado, $url));

        if ($wscotacao->cdretorno != '000') {
            return response()->json([
                'sucesso' => false,
                'message' => $wscotacao,
                'tipo' => 'Cotacao'
            ]);

        }

        $formapg = json_decode($request->formapagamento);

        if ($formapg->idforma == 1) {
            $proposta = [
                "idParceiro" => 99,
                "nmParceiro" => "seguro auto pratico",
                "cdCotacao" => $wscotacao->retorno->cdCotacao,
                "cdFormaPgt" => $formapg->idforma,
                "qtParcela" => $request->quantparcela,
                "nmBandeira" => $request->cartaobandeira,
                "numCartao" => getDataReady($request->cartaonumero),
                "validadeCartao" => getDateFormat($request->cartaovalidade, 'valcartao'),
                "titularCartao" => $request->cartaonome,
                "indCondutorVeic" => $request->indproprietario,
                "indProprietVeic" => $request->indcondutor,
            ];
        } else {

            $proposta = [
                "idParceiro" => 99,
                "nmParceiro" => "seguro auto pratico",
                "cdCotacao" => $wscotacao->retorno->cdCotacao,
                "cdFormaPgt" => $formapg->idforma,
                "qtParcela" => $request->quantparcela,
                "indCondutorVeic" => $request->indproprietario,
                "indProprietVeic" => $request->indcondutor,
            ];
        }

        $wsproposta = json_decode(webserviceProposta($proposta, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado, $url));


        if ($wsproposta->cdretorno != '000') {
            return response()->json([
                'sucesso' => false,
                'message' => $wsproposta,
                'tipo' => 'Proposta'
            ]);
        } else {
            Cotacoes::where('idcotacao', $wscotacao->retorno->cdCotacao)->update(['usuario_id' => Auth::user()->id]);
            Propostas::where('idproposta', $wsproposta->retorno->idproposta)->update(['dtvalidade' => date('Y-m-d', strtotime('+30 day')), 'usuario_id' => Auth::user()->id]);
            return response()->json([
                'sucesso' => true,
                'html' => (string)view('backend.cotacao.sucesso', [
                    'message' => 'Operação realizada com sucesso!',
                    'idproposta' => $wsproposta->retorno->idproposta,

                ]),
            ]);
        }

    }

    public function pdf($idproposta)
    {
        $curl = curl_init();
        $configws = Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first();
        $url = $configws->url;


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . 'pdf',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"idParceiro\": 99,\n    \"nmParceiro\": \"Seguro AutoPratico\",\n    \"idProposta\": {$idproposta}\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: baa0f845-adf2-40ef-3a66-806648b4b7fd",
                "x-api-key: 000666"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $pdf = json_decode($response, true);

            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=\"proposta_N{$idproposta}.pdf\";");
            echo base64_decode($pdf['base64']);
        }
    }

    public function sendEmail()
    {
//        Mail::

    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function pdf_cotacao($cotacao_id)
    {

        $cotacao = Cotacoes::find(base64_decode($cotacao_id));
        $formas = [];

        if ($cotacao) {
            $menor_parcela = 0;
            foreach ($cotacao->produtos as $produto) {
                $menor_parcela = $menor_parcela + $produto->produto->precoproduto()->where('idprecoproduto', $produto->idprecoproduto)->first()->vlrminprimparc;
            }

            foreach (FormaPagamento::All() as $forma) {
                $parcelas = new \stdClass();
                $parcelas->parcelas = geraParcelas($cotacao->premio, $forma->nummaxparc, $forma->numparcsemjuros, $forma->taxamesjuros, $menor_parcela, $forma->idformapgto);
                $parcelas->forma_pagamento = $forma->descformapgto;
                $formas[] = $parcelas;
            }


//        return view('backend.pdf.cotacao',compact('cotacao', 'formas'));


            error_reporting(E_ERROR);
            $pdf = Pdf::loadView('backend.pdf.cotacao', compact('cotacao', 'formas'));
            $pdf->SetProtection(['print'], '', '456');
            return $pdf->stream();
        } else {
            return Redirect::back()->with('error', 'Cotação Invalida!');
        }


    }

    public function sucesso($idcotacao)
    {
        $cotacao = Cotacoes::find($idcotacao);

        return view('backend.cotacao.sucesso', compact('cotacao'));


    }

    public function salvar(Request $request)
    {
        $url = Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first()->url;


        $anoveic = json_decode($request->anomodelo);
        $cotacao = [
            "corretor" => ["correSusep" => Auth::user()->corretor->corresusep,
                "correNomeRazao" => Auth::user()->corretor->corrnomerazao,
                "correCpfCnpj" => Auth::user()->corretor->corrcpfcnpj,
                "correDtNasci" => Auth::user()->corretor->corrdtnasc,
                "correCdSexo" => Auth::user()->corretor->corrcdsexo,
                "correCdEstCivl" => Auth::user()->corretor->corrcdestadocivil,
                "correProfRamoAtivi" => Auth::user()->corretor->corrcdprofiramoatividade,
                "correEmail" => Auth::user()->corretor->corremail,
                "correCelDdd" => Auth::user()->corretor->corrdddcel,
                "correCelNum" => Auth::user()->corretor->corrnmcel,
                "correFoneDdd" => Auth::user()->corretor->corrdddfone,
                "correFoneNum" => Auth::user()->corretor->corrnmfone,
                "correEnd" => Auth::user()->corretor->corrnmend,
                "correEndNum" => Auth::user()->corretor->corrnumero,
                "correEndCep" => Auth::user()->corretor->corrcep,
                "correEndCompl" => Auth::user()->corretor->correndcomplet,
                "correEndCidade" => Auth::user()->corretor->corrnmcidade,
                "correEndCdUf" => Auth::user()->corretor->corrcduf],
            "segurado" => ["segCpfCnpj" => $request->cpfcnpj],
            "veiculo" => ["veiCodFipe" => $request->codefipe,
                "veiAno" => $anoveic->ano,
                "veiIndZero" => $request->indautozero,
                "veiCdTipo" => $request->tipoveiculo,
                "veiCdCombust" => $anoveic->combus,
            ],
            "idParceiro" => 99,
            "nmParceiro" => "Seguro AUTOPRATICO",
            "comissao" => (isset($request->comissao) ? $request->comissao : Auth::user()->corretor->corrcomissaopadrao)
        ];
        $produtos = [];
        foreach ($request->produtos as $produto):
            $produtos["produto"][] = ["idProduto" => $produto, 'valorLmiProduto' => null];
        endforeach;

        $cotacao = webserviceCotacao(array_merge($cotacao, $produtos), $url);


        if ($cotacao->cdretorno == 000) {
            Cotacoes::where('idcotacao', $cotacao->retorno->cdCotacao)->update(['usuario_id' => Auth::user()->id]);
            echo $cotacao->status . 'Codigo da cotacao:' . $cotacao->retorno->cdCotacao . ' ' . Auth::user()->id;

            switch ($request->tipoenvio) {
                case 'proposta':
                    return 'tela.proposta';
                    break;
                case 'salvar':
                    return Redirect::route('cotacao.sucesso', $cotacao->retorno->cdCotacao);
                    break;
                default :
                    return Redirect::route('cotacao.cotar');
            }
        } else {

            echo '<pre>';
            print_r($cotacao);
            echo '</pre>';
//           return Redirect::back()->with('error', 'Error ao gerar cotacao '. $cotacao->cdretorno);
        }


    }
}
