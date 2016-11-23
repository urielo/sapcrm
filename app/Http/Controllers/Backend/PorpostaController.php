<?php

namespace App\Http\Controllers\Backend;

use App\Model\Cotacoes;
use App\Model\EstadosCivis;
use App\Model\FormaPagamento;
use App\Model\OrgaoEmissors;
use App\Model\Profissoes;
use App\Model\RamoAtividades;
use App\Model\TipoUtilizacaoVeic;
use App\Model\Uf;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class PorpostaController extends Controller
{
    public function index($cotacao_id)
    {
        $cotacao = Cotacoes::find(Crypt::decrypt($cotacao_id));
        $formas = [];
        $ufs = Uf::lists('nm_uf','cd_uf');
        $estados_civis = EstadosCivis::lists('nmestadocivil','idestadocivil');
        $profissoes = Profissoes::lists('nm_ocupacao','id_ocupacao');
        $ramos_atividades = RamoAtividades::lists('nome_atividade','id_ramo_atividade');
        $tipoultiveics = TipoUtilizacaoVeic::class;
        $orgaos_emissores = OrgaoEmissors::lists('desc_oe','cd_oe');
        

        

        if ($cotacao) {
            $menor_parcela = 0;
            foreach ($cotacao->produtos as $produto) {
                $menor_parcela = $menor_parcela + $produto->produto->precoproduto()->where('idprecoproduto', $produto->idprecoproduto)->first()->vlrminprimparc;
            }

            foreach (FormaPagamento::All() as $forma) {
                $parcelas = new \stdClass();
                $parcelas->parcelas = geraParcelas($cotacao->premio, $forma->nummaxparc, $forma->numparcsemjuros, $forma->taxamesjuros, $menor_parcela, $forma->idformapgto);
                $parcelas->forma_pagamento = $forma->descformapgto;
                $parcelas->forma_id = $forma->idformapgto;
                $formas[] = $parcelas;
            }
        }
        
        return view('backend.proposta.emitir',compact('cotacao','formas','ufs','estados_civis','tipoultiveics','ramos_atividades','profissoes','orgaos_emissores'));
    }

    public function emitir(Request $request)

    {
        return Redirect::back();
        return $request->all();
    }
}
