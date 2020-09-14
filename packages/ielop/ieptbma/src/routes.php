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
// The server name has to be define in the virtual host configuration
// Site
// echo "teste";
// exit;
$hosts = ['192.168.0.39','ieptbma.ielop','ieptbma.dev','ieptbma.com.br','www.ieptbma.com.br','protestoma.com.br','www.protestoma.com.br','127.0.0.1'];
// if( !isset($_SERVER['SERVER_NAME']) || in_array($_SERVER['SERVER_NAME'], $hosts) )
// {
	Session::put('projeto',"ieptbma");
	Route::get('/', 'Ielop\Ieptbma\Controllers\HomeController@index');
	Route::post('/', 'Ielop\Ieptbma\Controllers\HomeController@index');
	Route::resource('legislacao', 'Ielop\Ieptbma\Controllers\LegislacoesController');
	Route::get('protesto', function () { return view('ieptbma::protesto.protesto'); });
	Route::get('sobre', function () { return view('ieptbma::sobre'); });
	Route::get('quemsomos', function () { return view('site.quemsomos'); });

	Route::resource('busca','Ielop\Ieptbma\Controllers\BuscaController');
	Route::resource('/cartoriosma','Ielop\Ieptbma\Controllers\MapaCartorioController');
	Route::get('/cartoriosma/{municipio_id}','Ielop\Ieptbma\Controllers\MapaCartorioController@retornaCartorioMunicipio');
	Route::get('/cartoriosma/cartorio/{cartorio_id}','Ielop\Ieptbma\Controllers\MapaCartorioController@retornaCartorio');
	Route::get('/monitoramento', function () {
	    return view('site/monitoramento');
	});
	Route::get('/perguntas', function () {
	    return view('ieptbma::protesto.faq');
	});
	Route::get('busca', function () {
	    return view('ieptbma::busca');
	});
	Route::get('galeria', function () {
	    return view('ieptbma::galeria');
	});
	
	Route::group(['middleware' => 'web'], function () {
		Route::get('impressaosegundavia', 'Ielop\Ieptbma\Controllers\AdminSegundaViaController@segundaviapublica');
		Route::resource('protonline', 'Ielop\Ieptbma\Controllers\ProtOnlineController');
	});

	// Rota para Links úteis
	Route::resource('downloads','Ielop\Ieptbma\Controllers\DownloadsController');
	Route::resource('contato','Ielop\Ieptbma\Controllers\ContatoController');
	Route::resource('modelos','Ielop\Ieptbma\Controllers\ModelosController');

	Route::resource('jornaldoprotestoma','Ielop\Ieptbma\Controllers\JornalProtestoController');
	Route::resource('jornais','Ielop\Ieptbma\Controllers\JornaisController');
	Route::resource('pesquisaedital','Ielop\Ieptbma\Controllers\PesquisaEditalController');

	Route::resource('noticias','Ielop\Ieptbma\Controllers\NoticiasController');
	Route::resource('eventos','Ielop\Ieptbma\Controllers\EventosController');
	Route::get('consulta-editais','Ielop\Ieptbma\Controllers\EditaisController@index');
	Route::get('consulta-editais/{id}/edital','Ielop\Ieptbma\Controllers\EditaisController@show');
	Route::get('consulta-editais/{id}/titulo','Ielop\Ieptbma\Controllers\EditaisController@getTitulo');
	Route::resource('pesquisapublica', 'Ielop\Ieptbma\Controllers\PesquisaPublicaController');
	// Route::resource('cadastro', 'Ielop\Ieptbma\Controllers\CadastroController');
// }
