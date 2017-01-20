<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    public function cotacoes(Request $request)
    {
        ini_set('max_execution_time', 0);
        $title = 'Ativas';
        $crypt = Crypt::class;
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d',strtotime('-30 days'));



        if (Auth::user()->hasRole('admin')) {
           $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->whereIn('idstatus', [9])->whereBetween('dtcreate',[$start_date ,$end_date])->orderby('idcotacao', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->where('idcorretor', Auth::user()->corretor->idcorretor)->whereBetween('dtcreate',[$start_date ,$end_date])->whereNotNull('usuario_id')->whereIn('idstatus', [9])->orderby('idcotacao', 'desc')->get();
        } else {
            $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->where('usuario_id', Auth::user()->id)->whereBetween('dtcreate',[$start_date ,$end_date])->whereNotNull('usuario_id')->whereIn('idstatus', [9])->orderby('idcotacao', 'desc')->get();
        }


        return view('backend.cotacao.negociacoes', compact('cotacoes', 'crypt', 'title'));
    }

    public function vencidas()
    {
        ini_set('max_execution_time', 0);
        $crypt = Crypt::class;
        $title = 'Canceladas ou Vencidas';
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d',strtotime('-30 days'));


        if (Auth::user()->hasRole('admin')) {
            $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->whereNotIn('idstatus', [9, 10])->whereBetween('dtcreate',[$start_date ,$end_date])->orderby('idcotacao', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->where('idcorretor', Auth::user()->corretor->idcorretor)->whereBetween('dtcreate',[$start_date ,$end_date])->whereNotNull('usuario_id')->whereNotIn('idstatus', [9, 10])->orderby('idcotacao', 'desc')->get();
        } else {
            $cotacoes = Cotacoes::with(['segurado','veiculo.fipe.anovalor','veiculo.combustivel','corretor'])->where('usuario_id', Auth::user()->id)->whereBetween('dtcreate',[$start_date ,$end_date])->whereNotNull('usuario_id')->whereNotIn('idstatus', [9, 10])->orderby('idcotacao', 'desc')->get();
        }


        return view('backend.cotacao.negociacoes', compact('cotacoes', 'crypt', 'title'));
    }
    
    public function sendEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|max:255']);

        try {
            $cotacao_id = Crypt::decrypt($request->cotacao_id);
        } Catch (DecryptException $e) {
            return abort(404);
        }

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
