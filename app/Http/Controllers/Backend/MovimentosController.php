<?php

namespace App\Http\Controllers\Backend;

use App\Model\Movimentos;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MovimentosController extends Controller
{
    public function emitidos()
    {
        $movimentos = Movimentos::where('tipo_envio','emitidos')->get();
        $title = 'Emitidos';

        $dados = [];
        foreach ($movimentos as $movimento){
            $envados = json_decode($movimento->datas_enviadas);
            foreach ($envados->retorno as  $enviado){
                $dados[(int)$enviado->numero_certificado]['certificado']= (int)$enviado->numero_certificado;
                $dados[(int)$enviado->numero_certificado]['lote']= $movimento->id;
                $dados[(int)$enviado->numero_certificado]['placa']= format('placa',$enviado->placa);
                $dados[(int)$enviado->numero_certificado]['segurado']= nomeCase($enviado->nome);
                $dados[(int)$enviado->numero_certificado]['enviado']= showDate($movimento->dt_envio);
                $dados[(int)$enviado->numero_certificado]['retorno']= '';
                $dados[(int)$enviado->numero_certificado]['desc_retorno']= '';
                $dados[(int)$enviado->numero_certificado]['tipo']= ucfirst($movimento->tipo_envio);
                $dados[(int)$enviado->numero_certificado]['status']= 'Movimento - Enviado';

            }

            if($movimento->status_id != 26 ){
                $datas = json_decode($movimento->datas_recebidas);
                $retornos = isset($datas->retorno) ? $datas->retorno : $datas;

                foreach ($retornos as $retorno){
                    $dados[(int)$retorno->numero_certificado]['status']= 'Movimento - Retorno';
                    $dados[(int)$retorno->numero_certificado]['desc_retorno']= strlen($retorno->texto) > 1 ? $retorno->texto : 'Sucesso';
                    $dados[(int)$retorno->numero_certificado]['retorno']= showDate($movimento->dt_envio);

                }

            }



        }
        ksort($dados);

        return view('backend.movimentos.listas', compact('dados','title'));


    }
    public function cancelados()
    {
        $movimentos = Movimentos::where('tipo_envio','!=','emitidos')->get();
        $title = 'Cancelados';


        $dados = [];
        foreach ($movimentos as $movimento){
            $envados = json_decode($movimento->datas_enviadas);
            foreach ($envados->retorno as  $enviado){
                $dados[(int)$enviado->numero_certificado]['certificado']= (int)$enviado->numero_certificado;
                $dados[(int)$enviado->numero_certificado]['lote']= $movimento->id;
                $dados[(int)$enviado->numero_certificado]['placa']= format('placa',$enviado->placa);
                $dados[(int)$enviado->numero_certificado]['segurado']= nomeCase($enviado->nome);
                $dados[(int)$enviado->numero_certificado]['enviado']= showDate($movimento->dt_envio);
                $dados[(int)$enviado->numero_certificado]['retorno']= '';
                $dados[(int)$enviado->numero_certificado]['desc_retorno']= '';
                $dados[(int)$enviado->numero_certificado]['tipo']= ucfirst($movimento->tipo_envio);
                $dados[(int)$enviado->numero_certificado]['status']= 'Movimento - Enviado';

            }

            if($movimento->status_id != 26 ){
                $datas = json_decode($movimento->datas_recebidas);
                $retornos = isset($datas->retorno) ? $datas->retorno : $datas;

                foreach ($retornos as $retorno){
                    $dados[(int)$retorno->numero_certificado]['status']= 'Movimento - Retorno';
                    $dados[(int)$retorno->numero_certificado]['desc_retorno']= strlen($retorno->texto) > 1 ? $retorno->texto : 'Sucesso';
                    $dados[(int)$retorno->numero_certificado]['retorno']= showDate($movimento->dt_envio);

                }

            }
        }

        ksort($dados);

        return view('backend.movimentos.listas', compact('dados','title'));


    }
}
