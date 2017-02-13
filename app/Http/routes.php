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




Route::get('/certificado/{idproposta}', ['as' => 'certificado', 'uses' => 'Backend\ApolicesController@index']);

Route::group(['prefix' => 'grupos', 'middleware' => ['permission:setup-grupo-altera']], function () {
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

            'middleware' => ['permission:setup-usuarios'],
            'as' => 'usuarios.gestao',
            'uses' => 'Backend\UserController@index'
        ]
    );
    Route::get('search/{searchterm?}', [

            'middleware' => ['permission:setup-usuarios'],
            'as' => 'usuarios.search',
            'uses' => 'Backend\UserController@search'
        ]
    );

    Route::get('/alterstatus/{iduser}', [
            'middleware' => ['permission:setup-usuarios'],
            'as' => 'usuarios.alterstatus',
            'uses' => 'Backend\UserController@alterStatus'
        ]
    );
    Route::get('/tipos/{iduser}', [
            'middleware' => ['permission:setup-usuarios'],
            'as' => 'usuarios.tipos',
            'uses' => 'Backend\UserController@tipos'
        ]
    );
    Route::post('/alteratipos', [
            'middleware' => ['permission:setup-usuarios'],
            'as' => 'usuarios.alteratipos',
            'uses' => 'Backend\UserController@alteratipos'
        ]
    );

});


Route::group(['prefix' => 'apolices', 'middleware' => 'auth'], function () {



    Route::get('emitir', [
        'middleware' => 'permission:apolices-emitir',
        'as' => 'apolices.aemitir',
        'uses' => 'Backend\ApolicesController@aemitir']);
    Route::post('emitir', [
        'middleware' => ['permission:apolices-emitir'],
        'as' => 'apolices.emitir',
        'uses' => 'Backend\ApolicesController@emitir']);
    Route::get('emitir/show/{idproposta}', [
        'middleware' => ['permission:apolices-emitir'],
        'as' => 'apolices.show',
        'uses' => 'Backend\ApolicesController@showModal']);

    Route::get('emitidas', [
        'middleware' => 'permission:apolices-emitdas',
        'as' => 'apolices.emitidas',
        'uses' => 'Backend\ApolicesController@emitidas']    );
    Route::get('emitidas/email/{idproposta}', [
        'middleware' => ['permission:apolices-emitdas'],
        'as' => 'apolices.email',
        'uses' => 'Backend\ApolicesController@email']);
    Route::get('emitidas/showemitidas/{idproposta}', [
        'middleware' => ['permission:apolices-emitdas'],
        'as' => 'apolices.showemiditas',
        'uses' => 'Backend\ApolicesController@showModalApolices']);
    Route::post('emitidas/download', [
        'middleware' => ['permission:apolices-emitdas'],
        'as' => 'apolices.download',
        'uses' => 'Backend\ApolicesController@download']);

    Route::get('apolices', [
        'middleware' => ['permission:gesta-apolice'],
        'as' => 'gestao.apolices',
        'uses' => 'Backend\GestaoController@apolices']);    
    
    Route::get('canceladas/', [
        'middleware' => ['permission:apolices-canceladas'],
        'as' => 'apolices.canceladas',
        'uses' => 'Backend\ApolicesController@canceladas']);
    Route::get('cancela/{id}', [
        'middleware' => ['permission:apolices-canceladas'],
        'as' => 'apolices.cancela',
        'uses' => 'Backend\ApolicesController@cancela']);
    Route::post('cancelar/', [
        'middleware' => ['permission:apolices-canceladas'],
        'as' => 'apolices.cancelar',
        'uses' => 'Backend\ApolicesController@cancelar']);
   
    Route::get('/certificado/update/{id}', 
        ['middleware' => ['permission:apolices-emitir'],
         'as' => 'certificado.pdf.update',
         'uses' => 'Backend\CertificadoController@updatePDF']);


});


