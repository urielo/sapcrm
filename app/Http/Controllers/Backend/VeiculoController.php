<?php

namespace App\Http\Controllers\Backend;
use App\Model\Fipes;
use App\Model\Veiculos;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;


class VeiculoController extends Controller
{
    public function searchVeiculo(Request $request)
    {
        $veiculo_raw = Veiculos::where('veicplaca', 'ilike','%'.$request->get('placa').'%')->first();
        $veiculo= new \stdClass();
        if($veiculo_raw){
            $veiculo->status = true;
            $veiculo->chassi = $veiculo_raw->veicchassi;
            $veiculo->renavan = $veiculo_raw->veicrenavam;
            $veiculo->municipio= $veiculo_raw->veicmunicplaca;
            $veiculo->uf= $veiculo_raw->veiccdufplaca;
            $veiculo->cor= $veiculo_raw->veicor;
            $veiculo->anorenavam= $veiculo_raw->veicanorenavam;
            $veiculo->anofab= $veiculo_raw->veianofab;


        } else{
            $veiculo->status = false;

        }



        
        
//        return $veiculo;
        return response()->json($veiculo);
    }


    public function searchFipe(Request $request)
    {
        $fipe = Fipes::where('codefipe','ilike',"%{$request->get('fipe')}%")->first();
        
        if($fipe){
            $fipe->status = true;
            return response()->json($fipe);

        } else{
            return response()->json(['status'=>false]);

        }
    }
}
