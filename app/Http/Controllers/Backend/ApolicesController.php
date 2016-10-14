<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use App\Model\CustoProduto;
use App\Model\ConfigSeguradora;
use App\Model\ApolicesSeguradora;

use App\Http\Controllers\Backend\CertificadoController;
use App\Model\Propostas;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Model\FipeAnoValor;

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

        $cetificado = (new CertificadoController())->gerarCertificado($proposta, $data_emissao, $idseguradora);


        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"certificado_N{$idproposta}.pdf\";");
        echo base64_decode($cetificado);

//        return ;

    }

    public function download(Request $request)
    {

        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"{$request->filename}.pdf\";");
        echo base64_decode($request->base64);
    }

    public function emitir(Request $request)
    {
        $proposta = Propostas::find($request->proposta);
        if ($request->seguradora == 3) {
            $config = ConfigSeguradora::where('id_seguradora', $request->seguradora)
                ->where('id_tipo_veiculo', $proposta->cotacao->veiculo->veiccdveitipo)->first();
            $cetificado = (new CertificadoController())->gerarCertificado($proposta, $request->datavirgencia, $config);
            if ($cetificado) {
                $proposta->idstatus = 18;
                $proposta->save();
                return Redirect::back()->with('sucesso', 'Operação realizada com sucesso');

            }
//            return $request->input();

        } else {
            return Redirect::back()->with('atencao', 'O serviço dessa seguradora está temporariamente Fora!');
        }

    }


    public function showModal($idproposta)
    {
        $proposta = Propostas::find($idproposta);
        $retorno = [];
        $seguradoras_master = [];
        $v_idade = date('Y') - $proposta->cotacao->veiculo->veicano;
        $v_valor = FipeAnoValor::where('codefipe', $proposta->cotacao->veiculo->veiccodfipe)
            ->where('idcombustivel', $proposta->cotacao->veiculo->veictipocombus)
            ->where('ano', $proposta->cotacao->veiculo->veicano)->first()->valor;


        $custos = [];
        $seguradoras = [];

        foreach ($proposta->cotacao->produtos as $produto) {
            foreach (CustoProduto::where('idproduto', $produto->idproduto)->where('idprecoproduto', $produto->idprecoproduto)->get() as $custo) {
                $custos[$produto->idproduto][] = $custo;
            }
        }


        foreach ($custos as $custo) {
            foreach ($custo as $cust) {
                $seguradoras[$cust->idseguradora][$cust->idproduto] = $cust;

            }
        }

        foreach ($seguradoras as $key => $seguradora) {
            if (count($seguradora) > 1) {
                foreach ($seguradoras as $key2 => $seg) {
                    if ($key2 != $key) {
                        unset($seguradoras[$key2]);
                    }
                }
            }
        }

        $assitencia = CustoProduto::find(17);
        $seguradoras[$assitencia->idseguradora][$assitencia->idproduto] = $assitencia;
        $retorno = $seguradoras;

//        foreach ($seguradoras as $seg_key=>$seg_value){
//            foreach ($seg_value as $cust_key=>$cust_value){
//                foreach ($cust_value->produto->seguradoras as $seg_produto){
//                    if($seg_key == $seg_produto->idseguradora && (bool) $seg_produto->obg_mesma_seguradora ){
//
//                        foreach ($seguradoras as $seg_key_i=>$seg_value_i){
//                            if($seg_key_i != $seg_key){
//                                
//                            }
//
//                        }
//                        $retorno[] = $cust_value;
//
//
//                    }
//
//                }
//
//            }
//        }


        return view('backend.show.emitirapolices', compact('retorno', 'proposta'));
    }

    public function showModalApolices($idproposta)
    {
        $proposta = Propostas::find($idproposta);

        return view('backend.show.baixarapolices', compact('proposta'));
    }
}
