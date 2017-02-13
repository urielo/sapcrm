<?php

namespace App\Http\Controllers\Backend;
use App\Model\Fipes;
use App\Model\TipoUtilizacaoVeic;
use App\Model\Uf;
use App\Model\Veiculos;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;


class VeiculoController extends Controller
{

    public function index()
    {
        $veiculos = Veiculos::limit(200)->where('veicplaca','!=','')->distinct('veicid')->get();

        $crypt = Crypt::class;

        $offset = 200;
        $url = route('veiculo.loadmore');



        return view('backend.veiculo.home', compact('veiculos','crypt','url','offset'));
    }

    public function veiculoAjax(Request $request)
    {

        $veiculos = Veiculos::skip($request->offset)->distinct('veicid')->limit(200)->where('veicplaca','!=','')->get();

    
        $crypt = Crypt::class;

        return view('backend.veiculo.veiculo_ajax', compact('veiculos','crypt'));
    }
    public function edit($id)
    {
        try {
            

            $veiculo = Veiculos::find(Crypt::decrypt($id));
            $ufs = Uf::lists('nm_uf', 'cd_uf');
            $tipoultiveics = TipoUtilizacaoVeic::class;


            return view('backend.veiculo.edit_modal', compact('veiculo', 'ufs','tipoultiveics'));


        }catch (Exception $e){
            return Redirect::back()->with('error', 'Segurado não encontrado');


        }
    }

    public function update(Request $request){

        try{
            DB::beginTransaction();

            $veiculo = Veiculos::find($request->id);
            $veiculo->veicplaca = getDataReady($request->placa);
            $veiculo->veicmunicplaca = $request->munplaca ;
            $veiculo->veiccdufplaca = $request->placa_uf ;
            $veiculo->veianofab = $request->anof ;
            $veiculo->veicrenavam = $request->renavan ;
            $veiculo->veicanorenavam = $request->anorenav ;
            $veiculo->veicchassi = $request->chassi ;
            $veiculo->veicor = $request->veiccor ;
            $veiculo->veiccdutilizaco = $request->veicultilizacao ;
            $veiculo->veicchassiremar = $request->indcahssiremarc ;
            $veiculo->veicleilao = $request->indleilao ;
            $veiculo->save();

            DB::commit();
            return Redirect::back()->with('sucesso','Operação realizada com sucesso!');

        }catch (Exception $e){
            DB::rollBack();
            return Redirect::back()->with('error', 'Ops! Ocorreu um erro ao tentar atualizar o veiculo!');

        }


    }
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
