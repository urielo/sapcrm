<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
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

    public function cotacoes()
    {
        $title = 'Ativas';
        $crypt = Crypt::class;
        Cotacoes::where('dtvalidade', '<=', date('Y-m-d'))->where('idstatus', 9)->update(['idstatus' => 11]);

        if (Auth::user()->hasRole('admin')) {
            $cotacoes = Cotacoes::whereIn('idstatus', [9])->orderby('idcotacao', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $cotacoes = Cotacoes::where('idcorretor', Auth::user()->corretor->idcorretor)->whereNotNull('usuario_id')->whereIn('idstatus', [9])->orderby('idcotacao', 'desc')->get();
        } else {
            $cotacoes = Cotacoes::where('usuario_id', Auth::user()->id)->whereNotNull('usuario_id')->whereIn('idstatus', [9])->orderby('idcotacao', 'desc')->get();
        }


        return view('backend.cotacao.negociacoes', compact('cotacoes', 'crypt', 'title'));
    }

    public function vencidas()
    {

        $crypt = Crypt::class;
        Cotacoes::where('dtvalidade', '<=', date('Y-m-d'))->update(['idstatus' => 11]);
        $title = 'Canceladas ou Vencidas';


        if (Auth::user()->hasRole('admin')) {
            $cotacoes = Cotacoes::whereNotIn('idstatus', [9, 10])->orderby('idcotacao', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $cotacoes = Cotacoes::where('idcorretor', Auth::user()->corretor->idcorretor)->whereNotNull('usuario_id')->whereNotIn('idstatus', [9, 10])->orderby('idcotacao', 'desc')->get();
        } else {
            $cotacoes = Cotacoes::where('usuario_id', Auth::user()->id)->whereNotNull('usuario_id')->whereNotIn('idstatus', [9, 10])->orderby('idcotacao', 'desc')->get();
        }


        return view('backend.cotacao.negociacoes', compact('cotacoes', 'crypt', 'title'));
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
            [
                "segNomeRazao" => ($request->tipopessoa == 1 ? $request->segnome : $request->segrazao),
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
            [

                "proprCpfCnpj" => ($request->proptipopessoa == 1 ? getDataReady($request->propcpf) : getDataReady($request->propcnpj)),
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


    public function sendEmail(Request $request)
    {
        try {
            $cotacao_id = Crypt::decrypt($request->cotacao_id);
        } Catch (DecryptException $e) {
            return abort(404);
        }
//        $this->validate($request, ['email' => 'required|email|max:255']);


        $cotacao = Cotacoes::find($cotacao_id);
        $formas = [];

        if ($cotacao) {
            $menor_parcela = 0;
            foreach ($cotacao->produtos as $produto) {
                $menor_parcela = $menor_parcela + $produto->produto->precoproduto()->where('idprecoproduto', $produto->idprecoproduto)->first()->vlrminprimparc;
            }

            foreach (FormaPagamento::All() as $forma) {
                $parcelas = new \stdClass();
                $parcelas->parcelas = geraParcelas($cotacao->premio, $forma->nummaxparc, $forma->numparcsemjuros, $forma->taxamesjuros, $menor_parcela, $forma->idformapgto, $cotacao->renova);
                $parcelas->forma_pagamento = $forma->descformapgto;
                $formas[] = $parcelas;
            }

            $cotacao->segurado()->update(['cliemail' => $request->email]);



            error_reporting(E_ERROR);
            $pdf = Pdf::loadView('backend.pdf.cotacao', compact('cotacao', 'formas'));
            $pdf->SetProtection(['print'], '', '456');
            $pdf->save(public_path('pdf/Cotacao.pdf'));


            Mail::send('backend.mail.cotacao', compact('cotacao'), function ($m) use ($cotacao, $request) {
                $m->from(Auth::user()->email, strtoupper(Auth::user()->nome));
                $m->attach(public_path('pdf/Cotacao.pdf'));
                $m->bcc('apolices_enviadas@seguroautopratico.com.br');
                $m->replyTo(Auth::user()->email, strtoupper(Auth::user()->nome));
                (strlen(Auth::user()->email) > 3 ? $m->cc(Auth::user()->email, strtoupper(Auth::user()->nome)) : NULL);
                $m->to($request->email)->subject('Cotacao');
            });
            unlink(public_path('pdf/Cotacao.pdf'));
            return Redirect::back()->with('sucesso', 'Email enviado com sucesso! ');

        } else {
            return Redirect::back()->with('error', 'Cotação Invalida!');
        }

    }

    public function showEmail($cotacao_id)
    {
        try {
            $cotacao_id = Crypt::decrypt($cotacao_id);
        } catch (DecryptException $e) {
            return abort(404);
        }

        $cotacao = Cotacoes::find($cotacao_id);

        return view('backend.cotacao.show_email', compact('cotacao'));
    }

    public function reemitir($cotacao_id, TipoUtilizacaoVeic $tipoutilizacao, TipoVeiculos $tipos, FormaPagamento $formas)
    {
        try {
            $cotacao_id = Crypt::decrypt($cotacao_id);
        } catch (DecryptException $e) {
            return abort(404);
        }

        $produto_master = '';
        $produto_opcionais = '';
        $opcionais = [];

        $cotacao = Cotacoes::find($cotacao_id);

        foreach ($cotacao->produtos as $produto) {
            if ($produto->produto->tipoproduto == 'master') {
                $produto_master = $produto->produto->idproduto;
            } else {
                $opcionais[] = (string)$produto->produto->idproduto;
            }
        }


        if (count($opcionais)) {
            $produto_opcionais = $opcionais;
        }
        return view('backend.cotacao.cotar', compact('tipos', 'tipoutilizacao', 'formas', 'cotacao', 'produto_master', 'produto_opcionais'));


    }

    public function pdf_cotacao($cotacao_id)
    {

        $cotacao = Cotacoes::find(Crypt::decrypt($cotacao_id));
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
            return $pdf->stream('Cotacao');
        } else {
            return Redirect::back()->with('error', 'Cotação Invalida!');
        }


    }

    public function sucesso($idcotacao)
    {
        $cotacao = Cotacoes::find(Crypt::decrypt($idcotacao));
        $crypt = Crypt::class;

        return view('backend.cotacao.sucesso', compact('cotacao', 'crypt'));


    }

    public function salvar(Request $request)
    {
        $url = env('API_URL', Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first()->url);


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
                "veiAno" => $request->anomodelo,
                "veiIndZero" => $request->indautozero,
                "veiCdTipo" => $request->tipoveiculo,
                "veiCdCombust" => $request->combustivel,
            ],
            "idParceiro" => 99,
            "renova" => $request->renova,
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
                    return Redirect::route('proposta.index', Crypt::encrypt($cotacao->retorno->cdCotacao));
                    break;
                case 'salvar':
                    return Redirect::route('cotacao.sucesso', Crypt::encrypt($cotacao->retorno->cdCotacao));
                    break;
                default :
                    return Redirect::route('cotacao.cotar');
            }
        } else {

            $msg = '<strong>Status: </strong> ' . $cotacao->status;
            $msg .= '<br> <strong>Code: </strong> ' . $cotacao->cdretorno;
            if (is_object($cotacao->message)) {
                foreach ($cotacao->message as $message) {
                    $msg .= '<br> <strong>Mensagem: </strong> ' . $message . '!';
                }
            } else {
                $msg .= '<br> <strong>Mensagem: </strong> ' . $cotacao->message . '!';
            }

            return Redirect::back()->with('error', $msg);
        }


    }
}
