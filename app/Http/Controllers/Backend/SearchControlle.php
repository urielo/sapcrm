<?php

namespace App\Http\Controllers\Backend;

use App\Model\Cotacoes;
use App\Model\Propostas;
use App\Model\Status;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class SearchControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pesquisa)
    {

        return view('backend.search.home', compact('pesquisa'));
    }

    public function result($pesquisa, Request $request)
    {
        if ($pesquisa == 'proposta') {
            DB::enableQueryLog();
            $request->tipo_consulta;
            $pesquisa = getDataReady($request->value_pesquisa);
            $nome = $request->value_pesquisa;
            $crypt = Crypt::class;
            
            
            


            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos','veiculo');
            if ($request->tipo_consulta == 'placa') {
                $propostas =  $propostas->whereHas('veiculo', function ($q) use ($pesquisa) {
                    $q->where('veicplaca', 'ilike', '%' . $pesquisa . '%');
                });
            } else if ($request->tipo_consulta == 'cpfcnpj') {
                $propostas =    $propostas->whereHas('cotacao', function ($q) use ($pesquisa) {
                    $q->select('segurado.clicpfcnpj');
                    $q->join('segurado', 'segurado_id', '=', 'segurado.id');
                    $q->where('segurado.clicpfcnpj', 'ilike',  '%'.$pesquisa.'%');
                });
            } else {
                $propostas =   $propostas->whereHas('cotacao', function ($q) use ($nome) {
                    $q->whereHas('segurado', function ($qq) use ($nome) {
                        $qq->where('clinomerazao', 'ilike', '%' . $nome . '%');
                    });
                });
            }


            if (Auth::user()->hasRole('admin')) {
                $propostas =   $propostas->orderby('idproposta', 'desc')->get();
            } elseif (Auth::user()->can('ver-todos-cotacoes')) {
                $propostas =  $propostas->whereHas('cotacao', function ($q) {
                    $q->where('idcorretor', Auth::user()->corretor->idcorretor);
                })->orderby('idproposta', 'desc')->get();
            } else {
                $propostas =   $propostas->whereHas('cotacao', function ($q) {
                    $q->where('usuario_id', Auth::user()->id)->whereNotNull('usuario_id');
                })->orderby('idcotacao', 'desc')->get();
            }

            return view('backend.search.table_proposta', compact('propostas', 'crypt'));
        }
    }

    protected function getPropostas($request)
    {

    }

}
