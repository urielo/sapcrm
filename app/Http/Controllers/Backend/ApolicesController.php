<?php

namespace App\Http\Controllers\Backend;

use App\Model\Cancelamentos;
use App\Model\MotivosCancelamentoCertificado;
use App\Model\Status;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Redirect;

use App\Model\CustoProduto;
use App\Model\ConfigSeguradora;
use App\Model\ApolicesSeguradora;

use App\Http\Controllers\Backend\CertificadoController;
use App\Model\Propostas;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Model\FipeAnoValor;
use Illuminate\View\View;

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


        return view('backend.show.emitirapolices', compact('retorno', 'proposta'));
    }

    public function showModalApolices($idproposta)
    {
        $proposta = Propostas::find($idproposta);

        return view('backend.show.baixarapolices', compact('proposta'));
    }


    public function email($idproposta)
    {

        $proposta = Propostas::find($idproposta);

        if (strlen($proposta->cotacao->segurado->cliemail) > 3) {
            $apolice = public_path('Certificado.pdf');

            $file = fopen($apolice, 'w');
            fwrite($file, base64_decode($proposta->certificado->pdf_base64));
            fclose($file);

            Mail::send('backend.mail.apolice', compact('proposta'), function ($m) use ($file, $proposta, $apolice) {
                $m->from('apolice@seguroautopratico.com.br', 'Apolices');
                $m->attach($apolice);
                $m->bcc('apolices_enviadas@seguroautopratico.com.br');
                $m->replyTo('apolice@seguroautopratico.com.br', 'Apolices');
                (strlen($proposta->cotacao->corretor->corremail) > 3 ? $m->cc($proposta->cotacao->corretor->corremail, primeiroNome($proposta->cotacao->corretor->corrnomerazao)) : NULL);
                $m->to($proposta->cotacao->segurado->cliemail, primeiroNome($proposta->cotacao->segurado->clinomerazao))->subject('Apolice');
            });
            unlink($apolice);
            return Redirect::back()->with('sucesso', 'Email enviado com sucesso! ');

        } else {
            return Redirect::back()->with('error', 'Error ao tentar enviar, o email do cliente é inválido! ');

        }

    }

    public function emitidas()
    {
        $propostas = Propostas::where('idstatus', 18)
            ->orderBy('idproposta', 'asc')
            ->get();

        $apolices = ApolicesSeguradora::where('status_id',18)->with('proposta','certificado')->get();
        $crypt = Crypt::class;

        return view('backend.gestao.apolices', compact('apolices','crypt'));
    }

    public function aemitir()
    {
        $propostas = Propostas::whereIn('idstatus', [15, 24])
            ->orderBy('idproposta', 'asc')
            ->get();
        $crypt = Crypt::class;

        return view('backend.gestao.apolices', compact('propostas','crypt'));
    }

    public function cancela($id)
    {
       
        try{
            $motivos = MotivosCancelamentoCertificado::lists('descricao','id');

            $apolice = ApolicesSeguradora::find(Crypt::decrypt($id));
            $route= 'apolices.cancelar';
            $tipo = 'Apolice';
            if($apolice){
                
                return view('backend.show.cancelaapolices',compact('apolice','motivos','route','tipo'));

            }else{
                return 0 ;
            }            
        }catch (DecryptException $e){
            return 0 ;
        }
        



    }

    public function cancelar(Request $request)
    {
        try{
            DB::beginTransaction();
            $apolice = ApolicesSeguradora::find($request->id);
            $cancelamento = new Cancelamentos;
            $cancelamento->motivo_id = $request->motivo;
            $cancelamento->cancelado_desc = 'apolice';
            $apolice->cancelado()->save($cancelamento);
            $apolice->status_id = 12;

            if($apolice->certificado->status_id == 1){
                $apolice->certificado->status_id = 12;
            } else{
                $apolice->certificado->status_id = 40;
            }
            $apolice->certificado->save();
            $apolice->save();


            DB::commit();

            return Redirect::back()->with('sucesso','Operação realizada com sucesso!');

        }catch (QueryException $e){

            DB::rollback();
            return Redirect::back()->with('Error','Erro ao tentar cancelar por favor tente novamente mais tarde!');
        }
    }

    public function canceladas()
    {

        $status = Status::where('descricao','ilike','%cancelad%')
            ->orWhere('descricao','ilike','%inati%')
            ->orWhere('descricao','ilike','%vencid%')
            ->orWhere('descricao','ilike','%recusad%')
            ->lists('id');

        $apolices = ApolicesSeguradora::whereIn('status_id',$status)->with('proposta','certificado','cancelado')->orderBy('id', 'asc')->get();

        $status = true;
        return view('backend.gestao.apolices', compact('apolices', 'status'));

    }
}
