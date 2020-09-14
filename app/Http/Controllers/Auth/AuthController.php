<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Permissao;
use App\Mail\RecoveryPassword;
use App\User;

use Input;
use Hash;
use Mail;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	// use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * OVERLOAD of AuthenticatesAndRegistersUsers
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{   
		$this->validate($request, [
			'email' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		$user = User::where("cpf", "=", $credentials['email'])->first();

		if ($user &&  Hash::check($credentials['password'], $user->password)){	
			Auth::login($user); //efetuando a operação de autenticação

			if (Auth::user()->verified == 0) {
				Auth::logout();
				return back()->with('warning', 'Você precisa confirmar sua conta. Foi enviado um código de veridicação para você. Por favor, cheque seu e-mail.');
			}
				
			// Pega a primeira página com permissão
			$pagina = Permissao::join('papeis','papeis.id','=','permissoes.papel_id')
				->join('paginas','paginas.id','=','permissoes.pagina_id')
				->where('papeis.id','=',Auth::user()->papel_id)
				->where('paginas.status','=',1)
				->where('paginas.admin','=',1)
				->select('paginas.caminho')
				->orderBy('paginas.ordem')
				->first();
			echo $pagina;

			return redirect()->intended($pagina->caminho);
		} else {
			if (Auth::attempt($credentials, $request->has('remember'))) {
				if (Auth::user()->verified == 0) {
					Auth::logout();
					return back()->with('warning', 'Você precisa confirmar sua conta. Foi enviado um código de veridicação para você. Por favor, cheque seu e-mail.');
				}
					
				// Pega a primeira página com permissão
				$pagina = Permissao::join('papeis','papeis.id','=','permissoes.papel_id')
					->join('paginas','paginas.id','=','permissoes.pagina_id')
					->where('papeis.id','=',Auth::user()->papel_id)
					->where('paginas.status','=',1)
					->where('paginas.admin','=',1)
					->select('paginas.caminho')
					->orderBy('paginas.ordem')
					->first();

				return redirect()->intended($pagina->caminho);
			}
		}

		// return redirect($this->loginPath()) // original
		return redirect($request->header('referer')) // Return to the called page 
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => 'Usuário e/ou senha inválido!', //novo
						// 'email' => $this->getFailedLoginMessage(), //antigo
					]);
	}

	public function getLogin(){
		return view('auth.login');
	}

	public function getLogout(){
		Auth::logout();
		return redirect('admin/login');
	}

	public function recoveryPassword (Request $request) {
		$remember_token = mt_rand(100000, 999999);

		$email = Input::get('email');
	
		$user = User::where("email", "=", $email)->first();
	
		if ($user){
			$user->remember_token = $remember_token;
			$user->save();
	
			Mail::to($user->email)->send(new RecoveryPassword($user));
	
			return redirect('admin/login')->with('status', 'Foi enviado token de verificação para o seu email. Acesse o seu E-mail para o procedimento de troca de senha');
		} else {
			return redirect('admin/login')->with('warning', 'O E-mail informado, não consta na base de dados do sistema. Por favor, Credencie-se.');
		}
	}

	public function novaSenha (Request $request) {

		$token = Input::get('token');
		$novopassword = Input::get('novopassword');
		$repetesenha = Input::get('repetesenha');

		$user = User::where('remember_token', $token)->first();

		if ($user && $novopassword == $repetesenha){
			$user->remember_token = Hash::make($novopassword);
			$user->password = Hash::make($novopassword);
			$user->save();
	
			return redirect('admin/login')->with('status', 'Sua Senha foi modificada com sucesso.');
		} else {
			return redirect('admin/login')->with('warning', 'As senhas e/ou token não conferem.');
		}
	}
}
