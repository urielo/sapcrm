<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Model\Certificados;
use App\Model\Propostas;
use App\Model\CustoProduto;
use App\Model\ApolicesSeguradora;
use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;

use App\Model\SeguradoraProduto;
use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;
use phpDocumentor\Reflection\Types\Object_;

class CertificadoController extends Controller
{
    /**
     * @param array $middleware $this->certificado->dt_inicio_virgencia
     */
    protected $certificado;
    protected $data_virgencia = '';
    protected $proposta;
    protected $idseguradora = 0;
    protected $config = null;

    protected $status = false;


    public function gerarCertificado($proposta, $data_virgencia, $config)
    {
        $this->proposta = $proposta;
        $this->data_virgencia = date('Y-m-d H:i:s', strtotime(getDateFormat($data_virgencia)));
        $this->idseguradora = $config->id_seguradora;
        $this->config = $config;
        $this->Create();
        $this->attachCusto();
        $this->pdf();
        $this->apoliceCreate();

        return true;


    }


    protected function Create()
    {

        $certificado = new Certificados();
        $certificado->idproposta = $this->proposta->idproposta;
        $certificado->idseguradora = $this->idseguradora;
        $certificado->dt_emissao = date('Y-m-d H:i:s');
        $certificado->dt_inicio_virgencia = $this->data_virgencia;
        $certificado->iof = $this->config->iof;
        $certificado->save();
        $this->certificado = $certificado;


    }

    protected function apoliceCreate()
    {
        $apolice = new ApolicesSeguradora();

        $date = date('Ymd', strtotime($this->certificado->dt_inicio_virgencia));

        $apolice->id_config_seguradora = $this->config->id;
        $apolice->id_apolice_seguradora = $this->certificado->id;
        $apolice->dt_ativa_rastreador = $date;
        $apolice->dt_instalacao_rastreador = $date;
        $apolice->dt_ativa_rastreador = $date;
        $apolice->dt_inicio_comodato = $date;
        $apolice->dt_fim_comodato = date('Ymd', strtotime('+1 year', strtotime($this->certificado->dt_inicio_virgencia)));

        $this->proposta->apoliceseguradora()->save($apolice);

    }


    protected function attachCusto()
    {
        $custos = [];

        foreach ($this->proposta->cotacao->produtos as $produto) {
            $custo = CustoProduto::whereIdproduto($produto->idproduto)
                ->whereIdprecoproduto($produto->idprecoproduto)
                ->whereIdseguradora($this->idseguradora)->first();

            if ($custo) {

                $custos[] = $custo->id;
            }

        }

        $custo = CustoProduto::whereIdproduto(4)
            ->whereIdprecoproduto(1)
            ->whereIdseguradora($this->idseguradora)->first();


        $custos[] = $custo->id;

        $this->certificado->custos()->sync($custos);

    }

    protected function pdf()
    {
        $proposta = $this->proposta;
        $certificado = $this->certificado;

        $custos['premioTotal'] = 0;

        $produto_seg = SeguradoraProduto::where('idseguradora', $this->idseguradora)->get();


        foreach ($produto_seg as $produto) {
            foreach ($this->certificado->custos as $custo) {
                $valores = new \stdClass();


                if ($custo->idproduto == $produto->idproduto) {
                    $valores->idproduto = $produto->idproduto;
                    $valores->custo = 'R$ ' . format('real', $custo->custo_anual);
                    $custos[$produto->idproduto] = $valores;
                    $custos['premioTotal'] = $custos['premioTotal'] + $custo->custo_anual;
                } else if (!array_key_exists($produto->idproduto, $custos)) {
                    $valores->idproduto = $produto->idproduto;
                    $valores->custo = '<span style="color: red">S/C</span>';
                    $custos[$produto->idproduto] = $valores;
                }

            }

        }

        $custos['premioLiquido'] = $custos['premioTotal'] - ($custos['premioTotal'] * $this->certificado->iof / 100);


        error_reporting(E_ERROR);
        $pdf = PDF::loadView('backend.pdf.certificado', compact('proposta', 'certificado', 'custos'));
        $pdf->SetProtection(['print'], '', '456');

        $this->certificado->pdf_base64 = chunk_split(base64_encode($pdf->output()));
        $this->certificado->save();
    }


}
