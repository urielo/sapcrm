<?php
Route::auth();

Route::controller('auth', 'Auth\AuthController', [
    'getLogin' => 'auth.login',
    'getLogout' => 'auth.logout',
]);

Route::get('/', [
    'as' => 'backend.dashboard',
    'uses' => 'Backend\DashboardController@index'
]);

use Illuminate\Support\Facades\Mail;
use Khill\Lavacharts\Lavacharts;
use App\User;
use App\Model\Role;
use App\Model\Corretores;

use App\Model\Logs;

Route::get('teste', function () {
//    $user = User::find(1);
//
//    $

//    $role = Role::find(3);
//    $user =  User::create([
//        'nome' => 'joao',
//        'email' => 'brito@email.com',
//        'idstatus' => 2,
//        'password' => bcrypt(1234456),
//    ]);
//
//    $user->attachRole($role);
//
//    return $user;


//    $data = ['nome'=> 'uriel'];
//
//    Mail::send('welcome', $data, function ($message) {
//        $message->from('uriel@skyprotection.com.br', 'Uriel');
//
//        $message->to('uriel@seguroautopratico.com.br');
//    });


});


Route::group(['prefix' => 'ajax'], function () {

    Route::get('/modelo', ['as' => 'modelo', 'uses' => 'Backend\AjaxController@modelo']);
    Route::get('/profissao', ['as' => 'profissao', 'uses' => 'Backend\AjaxController@profissao']);
    Route::get('/ramoatividade', ['as' => 'ramoatividade', 'uses' => 'Backend\AjaxController@ramoatividade']);
    Route::get('/anovalor', ['as' => 'anovalor', 'uses' => 'Backend\AjaxController@anovalor']);
    Route::get('/anofab', ['as' => 'anofab', 'uses' => 'Backend\AjaxController@anofab']);
    Route::get('/produtosmaster', ['as' => 'produtosmaster', 'uses' => 'Backend\AjaxController@produtosmaster']);
    Route::get('/produtosopcional', ['as' => 'produtosopcional', 'uses' => 'Backend\AjaxController@produtosopcional']);
    Route::get('/complete', ['as' => 'seguradoauto', 'uses' => 'Backend\AjaxController@inputscomplete']);
    Route::get('/getcorretor', ['as' => 'corretor.form', 'uses' => 'Auth\AuthController@getCorretor']);


});

Route::group(['prefix' => 'usuario', 'middleware' => 'auth'], function () {

    Route::get('/gestao', [

            'middleware' => ['permission:usuarios-gestao'],
            'as' => 'usuarios.gestao',
            'uses' => 'Backend\UserController@index'
        ]
    );
    Route::get('search/{searchterm?}', [

            'middleware' => ['permission:usuarios-gestao'],
            'as' => 'usuarios.search',
            'uses' => 'Backend\UserController@search'
        ]
    );
    
    Route::get('/alterstatus/{iduser}', [
            'middleware' => ['permission:usuarios-gestao'],
            'as' => 'usuarios.alterstatus',
            'uses' => 'Backend\UserController@alterStatus'
        ]
    );
    Route::get('/tipos/{iduser}', [
            'middleware' => ['permission:usuarios-gestao'],
            'as' => 'usuarios.tipos',
            'uses' => 'Backend\UserController@tipos'
        ]
    );
    Route::post('/alteratipos', [
            'middleware' => ['permission:usuarios-gestao'],
            'as' => 'usuarios.alteratipos',
            'uses' => 'Backend\UserController@alteratipos'
        ]
    );

});

Route::group(['prefix' => 'vendas', 'middleware' => 'auth'], function () {


    Route::post('gerar', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.gerar',
        'uses' => 'Backend\CotacaoController@gerar']);

    Route::get('negociacoes', [

        'middleware' => ['permission:vendas-negociacoes'],
        'as' => 'vendas.negociacoes',
        'uses' => 'Backend\CotacaoController@negociacoes']);

    Route::get('negociar/{idcotacao}', [
        'middleware' => ['permission:vendas-negociacoes-negociar'],
        'as' => 'vendas.negociar',
        'uses' => 'Backend\CotacaoController@negociar']);

    Route::get('cotar', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'cotacao.cotar',
        'uses' => 'Backend\CotacaoController@cotar'
    ]);

    Route::get('pdf/{idproposta}', [
        'middleware' => ['permission:vendas-cotacao-pdf'],
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf'
    ]);

});

