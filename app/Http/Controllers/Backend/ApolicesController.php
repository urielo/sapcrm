<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Model\CustoProduto;

use App\Http\Controllers\Backend\CertificadoController;
use App\Model\Propostas;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApolicesController extends Controller
{
    /**
     * @return string
     */




    public function index($idproposta)
    {
        $proposta = Propostas::find($idproposta);
        $idseguradora = 3;
        $data_emissao = '07-09-2016';

        $cetificado = (new CertificadoController())->gerarCertificado($proposta,$data_emissao,$idseguradora);



        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=\"certificado_N{$idproposta}.pdf\";");
        echo base64_decode($cetificado);
        
//        return ;
        
    }


    public function showModal($idproposta)
    {
        $proposta = Propostas::find($idproposta);


        foreach ($proposta->cotacao->produtos as $produto){
            if($produto->idproduto == 1){



            }
        }





    }
}
