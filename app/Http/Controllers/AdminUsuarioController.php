<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Cartorio;
use App\Cidade;
use App\Perfil;
use App\Permissao;

use App\VerifyUser;
use App\Mail\VerifyMail;

use Illuminate\Support\Facades\Mail;

use Auth;
use Input;
use Redirect;
use Hash;
use DB;
use Carbon\Carbon;

class AdminUsuarioController extends Controller {


	public function __construct()
	{
		view()->share('page_title','Usuários');
		view()->share('page_description','Edição, criação e exclusão de usuários');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$authUser = Auth::user();

		if( Input::get('pesquisar') ){
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

			$users = User::orWhere(DB::raw('replace(replace(replace(cpf,".",""),"-",""),"/","")'),$pesquisar)
						   ->orWhere('cpf',$pesquisar)
			               ->orWhere('name','like',$pesquisar)->paginate(10);
		}else{
			
			if ( $authUser->papel_id == 8 ){
				$users = User::where('id','=',$authUser->id)->paginate(10);
			}
			else if ( $authUser->papel_id!=1 ){
				$users = User::where('cartorio_id','=',$authUser->cartorio_id)->paginate(10);
			}
			else{
				$users = User::paginate(10);
			}
		}

		$users->setPath('usuarios');

		return view('admin.users.home')
			->with('users',$users)
			->with('perfis',Perfil::pluck('nome','id'))
			->with('currentUser',$authUser->id);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$authUser = Auth::user();
		if( $authUser->papel_id!=1 ){
			$cartorio = Cartorio::where('id', $authUser->cartorio_id )->first();
		}
		else $cartorio = Cartorio::orderBy('nome', 'asc')->get();

		$usuario = new User;  

		// Block profile roles to lower roles
		if($authUser->papel_id>1)  
			$perfis = Perfil::where('id','>',$authUser->papel_id)->get();
		else $perfis = Perfil::get();

        return view('admin.users.editar')
        	   ->with('registro',$usuario)
        	   ->with('cartorio',$cartorio)
        	   ->with('loggedUser',$authUser)
        	   ->with('isAdmin',$authUser->papel_id==1?true:false)
        	   ->with('perfis', $perfis);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $retorno)
	{
		// Validate fields and if not 
		$loggedUser = Auth::user();
		$this->validate( $retorno, $this->validationRules(), $this->validationMessages() );
		
		$senha = Input::get('senha');

		$ibgeId = Input::get('cidadeUsuarioIBGE');

		$user = new User;
		$user->name = Input::get('name');
		$user->email = Input::get('email');

		if( $senha ){
			$user->password = Hash::make(Input::get('senha'));
		}
		$user->cpf = Input::get('cpf');
		$user->cep = Input::get('cep');
		$user->endereco = Input::get('usuarioEndereco');
		$user->bairro = Input::get('usuarioBairro');
		$user->numero = Input::get('usuarioNumero');
		$user->complemento = Input::get('usuarioComplemento');
		$user->telefone = Input::get('telefone');
		$user->celular1 = Input::get('celular1');
		$user->celular2 = Input::get('celular2');
		$user->papel_id = Input::get('perfil');
		
		if($ibgeId)
		$user->cidade_id = Cidade::where('ibge',Input::get('cidadeUsuarioIBGE'))->first()->id;

		if($loggedUser->papel_id==1)
		$user->cartorio_id = Input::get('cartorio');
		else $user->cartorio_id = $loggedUser->cartorio_id;

		$user->save();

		$verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
        Mail::to($user->email)->send(new VerifyMail($user));

		return redirect('admin/usuarios/'.$user->id.'/edit')
			->with('sucesso',true);	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::where('users.id',$id)
		   ->leftJoin('cidades','cidades.id','=','users.cidade_id')
		   ->leftJoin('cartorios','cartorios.id','=','users.cartorio_id')
		   ->leftJoin('papeis','papeis.id','=','users.papel_id')
		   ->select('cartorios.nome as cartorio','cidades.nome as cidade',
		   		'cidades.uf as uf','papeis.nome as perfil','users.*')
		   ->first();

		$permissoes = Permissao::join('papeis','papeis.id','=','permissoes.papel_id')
			->join('paginas','paginas.id','=','permissoes.pagina_id')
			->where('papeis.nome','=',$user->perfil)
			->where('paginas.status','=',1)
			->where('paginas.admin','=',1)
			->select('paginas.nome','paginas.pai')
			->get();					

		return view('admin.users.visualizar')
			->with('permissoes',$permissoes)
			->with('usuario',$user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$authUser = Auth::user();
		if( $authUser->papel_id!=1){
			$cartorio = Cartorio::where('id', $authUser->cartorio_id )->first();
		}
		else $cartorio = Cartorio::get();
		
		// Block profile roles to lower roles
		if($authUser->papel_id>2)  
			$perfis = Perfil::where('id','>=',$authUser->papel_id)->get();
		else $perfis = Perfil::get();

		$user = User::leftJoin('cartorios','cartorios.id','=','users.cartorio_id')
			  ->leftJoin('cidades','cidades.id','=','users.cidade_id')
			  ->select('cidades.nome as cidade','cidades.ibge as ibge','cartorios.nome as cartorio','users.*')
			  ->where('users.id',$id)->first();

		return view('admin.users.editar')
			->with('perfis',$perfis)
			->with('cartorio',$cartorio)
        	->with('loggedUser',$authUser)
        	->with('isAdmin',$authUser->papel_id==1?true:false)
			->with('registro',$user);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $retorno)
	{
		$this->validate( $retorno, $this->validationRules(true), $this->validationMessages() );

		$loggedUser = Auth::user();
		$senha = Input::get('senha');
		$idCidade = Cidade::where('ibge',Input::get('cidadeUsuarioIBGE'))->get()->toArray();

		$user = User::find($id);

		$user->name = Input::get('name');
		$user->email = Input::get('email');
		if( $senha ){
			$user->password = Hash::make(Input::get('senha'));
		}
		$user->cpf = Input::get('cpf');
		$user->cep = Input::get('cep');
		$user->endereco = Input::get('usuarioEndereco');
		$user->bairro = Input::get('usuarioBairro');
		$user->numero = Input::get('usuarioNumero');
		$user->complemento = Input::get('usuarioComplemento');
		$user->telefone = Input::get('telefone');
		$user->celular1 = Input::get('celular1');
		$user->celular2 = Input::get('celular2');
		$user->cidade_id = $idCidade[0]['id'];

		if($loggedUser->papel_id==1)
		    $user->cartorio_id = Input::get('cartorio');
		else $user->cartorio_id = $loggedUser->cartorio_id;

		if($id!=1 && $id!=12) 
			$user->papel_id = Input::get('perfilId');

		if( Input::get('senha') )
		{
			$user->password = Hash::make( Input::get('senha') );
		}

		$user->save();

		return redirect('admin/usuarios/'.$user->id.'/edit')
			->with('sucesso',true);	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( $id!=Auth::user()->id )
		{			
			User::find($id)->delete();
	   		return redirect('admin/usuarios')->with('sucesso',true);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function aceitarTermos($aceite, Request $request) {
		if($aceite = 1){
			$user = User::find(Auth::user()->id);
			$user->adesao_at = Carbon::now()->setTimezone('America/Fortaleza')->toDateTimeString();
			
			$user->save();
			
			return redirect('admin/usuarios')->with('aceite',true);
		} else {
			Auth::logout();
			return redirect('admin/login');
		}
	}

	// PRIVATE METHODS
	private function validationRules( $edit= false){
		$rules = [
	        'name' => 'required|max:255',
	        'email' => 'required',
	        'confirmaSenha' => 'same:senha',
	        'celular1' => 'required',
	    ];

	    if( !$edit )
	    {
	    	$rules['senha'] = 'required';
	    	$rules['confirmaSenha'] = 'required|same:senha';
	    }

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	        'name.required' => 'O Nome é Obrigatório',
	        'email.required'  => 'O E-mail é obrigatorio',
	        'senha.required'  => 'A Senha é obrigatória',
	        'email.unique'  => 'Este e-mail já se encontra cadastrado em nosso sistema',
	        'celular1.required'  => 'O Celular 1 é obrigatório',
	        'confirmaSenha.required' => 'Confirmação de senha é obrigatório',
	        'senha.required'  => 'A Senha é obrigatória',
	        'confirmaSenha.same' => 'Confirmação de senha inválida',
	    ];
	}

	public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "E-mail verificado com sucesso. Agora você está apto para acessar o sistema.";
            }else{
                $status = "Seu E-mail já foi verificado. Você está apto para acessar o sistema.";
            }
        }else{
            return redirect('admin/login')->with('status', "Descuple, e-mail não identificado.");
        }
        return redirect('admin/login')->with('status', $status);
	}
	
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('admin/login')->with('status', 'Foi enviado um e-mail para validação da sua conta. Por favor, cheque seu e-mail e clique no link para verificar.');
    }

}