Route::group(['prefix' => 'gestao', 'middleware' => 'auth'], function () {


    Route::get('apolices', [
        'middleware' => ['permission:gesta-apolice'],
        'as' => 'gestao.apolices',
        'uses' => 'Backend\GestaoController@apolices']);

    Route::get('aprovacao', [
        'middleware' => ['permission:gesta-aprovacao'],
        'as' => 'gestao.aprovacao',
        'uses' => 'Backend\GestaoController@aprovacao']);

    Route::get('apolices/emitir/{idproposta}', [
        'middleware' => ['permission:gestao-cobranca'],
        'as' => 'apolices.emitir',
        'uses' => 'Backend\GestaoController@emitir']);

    Route::get('apolices/pdf/{idproposta}', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.pdf',
        'uses' => 'Backend\GestaoController@apolicepdf']);

    Route::get('cobranca', [
        'middleware' => ['permission:gestao-apolice-pdf'],
        'as' => 'gestao.cobranca',
        'uses' => 'Backend\GestaoController@cobranca']);
    Route::get('pagamento/recusar/{idproposta}', [
        'middleware' => ['permission:gestao-aprovacao-recusar'],
        'as' => 'gestao.recusar',
        'uses' => 'Backend\GestaoController@recusapagamento']);

    Route::post('cancela', [
        'middleware' => ['permission:gestao-cobranca-cancelar'],
        'as' => 'gestao.cancela',
        'uses' => 'Backend\GestaoController@cancelar']);

    Route::post('pagar', [
        'middleware' => ['permission:gestao-cobranca-salvapagamento'],
        'as' => 'gestao.salvarpga',
        'uses' => 'Backend\GestaoController@salvarpagamento']);

    Route::post('confirmapg', [
        'middleware' => ['permission:gestao-aprovacao-comfirma'],
        'as' => 'gestao.confirmapg',
        'uses' => 'Backend\GestaoController@confirmapagamento']);


});

Route::group(['prefix' => 'show', 'middleware' => 'auth'], function () {

    Route::get('segurado/{cpfcnpj}', [
        'middleware' => ['permission:segurado-show'],
        'as' => 'show.segurado',
        'uses' => 'Backend\ShowsController@segurado']);

    Route::get('proposta/{idproposta}', [
        'middleware' => ['permission:show-proposta'],
        'as' => 'show.proposta',
        'uses' => 'Backend\ShowsController@proposta']);

    Route::get('cancela/{idproposta}', [

        'middleware' => ['permission:gestao-cobranca-cancelar'],
        'as' => 'show.cancelaproposta',
        'uses' => 'Backend\ShowsController@cancela']);

    Route::get('pagar/{idproposta}', [
        'middleware' => ['permission:gestao-cobranca-salvapagamento'],
        'as' => 'show.pagamento',
        'uses' => 'Backend\ShowsController@pagar']);

    Route::get('pagar/confirmar/{idproposta}', [
        'middleware' => ['permission:gestao-aprovacao-comfirma'],
        'as' => 'show.confirmapgto',
        'uses' => 'Backend\ShowsController@confirmapgto']);


});


Route::group(['prefix' => 'upload', 'middleware' => 'auth'], function () {
    Route::resource('/', 'Backend\Config\UploadController');

    Route::get('/', [
        'as' => 'backend.upload',
        'uses' => 'Backend\Config\UploadController@index'
    ]);

    Route::post('/fipeanovalor', [
        'as' => 'upload.fipeanovalor',
        'uses' => 'Backend\Config\UploadController@postUploadFipeAnoValor'
    ]);

    Route::post('/fipe', [
        'as' => 'upload.fipe',
        'uses' => 'Backend\Config\UploadController@postUploadFipe'
    ]);
});
//
//Route::get('/', function () {
//    return view('welcome');
//});


