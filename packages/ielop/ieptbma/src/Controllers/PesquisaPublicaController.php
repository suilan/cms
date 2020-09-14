<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Input;

use App\Estado;
use App\ProtestoPdf;

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

use Illuminate\Support\Facades\Request;

class PesquisaPublicaController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function index()
	{
		// Define timexon to show the correct time 
		setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
	    $response = array('situacao'=>'INICIO');
        $estados = array();
        $cartorios = array();
	    $qtdProtestos = 0;

		// Get the state list to group the results per state
	    $estadoLista = Estado::lists('nome','codigouf');

		$consultaGratuita = Request::all();

		$code = Input::get('CaptchaCode');
		if( $code ) $isHuman = captcha_validate($code);
		else $isHuman=true;

		if( $isHuman && sizeof($consultaGratuita)>0 )
		{
			
			// Add a new service to the wrapper
	        SoapWrapper::add(function ($service) {
	            $service
	                ->name('ieptbma')
	                ->wsdl('http://www.ieptb.com.br/ws/serverTabelionatos.php?wsdl')
	                ->trace(true)                                                   // Optional: (parameter: true/false)
	                ->cache(WSDL_CACHE_BOTH)                                        // Optional: Set the WSDL cache
	                ->options(['login' => 'crama', 'password' => '4m5t6y', 'charset' => 'utf-8']);   // Optional: Set some extra options
	        });

	        $tipo_doc = '';
	        $documento = '';

	        if ($consultaGratuita['ident'] == 'CPF') {
	        	$tipo_doc = '1';
	        }else{
	        	$tipo_doc = '2';
	        }

	        $documento = str_replace( array( '-', '.', '/'), '', $consultaGratuita['identConsulta']);

	        $data = [
	            'tipo_doc'  => $tipo_doc,
	            'documento' => $documento
	        ];

	        // Using the added service
	        // he
	        SoapWrapper::service('ieptbma', function ($service) use ($data,&$response) {
	        	$result = simplexml_load_string(utf8_decode($service->call('consulta', $data)));

	        	// To convert the Simple XML objects to array
	        	$json = json_encode($result);
	        	$response = json_decode($json,true);
	        });

	        if ($response['situacao'] == 'CONSTA') {
	   	        foreach ($response['conteudo']['cartorio'] as $arr) {
	   	        	$index = substr($arr['codigo_cidade'],0,2);
					// var_dump($index);

	   	        	// Group the result per state
	   	        	if( !isset($cartorios[$estadoLista[$index]]) ){
	   	        		$cartorios[$estadoLista[$index]] = array();
	   	        	}
	   	        	$cartorios[$estadoLista[$index]][] = $arr;


	   	        	// Count per state
	   	        	if(isset($estados[$index])) $estados[$index] = $estados[$index] + $arr['protestos'];
	   	        	else $estados[$index]=$arr['protestos'];

	   	        	// Count all
		        	$qtdProtestos = $qtdProtestos + $arr['protestos'];
		        }
	        }
	        else $response['situacao'] == '';

	        var_dump($consultaGratuita['identConsulta']);
	        Session::put('pesquisa',json_encode($cartorios));
	        Session::put('documento',$consultaGratuita['identConsulta']);
	        Session::put('total', $qtdProtestos);

		}

		// var_dump($cartorios);
        return view('site/pesquisapublica')->with('data', $response)
        						      ->with('qtd_protestos',isset($qtdProtestos) ? $qtdProtestos : '0')
        						      ->with("isHuman",$isHuman)
        						      ->with("cartorios",$cartorios)
        							  ->with('estados',$estados);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Check cpf or cnpj
		$documento = Session::get('documento');
		if( strlen( $documento)>11 ){
			$documento = $this->mask($documento,'##.###.###/####-##');
		}
		elseif( strlen( $documento)>10 ){
			$documento = $this->mask($documento,'###.###.###-##');
		}

		// If has the variable pesquisa in session
		if( $documento && Session::has('pesquisa') )
		{
			$fpdf = new ProtestoPdf();
			$fpdf->header=1;
			$fpdf->AddPage();
			$fpdf->content( json_decode(Session::get('pesquisa'),true), 
				Session::get('total'), 
				$documento);
			$fpdf->Output();
			exit;
		}

	}

	private function mask($val, $mask)
	{
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++)
		{
			if($mask[$i] == '#'){
				if(isset($val[$k]))
				$maskared .= $val[$k++];
			}
			else{
				if(isset($mask[$i]))
				$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}

}
