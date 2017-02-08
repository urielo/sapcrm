<?php

namespace App\Http\Controllers\Backend;
use App\Model\Segurado;
use App\Model\TipoVeiculos;
use App\Model\Veiculos;
use App\Model\Uf;
use App\Model\TipoUtilizacaoVeic;
use App\Model\EstadosCivis;
use App\Model\OrgaoEmissors;
use App\Model\FormaPagamento;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class SeguradoController extends Controller
{
public function __construct()
{   
    parent::__construct();
}
    public function index()
    {
        $segurados = Segurado::all();
        
        $crypt = Crypt::class;

        return view('backend.segurado.home', compact('segurados','crypt'));
    }
    
    public function create()
    {
       $segurados = Segurado::all();
        
        
        return view('backend.segurado.home', compact('segurados'));
    }
    
    public function store( $request)
    {
        
    }
    
    public function show($cpfcnpj)
    {
        
    }

    public function edit($id)
    {
        try {


            $segurado = Segurado::find(Crypt::decrypt($id));
            $formas = [];
            $ufs = Uf::lists('nm_uf', 'cd_uf');
            $estados_civis = EstadosCivis::lists('nmestadocivil', 'idestadocivil');
            $profissoes = Profissoes::lists('nm_ocupacao', 'id_ocupacao');
            $ramos_atividades = RamoAtividades::lists('nome_atividade', 'id_ramo_atividade');
            $tipoultiveics = TipoUtilizacaoVeic::class;
            $orgaos_emissores = OrgaoEmissors::lists('desc_oe', 'cd_oe');


            return view('backend.segurado.edit_modal', compact('segurado', 'formas', 'ufs', 'estados_civis', 'tipoultiveics', 'ramos_atividades', 'profissoes', 'orgaos_emissores'));


        }catch (Exception $e){
            return Redirect::back()->with('error', 'Segurado não encontrado');

            
        }
    }
    
    public function update()
    {
        
    }
    
    public function destroy()
    {
        
    }
    
}
