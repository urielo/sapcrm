<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Console\Commands\CotacaoCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\CotacaoRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Model\Segurado;
use App\Model\Uf;
use App\Model\Veiculos;
use App\Model\Cotacoes;
use App\Model\Propostas;

class ShowsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function segurado($cpfcnpj)
    {
        $segurado = Segurado::find($cpfcnpj);

        $segurado->tipop = (strlen($segurado->clicpfcnpj) > 11 ? 2 : 1);
        return view('backend.show.segurado', compact('segurado'));
    }

    public function cancela($idproposta)
    {
        $proposta = new \stdClass();
        $proposta->idproposta = $idproposta;
        $motivos = ['1'=>'Nao gostou','2'=>'Nao Conseguiu pagar', '3'=>'Problemas com cartão'];
        $motivos = Uf::all();

        return view('backend.show.cancelapagamaneto',compact('proposta','motivos'));
    }


}
