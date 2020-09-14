<?php 
namespace Ielop\Ieptbma\Controllers;

use Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ProtOnline;
use Mail;

class ProtOnlineController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('ieptbma::protonline');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$registro = new ProtOnline;
		$registro->razao = Input::get('razao');
		$registro->cnpj = Input::get('cnpj');
		$registro->nome = Input::get('nomeResp');
		$registro->email = Input::get('email');
		$registro->contato = Input::get('telefone');
		$registro->whatsapp = Input::get('whatsapp');
		$registro->celular = Input::get('celular');
		$registro->segmento = Input::get('segmento');
		$registro->tipo_protesto = implode(",",Input::get('tipoProtesto'));
		$registro->qtd_titulos = Input::get('qtdTitulos');
		$registro->mensagem = Input::get('mensagem');
		$registro->save();

		Mail::send('emails.protonline',["dados"=>$registro],function($email) use ($registro){
			$email->from('contatoieptbma@gmail.com','Protesto Online - Contato');
			$email->subject('Protesto Online - Contato');
			$email->to('contatoieptbma@gmail.com');
		});

		return redirect('protonline')->with('status', 'Mensagem enviada com sucesso. Em breve entraremos em contato. Obrigado!');
	}
}
