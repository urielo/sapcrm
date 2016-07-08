<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests;
use App\Model\Segurado;
use App\Model\TipoVeiculos;
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

class CotacaoController extends Controller
{

    public function __construct(Cotacoes $cotacoes,Propostas $propostas ,OrgaoEmissors $orgaoemissors, EstadosCivis $estadoscivis, Segurado $segurados, Veiculos $veiculos, TipoVeiculos $tipos, Uf $ufs, TipoUtilizacaoVeic $tipoultiveics)
    {
        $this->tipos = $tipos;
        $this->segurado = $segurados;
        $this->veiculo = $veiculos;
        $this->ufs = $ufs;
        $this->tipoultiveics = $tipoultiveics;
        $this->estadoscivis = $estadoscivis;
        $this->orgaoemissors = $orgaoemissors;
        $this->propostas = $propostas;
        $this->cotacoes= $cotacoes;

        parent::__construct();
    }

    public function index()
    {

    }
    
    public function negociacoes()
    {
        $cotacoes = $this->cotacoes->whereIdcorretor(Auth::user()->corretor->idcorretor)->paginate(10);
        
        return view('backend.cotacao.negociacoes', compact('cotacoes'));
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



//        return view('backend.cotacao.sucesso', ['message' => 'Cotação realizada com sucesso!']);
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
        $corretor = ["corretor" => ["correCpfCnpj" => Auth::user()->corretor->corrcpfcnpj]];

        foreach ($request->produtos as $produto):
            $ids = json_decode($produto);
            $produtos["produto"][] = ["idProduto" => $ids->idproduto];
        endforeach;

        $cotacao = ["idParceiro" => 99,
            "nmParceiro" => "Seguro AUTOPRATICO",
            "indCondutorVeic" => $request->indproprietario,
            "indProprietVeic" => $request->indcondutor,
            "comissao" => $request->comissao,];

        $wscotacao = json_decode(webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado));

        if ($wscotacao->cdretorno != '000') {
            return response()->json([
                'sucesso' => false,
                'message' => $wscotacao,
            ]);

        }

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
        
        
        if ($wsproposta->cdretorno != '000') {
            return response()->json([
                'sucesso' => false,
                'message' => $wsproposta,
            ]);
        }else{
            Propostas::find($wsproposta->retorno->idproposta)->update(['dtvalidade'=>date('Y-m-d', strtotime('-45 day'))]);
            return response()->json([
                'sucesso' => true,
                'html' => (string)view('backend.cotacao.sucesso', [
                    'message' => 'Operação realizada com sucesso!',
                    'idproposta'=>$wsproposta->retorno->idproposta,
                    
                ]),
            ]);
        }
        
    }

    public function pdf($idproposta)
    {
        $curl = curl_init();

        $url['producao'] = "http://www.seguroautopratico.com.br/api/gerar/pdf";
        $url['debuga'] = "http://www.webservice.local/gerar/pdf";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url['producao'],
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
