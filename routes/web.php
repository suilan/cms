<?php
use App\User;
use App\ArquivoBoletoDet;
use App\DevedorContato;
use App\Devedor;
use App\Notifications\ProcessamentoTitulo;
use App\NotificacaoDevedor;
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

// Site
// Route::get('/', 'HomeController@index');
// Route::post('/', 'HomeController@index');
// Route::get('legislacao', function () { return view('new.legislacao'); });
// Route::get('protesto', function () { return view('new.protesto.protesto'); });
// Route::get('sobre', function () { return view('new.sobre'); });
// Route::get('quemsomos', function () { return view('site.quemsomos'); });

// Route::resource('busca','BuscaController');
// Route::get('/cartoriosma','MapaCartorioController@index');
// Route::get('/cartoriosma/{municipio_id}','MapaCartorioController@retornaCartorioMunicipio');
// Route::get('/cartoriosma/cartorio/{cartorio_id}','MapaCartorioController@retornaCartorio');
// Route::get('/monitoramento', function () {
//     return view('site/monitoramento');
// });
// Route::get('/perguntas', function () {
//     return view('new.protesto.faq');
// });
// Route::get('busca', function () {
//     return view('new.busca');
// });
// Route::get('galeria', function () {
//     return view('new.galeria');
// });

// // Rota para Links úteis
// Route::resource('downloads','DownloadsController');


// Route::resource('contato','ContatoController');
// Route::resource('noticias','NoticiasController');
// Route::resource('eventos','EventosController');
// Route::get('consulta-editais','EditaisController@index');
// Route::get('consulta-editais/{id}/edital','EditaisController@show');
// Route::get('consulta-editais/{id}/titulo','EditaisController@getTitulo');
// Route::resource('pesquisapublica', 'PesquisaPublicaController');
// Route::resource('cadastro', 'CadastroController');

// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);

