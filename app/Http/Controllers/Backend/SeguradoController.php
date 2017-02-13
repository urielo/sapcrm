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
use Illuminate\Support\Facades\DB;

class SeguradoController extends Controller
{
public function __construct()
{   
    parent::__construct();
}
    public function index()
    {
        $segurados = Segurado::limit(200)->orderBy('clinomerazao')->get();
        
        $crypt = Crypt::class;
        
        $offset = 200;
        $url = route('segurado.loadmore');
        
        

        return view('backend.segurado.home', compact('segurados','crypt','url','offset'));
    }

    public function seguradoAjax(Request $request)
    {
        $segurados = Segurado::skip($request->offset)->limit(200)->orderBy('clinomerazao')->get();

        $crypt = Crypt::class;

        return view('backend.segurado.segurado_ajax', compact('segurados','crypt'));
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
    
    public function update(Request $request)
    {
      try{
          DB::beginTransaction();
          $segurado = Segurado::find($request->id);

          $segurado->clicpfcnpj = getDataReady($request->seg_cpfnpj);
          $segurado->clinomerazao = strtoupper($request->seg_nomerazao);
          $segurado->clidtnasc = getDateFormat($request->seg_data_nascimento_inscricao, 'nascimento');
          $segurado->clicdprofiramoatividade = $request->seg_profissao_ramo;
          $segurado->cliemail = $request->seg_email;
          $segurado->clidddcel = getDataReady($request->seg_cel_ddd);
          $segurado->clinmcel = getDataReady($request->seg_cel_numero);
          $segurado->clidddfone = getDataReady($request->seg_fixo_ddd);
          $segurado->clinmfone = getDataReady($request->seg_fixo_numero);
          $segurado->clicep = getDataReady($request->seg_end_cep);
          $segurado->clinmend = $request->seg_end_log;
          $segurado->clinumero = $request->seg_end_num;
          $segurado->clinmcidade = $request->seg_end_cidade;
          $segurado->bairro = $request->seg_end_bairro;
          $segurado->clicduf = $request->seg_end_uf;
          $segurado->cliendcomplet = $request->seg_end_complemento;
          $segurado->clicdsexo = $request->seg_sexo;
          $segurado->clicdestadocivil = $request->seg_estado_civil;
          $segurado->clinumrg = $request->seg_rg_numero;
          $segurado->clicdufemissaorg = $request->seg_rg_uf;
          $segurado->clidtemissaorg = ($request->seg_rg_emissao ? getDateFormat($request->seg_rg_emissao, 'nascimento') : NULL);
          $segurado->cliemissorrg = $request->seg_rg_org;

        $segurado->save();
          return Redirect::back()->with('sucesso','Operação realizada com sucesso!');


      }catch (Exception $e){
          return Redirect::back()->with('error', 'Ops! Ocorreu um erro ao tentar atualizar o segurado!');

      }
        



        return $segurado->toArray();
    }
    
    public function destroy()
    {
        
    }
    
}
