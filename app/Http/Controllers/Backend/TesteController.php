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

class TesteController extends Controller
{

    public function index()
    {
        //
////echo date('Y-m-d 00:00:00', strtotime('+ 30 days'));
////    $url =  Config::where('env_local',env('APP_LOCAL'))->where('webservice','SAP')->first();
////    echo $url->url .'proposta';
//////    $user = User::find(1);
//////
//////    $
////
//////    $role = Role::find(3);
//////    $user =  User::create([
//////        'nome' => 'joao',
//////        'email' => 'brito@email.com',
//////        'idstatus' => 2,
//////        'password' => bcrypt(1234456),
//////    ]);
//////
//////    $user->attachRole($role);
//////
//////    return $user;
////
////
//////    $data = ['nome'=> 'uriel'];
//////
//////    Mail::send('welcome', $data, function ($message) {
//////        $message->from('uriel@skyprotection.com.br', 'Uriel');
//////
//////        $message->to('uriel@seguroautopratico.com.br');
//////    });
////if(env('APP_LOCAL') == 'producao'){
////    return env('APP_LOCAL');
////
////}else{
////    return env('APP_LOCAL');
////}
//
////    $pdf = App::make('dompdf.wrapper');
//    error_reporting(E_ERROR);
//
//    $proposta = Propostas::find($idproposta);
//
//
//    $pdf = PDF::loadView('backend.pdf.certificado',compact('proposta'));
//    $pdf->SetProtection(['print'],'','456');
//    return $pdf->stream('document.pdf');

//    return date('d/m/Y', strtotime('+1 month'));

//    $cotaocao = CotacaoProdutos::where('idcotcao',7523)->first();
//
//    return $cotaocao->preco;

//
//    $proposta = Propostas::find(419);
//
//   $valor =  $proposta->cotacao->veiculo->fipe_ano_valor()
//        ->where('ano',$proposta->cotacao->veiculo->veicano)
//        ->where('idcombustivel',$proposta->cotacao->veiculo->veictipocombus)
//        ->first()->valor;
//return $proposta->cotacao->veiculo->valor;
//    echo between(1,10,5);

//    echo date('d/m/Y',strtotime(20150915));
//    return FipeAnoValor::where('codefipe',$proposta->cotacao->veiculo->veiccodfipe)
//        ->where('idcombustivel',$proposta->cotacao->veiculo->veictipocombus)
//        ->where('ano',$proposta->cotacao->veiculo->veicano)->first()->valor;
//    return Produtos::whereIdproduto(3)->whereCodstatus(1)->first();

        return public_path('certificado.pdf');
    }

    public function mail()
    {
        

       
        $proposta = Propostas::find(307);

        echo view('backend.mail.apolice',compact('proposta'));

        $file = fopen(public_path('certificado.pdf'), 'w');
        fwrite($file, base64_decode($proposta->certificado->pdf_base64));
        fclose($file);


        Mail::send('backend.mail.apolice', compact('proposta'), function ($m) use($file) {
            $m->from('pedro@seguroautopratico.com.br', 'Teste');
            $m->attach(public_path('certificado.pdf'));
            $m->replyTo('apolices@seguroautopratico.com.br','Apolices');
            $m->to(['uriel@seguroautopratico.com.br','douglas@seguroautopratico.com.br','luciano@seguroautopratico.com.br','uriel.f.oliveira@gmail.com'])->subject('Apolice');
        });

        unlink(public_path('certificado.pdf'));
    }


}
