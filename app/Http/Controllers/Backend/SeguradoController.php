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

class SeguradoController extends Controller
{
public function __construct(OrgaoEmissors $orgaoemissors, EstadosCivis $estadoscivis, Segurado $segurados, Veiculos $veiculos, TipoVeiculos $tipos, Uf $ufs, TipoUtilizacaoVeic $tipoultiveics)
{   $this->tipos = $tipos;
    $this->segurado = $segurados;
    $this->veiculo = $veiculos;
    $this->ufs = $ufs;
    $this->tipoultiveics = $tipoultiveics;
    $this->estadoscivis = $estadoscivis;
    $this->orgaoemissors = $orgaoemissors;
    parent::__construct();
}
    public function index()
    {   
        $segurados = $this->segurado->paginate(10);
        return view('backend.segurado.home', compact('segurados','veiculos'));
    }
    
    public function create()
    {
        $veiculos = $this->veiculo;
        $segurados = $this->segurado;
        $tipos = $this->tipos;
        $ufs = $this->ufs;
        $tipoultiveics = $this->tipoultiveics;
        $estadoscivis = $this->estadoscivis;      
        $orgaoemissors = $this->orgaoemissors;      
        
        
        return view('backend.segurado.form', compact('segurados', 'orgaoemissors', 'veiculos', 'tipos', 'ufs', 'tipoultiveics', 'estadoscivis'));
    }
    
    public function store( $request)
    {
        
    }
    
    public function show($cpfcnpj)
    {
        
    }

    public function edit()
    {
        
    }
    
    public function update()
    {
        
    }
    
    public function destroy()
    {
        
    }
    
}
