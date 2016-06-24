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
                "segProfRamoAtivi" => ($request->tipopessoa == 1 ? (int) $request->segcdprofissao : (int) $request->segcdramoatividade),
                "segEmail" => $request->segemail,
                "segCelDdd" => $request->segdddcel,
                "segCelNum" => $request->segnmcel,
                "segFoneDdd" => $request->segdddfone,
                "segFoneNum" => $request->segnmfone,
                "segEnd" => "rua das quintas",
                "segEndNum" => $request->segnmend,
                "segEndCompl" => $request->segendcompl,
                "segEndCep" => $request->segcep,
                "segEndCidade" => "sao paulo",
                "segEndCdUf" => 1,
                "segNumRg" => ($request->tipopessoa == 1 ? $request->segrg : NULL),
                "segUfEmissaoRg" => ($request->tipopessoa == 1 ? date('Ymd', strtotime((string) $request->segrgdtemissao)) : NULL),
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
            ["condutNomeRazao" => "BOTANA888",
                "condutCpfCnpj" => "88845678901",
                "condutDtNasci" => 19950629,
                "condutCdSexo" => 2,
                "condutCdEstCivl" => 1,
                "condutProfRamoAtivi" => 2,]
        ];

        $proprietario = ["proprietario" =>
            ["proprNomeRazao" => "JONNY777",
                "proprCpfCnpj" => "77745678901",
                "proprDtNasci" => 19940719,
                "proprCdSexo" => 1,
                "proprCdEstCivl" => 1,
                "proprPrfoRamoAtivi" => 2,
                "proprCdRelDepSegurado" => 11,
                "proprdescRelDepSegurado" => "Primo",
                "proprEmail" => "pedro@gmail.com",
                "proprCelDdd" => 12,
                "proprCelNum" => 123456789,
                "proprFoneDdd" => 81,
                "proprFoneNum" => 12345678,
                "proprEnd" => "rua das oliveiras",
                "proprEndNum" => 25,
                "proprEndCompl" => "proximo ao atacadao",
                "proprEndCep" => 12345678,
                "proprEndCidade" => "sao paulo",
                "proprEndCdUf" => 1,]
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
        echo '<pre>';
        
        foreach ($request->produtos as $produto):
            $ids = json_decode($produto);
            $produtos["produto"][] = ["idProduto" => $ids->idproduto];
        endforeach;

        $corretor = ["corretor" => ["correCpfCnpj" => Auth::user()->corretor->corrcpfcnpj]];

        $cotacao = ["idParceiro" => 99,
            "nmParceiro" => "Seguro AUTOPRATICO",
            "indCondutorVeic" => 0,
            "indProprietVeic" => 0,
            "comissao" => 10,];

        $wscotacao = webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado);
        echo '<pre>';
        print_r($wscotacao);
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
