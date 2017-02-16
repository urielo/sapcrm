<?php

namespace App\Http\Controllers\Backend;

use App\Model\Cancelamentos;
use App\Model\Config;
use App\Model\Cotacoes;
use App\Model\EstadosCivis;
use App\Model\FormaPagamento;
use App\Model\MotivosCancelamentoCertificado;
use App\Model\OrgaoEmissors;
use App\Model\Profissoes;
use App\Model\Propostas;
use App\Model\RamoAtividades;
use App\Model\Status;
use App\Model\TipoUtilizacaoVeic;
use App\Model\Uf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PropostaController extends Controller
{
    public function index($cotacao_id)
    {
        $cotacao = Cotacoes::find(Crypt::decrypt($cotacao_id));
        $formas = [];
        $ufs = Uf::lists('nm_uf', 'cd_uf');
        $estados_civis = EstadosCivis::lists('nmestadocivil', 'idestadocivil');
        $profissoes = Profissoes::lists('nm_ocupacao', 'id_ocupacao');
        $ramos_atividades = RamoAtividades::lists('nome_atividade', 'id_ramo_atividade');
        $tipoultiveics = TipoUtilizacaoVeic::class;
        $orgaos_emissores = OrgaoEmissors::lists('desc_oe', 'cd_oe');


        if ($cotacao) {
            $menor_parcela = 0;

            if ($cotacao->renova == 0) {
                foreach ($cotacao->produtos as $produto) {
                    $menor_parcela = $menor_parcela + $produto->produto->precoproduto()->where('idprecoproduto', $produto->idprecoproduto)->first()->vlrminprimparc;
                }
            }

            foreach (FormaPagamento::All() as $forma) {
                $parcelas = new \stdClass();
                $parcelas->parcelas = geraParcelas($cotacao->premio, $forma->nummaxparc, $forma->numparcsemjuros, $forma->taxamesjuros, $menor_parcela, $forma->idformapgto);
                $parcelas->forma_pagamento = $forma->descformapgto;
                $parcelas->forma_id = $forma->idformapgto;
                $formas[] = $parcelas;
            }
        }

        return view('backend.proposta.emitir', compact('cotacao', 'formas', 'ufs', 'estados_civis', 'tipoultiveics', 'ramos_atividades', 'profissoes', 'orgaos_emissores'));
    }

    public function emitir(Request $request)
    {

        $url = env('API_URL', Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first()->url);


        $proposta = [
            "idParceiro" => 99,
            "nmParceiro" => "seguro AutoPratico",
            "cdCotacao" => $request->cotacao_id,
            "cdFormaPgt" => $request->formapagamento,
            "qtParcela" => $request->quant_parcela,
            "nmBandeira" => $request->forma_cartao_bandeira,
            "numCartao" => getDataReady($request->forma_cartao_numero),
            "validadeCartao" => getDateFormat($request->forma_cartao_validade, 'valcartao'),
            "dataPrimeiroBoleto" => getDateFormat($request->form_boleto_primeiro, 'nascimento'),
            "diaDemaisBoleto" => $request->form_boleto_dia_demais,
            "titularCartao" => $request->forma_cartao_nome,
            "indProprietVeic" => $request->ind_propritetario,
            "renova" => $request->renova,
        ];

        $proposta['veiculo'] = [
            "veiAno" => $request->ano,
            "veiCodFipe" => $request->fipe,
            "veiAnoFab" => $request->anof,
            "veiCor" => $request->veiccor,
            "veiIndZero" => $request->autozero,
            "veiCdUtiliz" => $request->veicultilizacao,
            "veiCdTipo" => $request->tipoveiculo,
            "veiCdCombust" => $request->combustivel,
            "veiPlaca" => getDataReady($request->placa),
            "veiMunPlaca" => $request->munplaca,
            "veiCdUfPlaca" => $request->placa_uf,
            "veiRenav" => $request->renavan,
            "veiAnoRenav" => $request->anorenav,
            "veiChassi" => $request->chassi,
            "veiIndChassiRema" => $request->indcahssiremarc,
            "veiIndLeilao" => $request->indleilao,
        ];

        $proposta['segurado'] = [
            "segNomeRazao" => $request->seg_nomerazao,
            "segCpfCnpj" => getDataReady($request->seg_cpfnpj),
            "segDtNasci" => getDateFormat($request->seg_data_nascimento_inscricao, 'nascimento'),
            "segCdSexo" => $request->seg_sexo,
            "segCdEstCivl" => $request->seg_estado_civil,
            "segProfRamoAtivi" => $request->seg_profissao_ramo,
            "segEmail" => $request->seg_email,
            "segCelDdd" => getDataReady($request->seg_cel_ddd),
            "segCelNum" => getDataReady($request->seg_cel_numero),
            "segFoneDdd" => getDataReady($request->seg_fixo_ddd),
            "segFoneNum" => getDataReady($request->seg_fixo_numero),
            "segEnd" => $request->seg_end_log,
            "segEndNum" => $request->seg_end_num,
            "segEndCompl" => $request->seg_end_complemento,
            "segEndCep" => getDataReady($request->seg_end_cep),
            "segEndCidade" => $request->seg_end_cidade,
            "segEndCdUf" => $request->seg_end_uf,
            "segNumRg" => getDataReady($request->seg_rg_numero),
            "segDtEmissaoRg" => ($request->seg_rg_emissao ? getDateFormat($request->seg_rg_emissao, 'nascimento') : NULL),
            "segEmissorRg" => $request->seg_rg_org,
            "segBairro" => $request->seg_end_bairro,
            "segCdUfRg" => $request->seg_rg_uf
        ];

        $proposta['proprietario'] = [
            "proprNomeRazao" => $request->prop_nomerazao,
            "proprDtNasci" => getDateFormat($request->prop_data_nascimento_inscricao, 'nascimento'),
        ];


        $proposta_ws = json_decode(webserviceProposta($proposta, $url));

        if ($proposta_ws->cdretorno == '000') {
            Propostas::where('idproposta', $proposta_ws->retorno->idproposta)->update(['usuario_id' => Auth::user()->id]);
            return Redirect::route('proposta.sucesso', Crypt::encrypt($proposta_ws->retorno->idproposta));
        } else {
            $msg = '<strong>Status: </strong> ' . $proposta_ws->status;
            $msg .= '<br> <strong>Code: </strong> ' . $proposta_ws->cdretorno;
            if (is_object($proposta_ws->message)) {
                foreach ($proposta_ws->message as $message) {
                    $msg .= '<br> <strong>Mensagem: </strong> ' . $message . '!';
                }
            } else {
                $msg .= '<br> <strong>Mensagem: </strong> ' . $proposta_ws->message . '!';
            }

            return Redirect::back()->with('error', $msg)->withInput();
        }


    }

    public function sucesso($proposta_id)
    {
        $proposta = Propostas::find(Crypt::decrypt($proposta_id));
        $crypt = Crypt::class;

        return view('backend.cotacao.sucesso', compact('proposta', 'crypt'));
    }

    public function pdf($proposta_id)
    {
        try {
            $proposta_id = Crypt::decrypt($proposta_id);
        } catch (DecryptException $e) {

            return abort(404);
        }

        $curl = curl_init();
        $url = env('API_URL', Config::where('env_local', env('APP_LOCAL'))->where('webservice', 'SAP')->first()->url);


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . 'pdf',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"idParceiro\": 99,\n    \"nmParceiro\": \"Seguro AutoPratico\",\n    \"idProposta\": {$proposta_id}\n}",
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
//            return $response;
            $pdf = json_decode($response);
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=\"proposta_N{$proposta_id}.pdf\";");
            echo base64_decode($pdf->base64);
        }
    }

    public function acompanhamento()
    {

        $crypt = Crypt::class;
        $motivo = false;

        $title = 'Acompanhamento';

        $status = Status::where('descricao', 'ilike', '%cancelad%')
            ->orWhere('descricao', 'ilike', '%inati%')
            ->orWhere('descricao', 'ilike', '%vencida%')
            ->orWhere('descricao', 'ilike', '%recusad%')
            ->lists('id');

        if (Auth::user()->hasRole('admin')) {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos')->whereNotIn('idstatus', $status)->orderby('idproposta', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos')->whereHas('cotacao', function ($q) {
                $q->where('idcorretor', Auth::user()->corretor->idcorretor);
            })->whereNotIn('idstatus', $status)->orderby('idproposta', 'desc')->get();
        } else {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos')->whereHas('cotacao', function ($q) {
                $q->where('usuario_id', Auth::user()->id)->whereNotNull('usuario_id');

            })->whereNotIn('idstatus', $status)->orderby('idcotacao', 'desc')->get();
        }


        return view('backend.proposta.listas', compact('propostas', 'motivo', 'crypt', 'title'));
    }

    public function negativas()
    {
        $crypt = Crypt::class;

        $motivo = true;

        $status = Status::where('descricao', 'ilike', '%cancelad%')
            ->orWhere('descricao', 'ilike', '%inati%')
            ->orWhere('descricao', 'ilike', '%vencid%')
            ->orWhere('descricao', 'ilike', '%recusad%')
            ->lists('id');

        $title = 'Canceladas, Recusadas e Vencidas';

        if (Auth::user()->hasRole('admin')) {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos','cancelado')->whereIn('idstatus', $status)->orderby('idproposta', 'desc')->get();
        } elseif (Auth::user()->can('ver-todos-cotacoes')) {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos', 'cancelado')->whereHas('cotacao', function ($q) {
                $q->where('idcorretor', Auth::user()->corretor->idcorretor);
            })->whereIn('idstatus', $status)->orderby('idproposta', 'desc')->get();
        } else {
            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos', 'cancelado')->whereHas('cotacao', function ($q) {
                $q->where('usuario_id', Auth::user()->id);
            })->whereIn('idstatus', $status)->orderby('idcotacao', 'desc')->get();
        }
        return view('backend.proposta.listas', compact('propostas', 'motivo', 'crypt', 'title'));
    }

    public function cancela($id)
    {
        try {

            $motivos = MotivosCancelamentoCertificado::lists('descricao', 'id');

            $proposta = Propostas::find(Crypt::decrypt($id));
            $route = 'proposta.cancelar';
            $tipo = 'Proposta';

            if ($proposta) {

                return view('backend.show.cancelaapolices', compact('proposta', 'motivos', 'route', 'tipo'));

            } else {
                return 0;
            }
        } catch (DecryptException $e) {
            return 0;
        }
    }

    public function cancelar(Request $request)
    {
        try {
            DB::beginTransaction();
            $proposta = Propostas::find($request->id);
            $cancelamento = new Cancelamentos;
            $cancelamento->motivo_id = $request->motivo;
            $cancelamento->cancelado_desc = 'proposta';
            $proposta->cancelado()->save($cancelamento);
            $proposta->idstatus = 12;
            $proposta->save();

            DB::commit();
            return Redirect::back()->with('sucesso', 'Operação realizada com sucesso!');


        } catch (QueryException $e) {

            DB::rollback();
            return Redirect::back()->with('Error', 'Erro ao tentar cancelar por favor tente novamente mais tarde!');

        }
    }
}
