<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;

use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Mail;
use App\Model\Logs;

use App\Model\Propostas;
use App\Model\FipeAnoValor;
use App\Model\Produtos;

use App\Model\Segurado;
use App\Model\Config;
use App\Model\TipoVeiculos;

use App\Model\Veiculos;
use App\Model\Uf;
use App\Model\TipoUtilizacaoVeic;
use App\Model\EstadosCivis;
use App\Model\Cotacoes;
use App\Model\OrgaoEmissors;
use App\Model\FormaPagamento;

class TesteController extends Controller
{

    public function index(TipoUtilizacaoVeic $tipoutilizacao, TipoVeiculos $tipos, FormaPagamento $formas)
    {

        $a = 0;
        $b = 1;
        echo $a . '<br>';
        echo $b . '<br><b>';
        while ($b < 5000){
            $c = $a + $b;
            echo $c . '<br>';
            $a = $b;
            $b = $c;

        }
      
//        return view('backend.cotacao.cotar',compact('tipos','tipoutilizacao', 'formas'));

    }


    public function mail()
    {


        $proposta = Propostas::find(307);

        echo view('backend.mail.apolice', compact('proposta'));

        $file = fopen(public_path('certificado.pdf'), 'w');
        fwrite($file, base64_decode($proposta->certificado->pdf_base64));
        fclose($file);


        Mail::send('backend.mail.apolice', compact('proposta'), function ($m) use ($file) {
            $m->from('pedro@seguroautopratico.com.br', 'Teste');
            $m->attach(public_path('certificado.pdf'));
            $m->replyTo('apolices@seguroautopratico.com.br', 'Apolices');
            $m->to(['uriel@seguroautopratico.com.br', 'douglas@seguroautopratico.com.br', 'luciano@seguroautopratico.com.br', 'uriel.f.oliveira@gmail.com'])->subject('Apolice');
        });

        unlink(public_path('certificado.pdf'));
    }


    public function json_show()
    {


    }


    public function get_log()
    {
        $log =Logs::find(30987);

        echo '<pre>';
        echo  json_encode(json_decode($log->params),JSON_PRETTY_PRINT);
        echo '</pre>';
    }

}
