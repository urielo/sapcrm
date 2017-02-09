<?php

namespace App\Http\Controllers\Backend;
use App\Model\Profissoes;
use App\Model\RamoAtividades;
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

//        
//        "segNomeRazao" => $request->seg_nomerazao,
//            "segCpfCnpj" => getDataReady($request->seg_cpfnpj),
//            "segDtNasci" => getDateFormat($request->seg_data_nascimento_inscricao, 'nascimento'),
//            "segCdSexo" => $request->seg_sexo,
//            "segCdEstCivl" => $request->seg_estado_civil,
//            "segProfRamoAtivi" => $request->seg_profissao_ramo,
//            "segEmail" => $request->seg_email,
//            "segCelDdd" => getDataReady($request->seg_cel_ddd),
//            "segCelNum" => getDataReady($request->seg_cel_numero),
//            "segFoneDdd" => getDataReady($request->seg_fixo_ddd),
//            "segFoneNum" => getDataReady($request->seg_fixo_numero),
//            "segEnd" => $request->seg_end_log,
//            "segEndNum" => $request->seg_end_num,
//            "segEndCompl" => $request->seg_end_complemento,
//            "segEndCep" => getDataReady($request->seg_end_cep),
//            "segEndCidade" => $request->seg_end_cidade,
//            "segEndCdUf" => $request->seg_end_uf,
//            "segNumRg" => getDataReady($request->seg_rg_numero),
//            "segDtEmissaoRg" => ($request->seg_rg_emissao ? getDateFormat($request->seg_rg_emissao, 'nascimento') : NULL),
//            "segEmissorRg" => $request->seg_rg_org,
//            "segBairro" => $request->seg_end_bairro,
//            "segCdUfRg" => $request->seg_rg_uf,
        
    }
    
    public function destroy()
    {
        
    }
    
}