Route::group(['prefix' => 'cotacao', 'middleware' => 'auth'], function () {


    Route::get('/', [

        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'vendas.negociacoes',
        'uses' => 'Backend\CotacaoController@cotacoes']);

    Route::get('/cotacaoAjax', [

        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'cotacao.ajaxativas',
        'uses' => 'Backend\CotacaoController@cotacoesAjax']);

    Route::get('/vencidas', [

        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'cotacao.vencidas',
        'uses' => 'Backend\CotacaoController@vencidas']);


    Route::get('reemitir/{cotacao_id}', [
        'middleware' => ['permission:cotacao-nova'],
        'as' => 'cotacao.reemitir',
        'uses' => 'Backend\CotacaoController@reemitir']);


    Route::get('cotar', [
        'middleware' => ['permission:cotacao-nova'],
        'as' => 'cotacao.cotar',
        'uses' => 'Backend\CotacaoController@index'
    ]);


    Route::get('sucesso/{idcotacao}', [
        'middleware' => ['permission:cotacao-nova'],
        'as' => 'cotacao.sucesso',
        'uses' => 'Backend\CotacaoController@sucesso']);


    Route::post('salvar', [
        'middleware' => ['permission:cotacao-nova'],
        'as' => 'cotacao.salvar',
        'uses' => 'Backend\CotacaoController@salvar'
    ]);

    Route::post('sendemail', [
        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'cotacao.sendemail',
        'uses' => 'Backend\CotacaoController@sendEmail'
    ]);


    Route::get('pdf/{cotacao_id}', [
        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'cotacao.pdf',
        'uses' => 'Backend\CotacaoController@pdf_cotacao'
    ]);

    Route::get('email/{cotacao_id}', [
        'middleware' => ['permission:cotacao-gestao'],
        'as' => 'cotacao.showemail',
        'uses' => 'Backend\CotacaoController@showEmail'
    ]);

});


Route::group(['prefix' => 'proposta', 'middleware' => 'auth'], function () {

    Route::get('emitir/{cotacao_id}', [
        'middleware' => ['permission:proposta-emitir'],
        'as' => 'proposta.index',
        'uses' => 'Backend\PropostaController@index'
    ]);

    Route::post('emitir', [
        'middleware' => ['permission:proposta-emitir'],
        'as' => 'proposta.emitir',
        'uses' => 'Backend\PropostaController@emitir'
    ]);
    Route::get('sucesso/{proposta_id}', [
        'middleware' => ['permission:proposta-emitir'],
        'as' => 'proposta.sucesso',
        'uses' => 'Backend\PropostaController@sucesso']);

    Route::get('pdf/{proposta_id}', [
        'middleware' => ['permission:proposta-gestao'],
        'as' => 'proposta.pdf',
        'uses' => 'Backend\PropostaController@pdf']);

    route::get('acompanhamento', [
        'middleware' => 'permission:proposta-gestao',
        'as' => 'proposta.acompanhamento',
        'uses' => 'Backend\PropostaController@acompanhamento'
    ]);
    route::get('negativas', [
        'middleware' => 'permission:proposta-gestao',
        'as' => 'proposta.negativas',
        'uses' => 'Backend\PropostaController@negativas'
    ]);

    Route::get('/{idproposta}', [
        'middleware' => ['permission:proposta'],
        'as' => 'show.proposta',
        'uses' => 'Backend\ShowsController@proposta']);

    Route::get('cancela/{id}', [
        'middleware' => ['permission:apolices-canceladas'],
        'as' => 'proposta.cancela',
        'uses' => 'Backend\PropostaController@cancela']);
    Route::post('cancelar/', [
        'middleware' => ['permission:apolices-canceladas'],
        'as' => 'proposta.cancelar',
        'uses' => 'Backend\PropostaController@cancelar']);

});


Route::group(['prefix' => 'cobranca', 'middleware' => 'auth'], function () {


    Route::get('agendar', [
        'middleware' => ['permission:cobranca-agendar'],
        'as' => 'cobranca.agendar',
        'uses' => 'Backend\GestaoController@cobranca']);
    Route::post('agendar', [
        'middleware' => ['permission:cobranca-agendar'],
        'as' => 'cobranca.salvarpga',
        'uses' => 'Backend\GestaoController@salvarpagamento']);
    Route::get('agenda/{idproposta}', [
        'middleware' => ['permission:cobranca-agendar'],
        'as' => 'show.pagamento',
        'uses' => 'Backend\ShowsController@pagar']);
    Route::get('pagamento/recusar/{idproposta}', [
        'middleware' => ['permission:cobranca-recusar'],
        'as' => 'cobranca.recusar',
        'uses' => 'Backend\GestaoController@recusapagamento']);

    Route::get('aprovar', [
        'middleware' => ['permission:cobranca-aprovar'],
        'as' => 'cobranca.aprovar',
        'uses' => 'Backend\GestaoController@aprovacao']);
    Route::get('cancela/{idproposta}', [
        'middleware' => ['permission:cobranca-cancelar'],
        'as' => 'show.cancelaproposta',
        'uses' => 'Backend\ShowsController@cancela']);
    Route::post('cancela', [
        'middleware' => ['permission:cobranca-cancelar'],
        'as' => 'cobranca.cancela',
        'uses' => 'Backend\GestaoController@cancelar']);
    Route::post('aprovar', [
        'middleware' => ['permission:cobranca-aprovar'],
        'as' => 'cobranca.confirmapg',
        'uses' => 'Backend\GestaoController@confirmapagamento']);
    Route::get('confirmar/{idproposta}', [
        'middleware' => ['permission:cobranca-aprovar'],
        'as' => 'show.confirmapgto',
        'uses' => 'Backend\ShowsController@confirmapgto']);

});