// Páginas administrativas
// Adição do prefix 'admin' para as paginas do admin do site
Route::group(['prefix'=>'admin','middleware' => ['auth','acesso'] ], function(){
	Route::resource('eventos', 'AdminEventosController');
	
	/*Rota para donwload do PDF do boleto*/
	Route::get('segundavia/downloadPDF/{id}','AdminSegundaViaController@downloadPDF');	
	Route::resource('segundavia', 'AdminSegundaViaController');
	Route::get('segundaviapublica/{id}', 'AdminSegundaViaController@segundaviapublica');
	
	Route::resource('credenciamentoboleto', 'AdminCredeciamentoBoletoController');
	Route::get('credenciamentoboleto/{id}/{creden}/edit', 'AdminCredeciamentoBoletoController@edit');

	Route::resource('eventosinscritos', 'AdminEventoInscricaoController');
	Route::resource('credenciamento', 'AdminCredenciamentoEventoController');
	Route::resource('contatos', 'AdminSiteContatosController');

	//Noticias Galeria
	Route::resource('noticias', 'AdminNoticiasController');
	Route::get('noticias/{noticia_id}/galeria', 'AdminNoticiasGaleriaController@index');
	Route::post('noticias/{noticia_id}/galeria', 'AdminNoticiasGaleriaController@store');
	Route::any('noticias/{noticia_id}/galeria/destaque', 'AdminNoticiasGaleriaController@update');
	Route::get('noticias/{noticia_id}/galeria/youtube', 'AdminNoticiasGaleriaController@show');
	Route::get('noticias/{noticia_id}/galeria/{id}/delete', 'AdminNoticiasGaleriaController@destroy');

	Route::resource('tipocontatos', 'AdminTipoContatoController');
	Route::resource('cartorios', 'AdminCartorioController');
	Route::resource('carousel', 'AdminCarouselController');
	Route::resource('categoriaDownload', 'AdminCategoriaDownloadController');
	Route::resource('/', 'AdminHomeController');
	Route::resource('downloads', 'AdminDownloadsController');
	Route::resource('totem', 'AdminTotemController');
	Route::resource('legislacoes', 'AdminLegislacaoController');
	Route::resource('usuarios', 'AdminUsuarioController');
	Route::resource('perfil', 'AdminPerfilController');
	Route::resource('editais', 'AdminEditaisController');
	Route::resource('remessaboleto', 'AdminRemessaBoletoController');
	Route::get('editais/{id}/status', 'AdminEditaisController@getStatus');
	Route::resource('remessas', 'AdminRemessasController');
	Route::get('remessas/{id}/print', 'AdminRemessasController@getPrint');
	Route::get('remessas/{id}/status', 'AdminRemessasController@getStatus');
	Route::resource('titulos', 'AdminTitulosController');
	Route::get('titulos/devedor/{documento}', 'AdminTitulosController@getDevedor');
	Route::resource('endossos', 'AdminEndossosController');
	Route::resource('especies', 'AdminEspeciesController');
	Route::resource('galeria', 'AdminGaleriaImagemController');
	Route::resource('representante', 'AdminRepresentanteBoletoController');
	Route::resource('credenciamentorepresentante', 'AdminCredeciamentoRepresentanteController');
	Route::get('credenciamentorepresentante/{idUser}/{idEmpresa}', 'AdminCredeciamentoRepresentanteController@visualizar');
	Route::get('credenciamentorepresentante/{id}/{creden}/edit', 'AdminCredeciamentoRepresentanteController@alterar');

	Route::post('usuarios/{aceite}/aceite','AdminUsuarioController@aceitarTermos');

	// path to upload the assigned document
	Route::post('cartorios/upload', 'AdminCartorioController@postUpload');

	Route::get('404', function () {
	    return view('admin/404');
	});

	Route::get('credenciamentoboleto/verificaemail/{idUser}', 'AdminCredeciamentoBoletoController@enviaVerificacaoEmail');

	// Route::get('login', 'Auth\AuthController@getLogin')->name('login');
	// Route::post('login', 'Auth\AuthController@postLogin');
	// Route::get('logout', 'Auth\AuthController@getLogout');


});
// Rotas para o Excel
Route::get('downloadExcel/{type}', 'GeraExcelController@downloadExcel');
Route::get('downloadExcelCreden/{type}', 'GeraExcelController@downloadExcelCreden');
Route::get('downloadExcelCredenIntimacao/{type}', 'GeraExcelController@downloadExcelCredenIntimacao');
Route::get('downloadExcelCredenIntimacaoEmpresa/{type}', 'GeraExcelController@downloadExcelCredenIntimacaoEmpresa');
// Authentication routes...
Route::get('admin/login', 'Auth\AuthController@getLogin')->name('login');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');
Route::get('admin/senha', function(){
	return view('auth.password');
});
Route::get('admin/recuperasenha', function(){
	return view('auth.recuperasenha');
});
Route::post('admin/recoverypassword', 'Auth\AuthController@recoveryPassword');
Route::post('admin/novasenha', 'Auth\AuthController@novaSenha');
//Notificaation Route
Route::get('notification/1588818629048-919419537531', function () {
	$user = User::where('id',82)->first();

	$titulo = ArquivoBoletoDet::where('id',93325)->first();
	$user->notify(new ProcessamentoTitulo($titulo));
});

// Route::get('testeselect', function () {
// 	$devedores = Devedor::select("arquivo_remessa_boleto_dets.id as titulo_id", "devedores.id as devedor_id")
// 	->join("arquivo_remessa_boleto_dets","arquivo_remessa_boleto_dets.documento_sacado","=","devedores.documento")
// 	->where("arquivo_remessa_boleto_dets.id_arquivo_boleto",">",428)
// 	->whereRaw("
// 		not exists (
// 			select 0 from devedores n
// 			where n.documento = arquivo_remessa_boleto_dets.documento_sacado
// 			and exists (
// 				select 0 from devedor_contato dc
// 				where dc.devedor_id = n.id
// 				and dc.tipo_contato = 5
// 			)
// 		)
// 	")
// 	->whereRaw('STR_TO_DATE(arquivo_remessa_boleto_dets.vencimento_boleto,"%d%m%Y") >= now()')->get();

// 	return $devedores->count();
// });