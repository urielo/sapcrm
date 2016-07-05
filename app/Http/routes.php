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



//Route::get('teste', function () {
//    echo '<pre>';
//    print_r();
//    echo '</pre>';
//});


Route::get('/modelo', ['as' => 'modelo', 'uses' => 'Backend\AjaxController@modelo']);
Route::get('/profissao', ['as' => 'profissao', 'uses' => 'Backend\AjaxController@profissao']);
Route::get('/ramoatividade', ['as' => 'ramoatividade', 'uses' => 'Backend\AjaxController@ramoatividade']);
Route::get('/anovalor', ['as' => 'anovalor', 'uses' => 'Backend\AjaxController@anovalor']);
Route::get('/anofab', ['as' => 'anofab', 'uses' => 'Backend\AjaxController@anofab']);
Route::get('/produtosmaster', ['as' => 'produtosmaster', 'uses' => 'Backend\AjaxController@produtosmaster']);
Route::get('/produtosopcional', ['as' => 'produtosopcional', 'uses' => 'Backend\AjaxController@produtosopcional']);


Route::group(['prefix' => 'cotacao'], function () {


    Route::post('gerar', [
        'as' => 'cotacao.gerar',
        'uses' => 'Backend\CotacaoController@gerar']);

    Route::get('cotar', [
        'as' => 'cotacao.cotar',
        'uses' => 'Backend\CotacaoController@cotar'
    ]);

    Route::get('pdf/{idproposta}', [
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf'
    ]);

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
