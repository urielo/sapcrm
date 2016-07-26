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

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

Route::get('teste', function () {

    $SoapClient = new \SoapClient('http://ws.nobre.com.br/AutoService.svc?wsdl');

    $xmlvar = new \SoapVar('<Authorization>ABHeZhJudALhqLktqAZbUwNkAGk1SIm6PAh42SM2B/IXonOONjfL0F8GbZD7dGIXNuhetELem7NNJyyq5cQo6Q==</Authorization>', 147);

    $header = new  \SoapHeader('http://ws.nobre.com.br/', 'Authorization', $xmlvar);
    $SoapClient->__setSoapHeaders($header);



//    $result = $SoapClient->__soapCall('Ping',[]);

        $getvehicle = $SoapClient->GetVehicle([
            'promoCode' => 'SKY-PROTECTION-3164-P50',
            'fipeCode' => '114357-5',
        ]);

//    set_error_handler('var_dump', 0); // Never called because of empty mask.
//    @trigger_error("");
//    restore_error_handler();

    return var_dump($getvehicle);
});


Route::get('/modelo', ['as' => 'modelo', 'uses' => 'Backend\AjaxController@modelo']);
Route::get('/profissao', ['as' => 'profissao', 'uses' => 'Backend\AjaxController@profissao']);
Route::get('/ramoatividade', ['as' => 'ramoatividade', 'uses' => 'Backend\AjaxController@ramoatividade']);
Route::get('/anovalor', ['as' => 'anovalor', 'uses' => 'Backend\AjaxController@anovalor']);
Route::get('/anofab', ['as' => 'anofab', 'uses' => 'Backend\AjaxController@anofab']);
Route::get('/produtosmaster', ['as' => 'produtosmaster', 'uses' => 'Backend\AjaxController@produtosmaster']);
Route::get('/produtosopcional', ['as' => 'produtosopcional', 'uses' => 'Backend\AjaxController@produtosopcional']);


Route::group(['prefix' => 'vendas'], function () {


    Route::post('gerar', [
        'as' => 'cotacao.gerar',
        'uses' => 'Backend\CotacaoController@gerar']);

    Route::get('negociacoes', [
        'as' => 'vendas.negociacoes',
        'uses' => 'Backend\CotacaoController@negociacoes']);

    Route::get('negociar/{idcotacao}', [
        'as' => 'vendas.negociar',
        'uses' => 'Backend\CotacaoController@negociar']);

    Route::get('cotar', [
        'as' => 'cotacao.cotar',
        'uses' => 'Backend\CotacaoController@cotar'
    ]);

    Route::get('pdf/{idproposta}', [
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf'
    ]);

});

Route::group(['prefix' => 'gestao'], function () {


    Route::get('apolices', [
        'as' => 'gestao.apolices',
        'uses' => 'Backend\GestaoController@apolices']);
    Route::get('apolices/emitir/{idproposta}', [
        'as' => 'apolices.emitir',
        'uses' => 'Backend\GestaoController@emitir']);
    
    Route::get('apolices/pdf/{idproposta}', [
        'as' => 'apolices.pdf',
        'uses' => 'Backend\GestaoController@apolicepdf']);


});


// Segurado Routes
Route::group(['prefix' => 'segurado'], function () {
    # Route::resource('/cont', 'Backend\SeguradoController');

    Route::get('/{segurado}/show', [
        'as' => 'segurado.show',
        'uses' => 'Backend\SeguradoController@show'
    ]);

    Route::get('/cadastro', [
        'as' => 'segurado.cadastro',
        'uses' => 'Backend\SeguradoController@create'
    ]);

    Route::post('/cadastro', [
        'as' => 'segurado.store',
        'uses' => 'Backend\SeguradoController@store'
    ]);

    Route::put('/cadastro', [
        'as' => 'segurado.edit',
        'uses' => 'Backend\SeguradoController@edit'
    ]);

    Route::get('/', [
        'as' => 'segurado.index',
        'uses' => 'Backend\SeguradoController@index'
    ]);

//    Route::get('/cadastro',[
//    'as'=>'segurado.cadastro', 
//    'uses' => 'Backend\SeguradoController@create'
//    ]);

    Route::post('/', [
        'as' => 'backend.segurado',
        'uses' => 'Backend\SeguradoController@store'
    ]);
});
Route::group(['prefix' => 'upload'], function () {
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
