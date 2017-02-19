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


            $propostas = Propostas::with('cotacao.segurado', 'status', 'motivos');
            if ($request->tipo_consulta == 'placa') {
                $propostas->whereHas('veiculo', function ($q) use ($pesquisa) {
                    $q->where('veicplaca', 'ilike', '%' . $pesquisa . '%');
                });
            } else if ($request->tipo_consulta == 'cpfcnpj') {
                $propostas->whereHas('cotacao', function ($q) use ($pesquisa) {
                    $q->whereHas('segurado', function ($qq) use ($pesquisa) {
                        $qq->where('clicpfcnpj' ,'like', $pesquisa);
                    });
                });
            } else {
                $propostas->whereHas('cotacao', function ($q) use ($pesquisa) {
                    $q->whereHas('segurado', function ($qq) use ($pesquisa) {
                        $qq->where('clinomerazao', 'ilike', $pesquisa);
                    });
                });
            }


            if (Auth::user()->hasRole('admin')) {
                $propostas->orderby('idproposta', 'desc')->get();
            } elseif (Auth::user()->can('ver-todos-cotacoes')) {
                $propostas->whereHas('cotacao', function ($q) {
                    $q->where('idcorretor', Auth::user()->corretor->idcorretor);
                })->orderby('idproposta', 'desc')->get();
            } else {
                $propostas->whereHas('cotacao', function ($q) {
                    $q->where('usuario_id', Auth::user()->id)->whereNotNull('usuario_id');
                })->orderby('idcotacao', 'desc')->get();
            }
//            print_r(DB::getQueryLog())   ;


            return view('backend.search.table_proposta', compact('propostas', 'motivo', 'crypt', 'title'));
        }
    }

    protected function getPropostas($request)
    {

    }

}