Route::group(['prefix' => 'home', 'middleware' => 'auth'], function () {

    Route::get('alterar', [
        'as' => 'backend.homepage',
        'middleware' => 'permission:setup-homepage',
        'uses' => 'Backend\HomePageController@altera_get']);

    Route::post('alterar', [
        'as' => 'backend.altera',
        'middleware' => 'permission:setup-homepage',
        'uses' => 'Backend\HomePageController@altera_post']);

    Route::get('alterar/{type_id}', [
        'as' => 'homepage.modal',
        'middleware' => 'permission:setup-homepage',
        'uses' => 'Backend\HomePageController@modal']);

    Route::get('delete/{type_id}', [
        'as' => 'homepage.delete',
        'middleware' => 'permission:setup-homepage',
        'uses' => 'Backend\HomePageController@delete']);

});

/*------------------------------------------------------------------------------------*/


Route::group(['prefix' => 'show', 'middleware' => 'auth'], function () {

    Route::get('segurado/{cpfcnpj}', [
        'middleware' => ['permission:segurado'],
        'as' => 'show.segurado',
        'uses' => 'Backend\ShowsController@segurado']);

});


Route::group(['prefix' => 'teste'], function () {
    Route::get('/', 'Backend\TesteController@index');
    Route::get('/mail', 'Backend\TesteController@mail');

    Route::get('/post', ['as' => 'post.teste',
        'uses' => 'Backend\TesteController@post_teste']);

});

Route::group(['prefix'=>'movimentos', 'middleware' => 'auth'],function(){
    Route::get('/emitidos',[
        'middleware'=>['permission:movimento'],
        'as'=>'movimentos.emitidos',
        'uses'=>'Backend\MovimentosController@emitidos']);
    Route::get('/cancelados',[
        'middleware'=>['permission:movimento'],
        'as'=>'movimentos.cancelados',
        'uses'=>'Backend\MovimentosController@cancelados']);
});

Route::group(['prefix'=>'segurados','middleware'=>'auth'],function (){
    Route::get('/edit/{id}',[
        'as'=>'segurado.edit',
        'uses'=>'Backend\SeguradoController@edit'
    ]);
    Route::get('/',[
        'as'=>'segurado.home',
        'uses'=>'Backend\SeguradoController@index'
    ]);
    Route::get('/loadmore',[
        'as'=>'segurado.loadmore',
        'uses'=>'Backend\SeguradoController@seguradoAjax'
    ]);
    Route::post('/update',[
        'as'=>'segurado.update_',
        'uses'=>'Backend\SeguradoController@update'
    ]);
    Route::get('/create',[
        'as'=>'segurado.create',
        'uses'=>'Backend\SeguradoController@create'
    ]);

});

Route::group(['prefix'=>'veiculos','middleware'=>'auth'],function (){
    Route::get('/edit/{id}',[
        'as'=>'veiculo.edit',
        'uses'=>'Backend\VeiculoController@edit'
    ]);
    Route::get('/',[
        'as'=>'veiculo.home',
        'uses'=>'Backend\VeiculoController@index'
    ]);

    Route::get('/loadmore',[
        'as'=>'veiculo.loadmore',
        'uses'=>'Backend\VeiculoController@veiculoAjax'
    ]);
    Route::post('/update',[
        'as'=>'veiculo.update_',
        'uses'=>'Backend\VeiculoController@update'
    ]);
    Route::get('/create',[
        'as'=>'veiculo.create',
        'uses'=>'Backend\VeiculoController@create'
    ]);

});