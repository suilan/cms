<?php 
namespace Ielop\Ieptbma\Controllers;

use Validator;
use Input;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Cidade;
use App\Newsletter;
use Hash;

class CadastroController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$uf = Cidade::groupBy('uf')
			->orderBy('uf')
			->get(array('uf'));

		$cidades = Cidade::orderBy('uf')
			->orderBy('nome')
			->get(array('uf','id','nome'));

		// var_dump($cidades);
		// exit;
		return view('site/cadastro')
			->with('cidades',$cidades)
			->with('uf',$uf);
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
 
		if ($validator->fails()) {
			$return['status']=$validator->errors()->all();
			return response(json_encode($return),200);
		}
		else{
			// Se não houver falhas
			$registro = new User;
			$registro->name = Input::get('nome');
			$registro->cpf = Input::get('cpf');
			$registro->cep = Input::get('cep');
			$registro->endereco = Input::get('endereco');
			$registro->numero = Input::get('numero');
			$registro->bairro = Input::get('bairro');
			$registro->complemento = Input::get('complemento');
			$registro->cidade_id = Input::get('cidade');
			$registro->papel_id = 2;
			$registro->telefone = Input::get('telefone');
			$registro->celular1 = Input::get('celular');
			$registro->email = Input::get('email');
			$registro->password = Hash::make(Input::get('senha'));
			// $registro->newsletter = Input::get('newsletter');
			$registro->save();

			$return['status']=1;

			if( Input::get('newsletter',false) ){
				$nl = new Newsletter;
				$nl->nome = $registro->name;
				$nl->email = $registro->email;
				$nl->save();
			}

			Auth::login($registro);

			return response(json_encode($return),200);
		}
	}


	// PRIVATE METHODS
	private function validationRules(){
		$rules = [
	        'nome' => 'required|max:255',
	        'cpf' => 'required|max:14',
	        'cep' => 'required|max:9',
	        'endereco' => 'required|max:255',
	        'numero' => 'required|max:255',
	        'bairro' => 'required|max:255',
	        'cidade' => 'required|numeric|exists:cidades,id',
	        'telefone' => 'required|max:14',
	        'celular' => 'required|max:15',
	        'email' => 'required|email|max:255|unique:users',
	        'senha' => 'required|max:255',
	        'confirma_senha' => 'required|max:255|same:senha',
	        'newsletter'=>'boolean'
	    ];

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	        'nome.required' => 'O nome é Obrigatório.',
	        'nome.max'  => 'O CPF deve ter no máximo 255 caracteres.',
	        'cpf.required'  => 'O CPF é obrigatorio.',
	        'cpf.max'  => 'O CPF deve ter no máximo 14 caracteres.',
	        'cep.required'  => 'O CEP é obrigatorio.',
	        'cep.max'  => 'O CEP deve ter no máximo 9 caracteres.',
	        'endereco.required'  => 'O endereço é obrigatorio',
	        'endereco.max'  => 'O endereço deve ter no máximo 255 caracteres.',
	        'numero.required'  => 'O número é obrigatorio',
	        'bairro.required'  => 'O bairro é obrigatorio',
	        'bairro.max'  => 'O bairro deve ter no máximo 255 caracteres.',
	        'cidade.required'  => 'A cidade é obrigatória.',
	        'cidade.numeric'  => 'O campo cidade é numérico.',
	        'cidade.exists'  => 'A cidade informada não está cadastrada.',
	        'telefone.required'  => 'O telefone é obrigatório.',
	        'telefone.max'  => 'O telefone deve ter no máximo 14 caracteres.',
	        'celular.required'  => 'O celular é obrigatório.',
	        'celular.max'  => 'O celular deve ter no máximo 15 caracteres.',
	        'email.required'  => 'O e-mail é obrigatório.',
	        'email.email'  => 'O e-mail não é válido.',
	        'email.max'  => 'O e-mail deve ter no máximo 255 caracteres.',
	        'senha.required'  => 'A senha é obrigatória.',
	        'confirma_senha.required'  => 'A confirmação de senha é obrigatoria',
	    ];
	}

}
