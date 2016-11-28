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

    Route::get('/post', ['as' => 'post.teste',
        'uses' => 'Backend\TesteController@post_teste']);


});

Route::get('/certificado/{idproposta}', ['as' => 'certificado', 'uses' => 'Backend\ApolicesController@index']);

Route::group(['prefix' => 'grupos', 'middleware' => ['permission:altera-grupo']], function () {
    Route::get('/', ['as' => 'grupos.index', 'uses' => 'Backend\RolesController@index']);
    Route::post('/update', ['as' => 'grupos.update', 'uses' => 'Backend\RolesController@update']);
});


Route::group(['prefix' => 'ajax'], function () {

    Route::get('/modelo', ['as' => 'ajax.modelo', 'uses' => 'Backend\AjaxController@modelo']);
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


Route::group(['prefix' => 'apolices', 'middleware' => 'auth'], function () {

    Route::get('emitidas', [
            'middleware' => 'permission:gesta-apolice',
            'as' => 'apolices.emitidas',
            'uses' => 'Backend\ApolicesController@emitidas']
    );

    Route::get('emitir', [
            'middleware' => 'permission:gesta-apolice',
            'as' => 'apolices.aemitir',
            'uses' => 'Backend\ApolicesController@aemitir']
    );

    Route::get('apolices', [
        'middleware' => ['permission:gesta-apolice'],
        'as' => 'gestao.apolices',
        'uses' => 'Backend\GestaoController@apolices']);

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
});
Route::group(['prefix' => 'cotacao', 'middleware' => 'auth'], function () {


    Route::post('gerar', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.gerar',
        'uses' => 'Backend\CotacaoController@gerar']);

    Route::get('/', [

        'middleware' => ['permission:vendas-negociacoes'],
        'as' => 'vendas.negociacoes',
        'uses' => 'Backend\CotacaoController@cotacoes']);

    Route::get('/vencidas', [

        'middleware' => ['permission:vendas-negociacoes'],
        'as' => 'cotacao.vencidas',
        'uses' => 'Backend\CotacaoController@vencidas']);


    Route::get('reemitir/{cotacao_id}', [
        'middleware' => ['permission:vendas-negociacoes-negociar'],
        'as' => 'cotacao.reemitir',
        'uses' => 'Backend\CotacaoController@reemitir']);


    Route::get('cotar', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'cotacao.cotar',
        'uses' => 'Backend\CotacaoController@index'
    ]);


    Route::get('cotacao/sucesso/{idcotacao}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.sucesso',
        'uses' => 'Backend\CotacaoController@sucesso']);


    Route::post('cotacao/salvar', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.salvar',
        'uses' => 'Backend\CotacaoController@salvar'
    ]);
    
    Route::post('sendemail', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'cotacao.sendemail',
        'uses' => 'Backend\CotacaoController@sendEmail'
    ]);


    Route::get('pdf/{cotacao_id}', [
        'middleware' => ['permission:vendas-cotacao-pdf'],
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf_cotacao'
    ]);
    
    Route::get('email/{cotacao_id}', [
        'middleware' => ['permission:vendas-cotacao-pdf'],
        'as' => 'cotacao.showemail',
        'uses' => 'Backend\CotacaoController@showEmail'
    ]);


});


Route::group(['prefix' => 'proposta', 'middleware' => 'auth'], function () {
    Route::get('emitir/{cotacao_id}', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'proposta.index',
        'uses' => 'Backend\PropostaController@index'
    ]);

    Route::post('emitir', [
        'middleware' => ['permission:vendas-cotacao'],
        'as' => 'proposta.emitir',
        'uses' => 'Backend\PropostaController@emitir'
    ]);

    Route::get('sucesso/{proposta_id}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'proposta.sucesso',
        'uses' => 'Backend\PropostaController@sucesso']);

    Route::get('pdf/{proposta_id}', [
        'middleware' => ['permission:vendas-cotacao-gerar'],
        'as' => 'proposta.pdf',
        'uses' => 'Backend\PropostaController@pdf']);

    route::get('acompanhamento', [
        'middleware' => 'permission:proposta-acompanhamento',
        'as' => 'proposta.acompanhamento',
        'uses' => 'Backend\PropostaController@acompanhamento'
    ]);
    
    route::get('negativas', [
        'middleware' => 'permission:proposta-acompanhamento',
        'as' => 'proposta.negativas',
        'uses' => 'Backend\PropostaController@negativas'
    ]);
});


Route::group(['prefix' => 'gestao', 'middleware' => 'auth'], function () {


    Route::get('aprovacao', [
        'middleware' => ['permission:gesta-aprovacao'],
        'as' => 'gestao.aprovacao',
        'uses' => 'Backend\GestaoController@aprovacao']);


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


Route::group(['prefix' => 'home', 'middleware' => 'auth'], function () {

    Route::get('alterar', [
        'as' => 'backend.homepage',
        'middleware' => 'permission:homepage-edit',
        'uses' => 'Backend\HomePageController@altera_get']);

    Route::post('alterar', [
        'as' => 'backend.altera',
        'middleware' => 'permission:homepage-edit',
        'uses' => 'Backend\HomePageController@altera_post']);

    Route::get('alterar/{type_id}', [
        'as' => 'homepage.modal',
        'middleware' => 'permission:homepage-edit',
        'uses' => 'Backend\HomePageController@modal']);

    Route::get('delete/{type_id}', [
        'as' => 'homepage.delete',
        'middleware' => 'permission:homepage-edit',
        'uses' => 'Backend\HomePageController@delete']);

});
//
//Route::get('/', function () {
//    return view('welcome');
//});


