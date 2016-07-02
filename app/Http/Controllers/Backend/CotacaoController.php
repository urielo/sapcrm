<?php

namespace App\Http\Controllers\Backend;

use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Segurado;
use App\Model\TipoVeiculos;
use App\Model\Veiculos;
use App\Model\Uf;
use App\Model\TipoUtilizacaoVeic;
use App\Model\EstadosCivis;
use App\Model\Cotacoes;
use App\Model\OrgaoEmissors;
use App\Model\FormaPagamento;

class CotacaoController extends Controller
{

    public function __construct(OrgaoEmissors $orgaoemissors, EstadosCivis $estadoscivis, Segurado $segurados, Veiculos $veiculos, TipoVeiculos $tipos, Uf $ufs, TipoUtilizacaoVeic $tipoultiveics)
    {
        $this->tipos = $tipos;
        $this->segurado = $segurados;
        $this->veiculo = $veiculos;
        $this->ufs = $ufs;
        $this->tipoultiveics = $tipoultiveics;
        $this->estadoscivis = $estadoscivis;
        $this->orgaoemissors = $orgaoemissors;

        parent::__construct();
    }

    public function index()
    {

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

    public function gerar(Request $request)
    {

        $request->all();
        $segurado = ["segurado" =>
            ["segNomeRazao" => ($request->tipopessoa == 1 ? $request->segnome : $request->segrazao),
                "segCpfCnpj" => ($request->tipopessoa == 1 ? $request->segcpf : $request->segcnpj),
                "segDtNasci" => ($request->tipopessoa == 1 ? date('Ymd', strtotime($request->segdatanasc)) : date('Ymd', strtotime($request->segdatafund))),
                "segCdSexo" => ($request->tipopessoa == 1 ? $request->segsexo : NULL),
                "segCdEstCivl" => ($request->tipopessoa == 1 ? $request->segestadocivil : 0),
                "segProfRamoAtivi" => ($request->tipopessoa == 1 ? (int)$request->segcdprofissao : (int)$request->segcdramoatividade),
                "segEmail" => $request->segemail,
                "segCelDdd" => $request->segdddcel,
                "segCelNum" => $request->segnmcel,
                "segFoneDdd" => $request->segdddfone,
                "segFoneNum" => $request->segnmfone,
                "segEnd" => $request->segendlog,
                "segEndNum" => $request->segnmend,
                "segEndCompl" => $request->segendcompl,
                "segEndCep" => $request->segcep,
                "segEndCidade" => $request->segendcidade,
                "segEndCdUf" => $request->segenduf,
                "segNumRg" => ($request->tipopessoa == 1 ? $request->segrg : NULL),
                "segUfEmissaoRg" => ($request->tipopessoa == 1 ? date('Ymd', strtotime((string)$request->segrgdtemissao)) : NULL),
                "segEmissorRg" => ($request->tipopessoa == 1 ? $request->segrgoe : NULL),
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
                "condutCpfCnpj" => $request->condcpf,
                "condutDtNasci" => date('Ymd', strtotime($request->conddatanasc)),
                "condutCdSexo" => $request->condsexo,
                "condutCdEstCivl" => $request->condestadocivil,
                "condutProfRamoAtivi" => $request->condcdprofissao,]
        ];

        $proprietario = ["proprietario" =>
            ["proprNomeRazao" => ($request->proptipopessoa == 1 ? $request->propnome : $request->proprazao),
                "proprCpfCnpj" => ($request->proptipopessoa == 1 ? $request->propcpf : $request->propcnpj),
                "proprDtNasci" => ($request->proptipopessoa == 1 ? date('Ymd', strtotime($request->propdatanasc)) : date('Ymd', strtotime($request->propdatafund))),
                "proprCdSexo" => ($request->proptipopessoa == 1 ? $request->propsexo : NULL),
                "proprCdEstCivl" => ($request->proptipopessoa == 1 ? $request->propestadocivil : 0),
                "proprPrfoRamoAtivi" => ($request->proptipopessoa == 1 ? (int)$request->propcdprofissao : (int)$request->propcdramoatividade),
                "proprCdRelDepSegurado" => 11,
                "proprdescRelDepSegurado" => "Primo",
                "proprEmail" => $request->propemail,
                "proprCelDdd" => $request->propdddcel,
                "proprCelNum" => $request->propnmcel,
                "proprFoneDdd" => $request->propdddfone,
                "proprFoneNum" => $request->propnmfone,
                "proprEnd" => $request->propendlog,
                "proprEndNum" => $request->propnmend,
                "proprEndCompl" => $request->propendcompl,
                "proprEndCep" => $request->propcep,
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
                "veiPlaca" => $request->placa,
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


        foreach ($request->produtos as $produto):
            $ids = json_decode($produto);
            $produtos["produto"][] = ["idProduto" => $ids->idproduto];
        endforeach;

        $corretor = ["corretor" => ["correCpfCnpj" => Auth::user()->corretor->corrcpfcnpj]];

        $cotacao = ["idParceiro" => 99,
            "nmParceiro" => "Seguro AUTOPRATICO",
            "indCondutorVeic" => $request->indproprietario,
            "indProprietVeic" => $request->indcondutor,
            "comissao" => $request->comissao,];


        $wscotacao = json_decode(webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado));
        $formapg = json_decode($request->formapagamento);
        $proposta = [
            "idParceiro" => 99,
            "nmParceiro" => "seguro auto pratico",
            "cdCotacao" => $wscotacao->retorno->cdCotacao,
            "cdFormaPgt" => $formapg->idforma,
            "qtParcela" => $request->quantparcela,
            "nmBandeira" => $request->cartaobandeira,
            "numCartao" => $request->cartaonumero,
            "validadeCartao" => $request->cartaovalidade,
            "indCondutorVeic" => $request->indproprietario,
            "indProprietVeic" => $request->indcondutor,
        ];

        $wsproposta = json_decode(webserviceProposta($proposta, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado));
        echo '<pre>';
        print_r($wsproposta);
        echo '</pre>';
    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
