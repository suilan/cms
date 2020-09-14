<?php 
namespace Ielop\Ieptbma\Controllers;

use Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\SiteContato;

class ContatoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('ieptbma::contato');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$return = array();
		// A propria controller ja trata a validação, se falhar, 
		//ela mesma faz o redirect para a pagian anterior
		$validator = Validator::make( $request->all(), $this->validationRules(), $this->validationMessages() );

		if ( !$validator->fails() ) {
			// Se não houver falhasS
			$registro = new SiteContato;
			$registro->nome = Input::get('nome');
			$registro->email = Input::get('email');
			$registro->assunto = Input::get('assunto');
			$registro->mensagem = Input::get('mensagem');
			$registro->save();

			return redirect('contato')->with('success', true);
		}
	}

	// PRIVATE METHODS
	private function validationRules(){
		$rules = [
	        'nome' => 'required|max:255',
	        'email' => 'required|max:255',
	        'assunto' => 'required|max:255',
	        'mensagem' => 'required|max:300'
//	        'newsletter'=>'required|boolean'
	    ];

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	        'nome.required' => 'O nome é Obrigatório',
	        'email.required'  => 'O email é obrigatório',
	        'assunto.required'  => 'O assunto é obrigatório',
	        'mensagem.required'  => 'A mensagem é obrigatória',
	    ];
	}

}
