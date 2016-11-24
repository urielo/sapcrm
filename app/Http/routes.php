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


Route::group(['prefix' => 'teste'], function () {
    Route::get('/', 'Backend\TesteController@index');
    Route::get('/mail', 'Backend\TesteController@mail');

    Route::get('/post', ['as'=>'post.teste',
    'uses'=> 'Backend\TesteController@post_teste']);

    


});

Route::get('/certificado/{idproposta}', ['as' => 'certificado', 'uses' => 'Backend\ApolicesController@index']);

Route::group(['prefix' => 'grupos', 'middleware' => ['permission:altera-grupo']], function () {
    Route::get('/', ['as' => 'grupos.index', 'uses' => 'Backend\RolesController@index']);
    Route::post('/update', ['as' => 'grupos.update', 'uses' => 'Backend\RolesController@update']);
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
    Route::get('/veiculo', ['as' => 'veiculo.search', 'uses' => 'Backend\VeiculoController@searchVeiculo']);
    Route::get('/searchfipe', ['as' => 'fipe.search', 'uses' => 'Backend\VeiculoController@searchFipe']);

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
        'uses' => 'Backend\CotacaoController@index'
    ]);

    Route::get('proposta/{cotacao_id}', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'proposta.index',
        'uses' => 'Backend\PorpostaController@index'
    ]);
    
    Route::post('proposta/emitir', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'proposta.emitir',
        'uses' => 'Backend\PorpostaController@emitir'
    ]);

    Route::get('proposta/sucesso/{proposta_id}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'proposta.sucesso',
        'uses' => 'Backend\PorpostaController@sucesso']);

    Route::get('proposta/pdf/{proposta_id}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'proposta.pdf',
        'uses' => 'Backend\PorpostaController@pdf']);

    Route::get('cotacao/sucesso/{idcotacao}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.sucesso',
        'uses' => 'Backend\CotacaoController@sucesso']);


    
    Route::post('cotacao/salvar',[
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.salvar',
        'uses' => 'Backend\CotacaoController@salvar'
    ]);


    Route::get('pdf/{idproposta}', [
        'middleware' => ['permission:vendas-cotacao-pdf'],
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf'
    ]);
    
    Route::get('cotacao/pdf/{cotacao_id}',[
        'middleware' => ['permission:vendas-cotacao-pdf'],
        'as' => 'cotacao.pdf.gerar',
        'uses' => 'Backend\CotacaoController@pdf_cotacao'
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

    Route::get('apolices/show/{idproposta}', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.show',
        'uses' => 'Backend\ApolicesController@showModal']);

    Route::get('apolices/email/{idproposta}', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.email',
        'uses' => 'Backend\ApolicesController@email']);

    Route::get('apolices/showemitidas/{idproposta}', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.showemiditas',
        'uses' => 'Backend\ApolicesController@showModalApolices']);

    Route::post('apolices/emitir', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.emitir',
        'uses' => 'Backend\ApolicesController@emitir']);

    Route::post('apolices/download', [
        'middleware' => ['permission:gestao-apolice-emitir'],
        'as' => 'apolices.download',
        'uses' => 'Backend\ApolicesController@download']);

    Route::get('cobranca', [
        'middleware' => ['permission:gestao-cobranca'],
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


