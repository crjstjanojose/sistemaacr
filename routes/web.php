<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
*/

use App\Mail\SolicitacaoMail;

Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    } else {
        return view('paginas.usuarios.login');
    }
})->name('login');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login', 'Admin\UsuarioController@loginView')->name('login');
Route::post('login', 'Admin\UsuarioController@login')->name('login');

Route::prefix('admin')->middleware('auth')->namespace('Admin')->group(function () {

        Route::post('logout', 'UsuarioController@logout')->name('logout');
        Route::get('/alterarsenha', 'UsuarioController@viewAlterarSenha')->name('alterar.senha');
        Route::post('/alterarsenhaatual', 'UsuarioController@updateSenha')->name('usuario.update.senha');

        // ROTAS DOS DATABLES INDEX
        Route::get('produtosindex',"ProdutoController@indexDatatable")->name('produtos.table.index');
        Route::get('usersindex',"UsuarioController@indexDatatable")->name('usuarios.table.index');
        Route::get('permissionsindex',"PermissionController@indexDatatable")->name('permissions.table.index');
        Route::get('rolessindex',"RoleController@indexDatatable")->name('roles.table.index');

        Route::get('encomendassindex',"EncomendaController@indexDatatablePendentes")->name('encomendas.pendentes.table.index');
        Route::get('caracteristicasindex',"CaracteristicaController@indexDatatable")->name('caracteristicas.table.index');

        Route::get('indexsolicitadas',"EncomendaController@indexSolicitadas")->name('encomendas.index.solicitadas');
        Route::get('encomendassindexsolicitadas',"EncomendaController@indexDatatablesSolicitadas")->name('encomendas.solicitadas.table.index');

        Route::get('indexentregues',"EncomendaController@indexEntregues")->name('encomendas.index.entregues');
        Route::get('encomendassindexentregues',"EncomendaController@indexDatatablesEntregues")->name('encomendas.entregues.table.index');

        // SOLICITACAO MATERIAL
        Route::get('indexmateriais',"MaterialController@indexMateriais")->name('index.materiais');

        Route::get('indexmateriaissolicitadas',"MaterialController@indexAtendidas")->name('index.atendidas');
        Route::get('indexmateriaissolicitadastable',"MaterialController@indexMateriaisSolicitadas")->name('index.materiais.atendidas');

        // FIM ROTAS DOS DATABLES INDEX



        Route::get('indexclientes',"ClienteController@indexClientes")->name('index.clientes');

        Route::get('indexaplicacoes',"AplicacaoController@indexAplicacoes")->name('index.aplicacoes');


        // ROTA PARA CARREGAR OS PRODUTOS NA TELA DE ENCOMENDAS
        Route::post('/produtos/getProdutos/','EncomendaController@getProdutosSelect')->name('produtos.getprodutos.select');
        Route::post('/clientes/getClientes/','ClienteController@getClientesSelect')->name('clientes.getclientes.select');

        // ROTAS DE IMPORTACAO DOS PRODUTOS
        Route::post('produtos/importar', 'ProdutoController@importarArquivo')->name('produtos.importar');
        Route::get('produtos/importarview', 'ProdutoController@importarArquivoView')->name('produtos.importar.view');
        // FIM ROTAS DE IMPORTACAO DOS PRODUTOS

        // ROTAS DE PERMISSÃO DE ACESSO

        // ROTAS DE PERMISSÃO DE ACESSO DO USUARIO
        Route::get('adicionapermissao/{user}', 'UsuarioController@viewAdicionaPermissaoUsuario')->name('adiciona.permissao.usuario');
        Route::post('adicionapermissao/{user}', 'UsuarioController@adicionaPermissaoUsuario')->name('adiciona.permissao.usuario');
        Route::get('removepermissao/{user}', 'UsuarioController@viewRemovePermissaoUsuario')->name('remove.permissao.usuario');
        Route::post('removepermissao/{user}', 'UsuarioController@removePermissaoUsuario')->name('remove.permissao.usuario');


        // ROTAS DE PERMISSAO DE ACESSOS DO GRUPO
        Route::get('adicionapermissaogrupo/{role}', 'RoleController@viewAdicionaPermissaoGrupo')->name('adiciona.permissao.grupo');
        Route::post('adicionapermissaogrupo/{role}', 'RoleController@adicionaPermissaoGrupo')->name('adiciona.permissao.grupo');
        Route::get('removepermissaogrupo/{role}', 'RoleController@viewRemovePermissaoGrupo')->name('remove.permissao.grupo');
        Route::post('removepermissaogrupo/{role}', 'RoleController@removePermissaoGrupo')->name('remove.permissao.grupo');

        // ROTAS DE PERMISSÃO DO USUARIO E GRUPO
        Route::get('adicionausuariogrupo/{role}', 'RoleController@viewAdicionaUsuarioGrupo')->name('adiciona.usuario.grupo');
        Route::post('adicionausuariogrupo/{role}', 'RoleController@adicionaUsuarioGrupo')->name('adiciona.usuario.grupo');
        Route::get('removeusuariogrupo/{role}', 'RoleController@viewRemoveUsuarioGrupo')->name('remove.usuario.grupo');
        Route::post('removeusuariogrupo/{role}', 'RoleController@removeUsuarioGrupo')->name('remove.usuario.grupo');

        // FIM ROTAS DE PERMISSÃO DE ACESSO


        // ROTA MULT SELECAO ENCOMENDAS
        Route::post('/multconfirmacompra', 'EncomendaController@confirmaMultiplasCompras')->name('encomendas.confirma.multiplas.compras');
        Route::post('/multcancelacompra', 'EncomendaController@cancelaMultiplasCompras')->name('encomendas.cancela.multiplas.compras');
        Route::post('/multentregar', 'EncomendaController@multEntregar')->name('encomendas.multiplas.entregar');
        Route::post('/multcancelaentrega', 'EncomendaController@cancelaMultiplasEntregas')->name('encomendas.cancela.multiplas.entregas');
        Route::post('/multconfirmaentregasolicitacao', 'MaterialController@multEntregar')->name('solicitacao.multiplas.entregar');
        Route::post('/multcancelasolicitacao', 'MaterialController@cancelaMultiplasCompras')->name('solicitacao.cancela.multiplas.compras');
        Route::post('/multisolicitacao', 'MaterialController@confirmaMultiplasSolicitacoes')->name('solicitacoes.confirma.multiplas');



        //Rotas Resources
        Route::resource('users', 'UsuarioController')->middleware('permission:usuario-listar');
        Route::resource('produtos', 'ProdutoController')->middleware('permission:produtos-listar');
        Route::resource('permissions', 'PermissionController')->middleware('permission:permissao-listar');
        Route::resource('roles', 'RoleController')->middleware('permission:grupos-listar');
        Route::resource('encomendas', 'EncomendaController')->middleware('permission:encomendas-listar-pendentes');
        Route::resource('caracteristicas', 'CaracteristicaController')->middleware('permission:caracteristica-listar');
        Route::resource('materiais','MaterialController')->middleware('permission:materiais-listar');
        Route::resource('clientes','ClienteController');
        Route::resource('aplicacoes','AplicacaoController');




});
