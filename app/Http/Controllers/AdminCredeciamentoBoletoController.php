<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Cartorio;
use App\Perfil;
use App\Cidade;
use App\ImagemCredenciamento;

use App\Mail\VerifyMail;

use Illuminate\Support\Facades\Input;
use Auth;
use File;
use Mail;
use DB;
use Hash;
use App\Representante;

class AdminCredeciamentoBoletoController extends Controller {

	public function __construct(){
        view()->share('page_title','Credenciamento de usuários');
        view()->share('page_description','');
    }

    public function index(){
		$filter = intval(Input::get('startusCreden'));
		$filter2 = intval(Input::get('statusVencimento'));
		$filter3 = intval(Input::get('statusImpressao'));

        if( Input::get('pesquisar') ){
            $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

            $usuarioCredenciamento = User::orWhere(function($query) use ($pesquisar){
                $query->orWhere('cpf','like',$pesquisar)
                      ->orWhere('name','like',$pesquisar)
                      ->orWhere('email','like',$pesquisar)
                      ->orWhere(DB::raw('replace(replace(replace(cpf,".",""),"-",""),"/","")'),'like',$pesquisar);
            })->where('papel_id',8);
                
		} 
		elseif ($filter && $filter != 9) {
			if($filter < 5){
				if ($filter == 4) {
					$filter = 0;
				}
				$usuarioCredenciamento = User::where('papel_id',8)->where('creden', $filter);
			} else {
				if($filter == 5){
					$usuarioCredenciamento = User::where('papel_id',8)->whereNotNull('adesao_at');
				} else {
					$usuarioCredenciamento = User::where('papel_id',8)->whereNull('adesao_at');
				}
			}
		}
		else {
			$usuarioCredenciamento = User::where('papel_id',8);
		}
		
		// Vencimento
		if($filter2 && $filter2 != 9){
			$usuarioCredenciamento = $usuarioCredenciamento->whereRaw('
			    exists (
					select 0 from arquivo_remessa_boleto_dets ar
					where trim(ar.documento_sacado) = cpf
					and STR_TO_DATE(ar.vencimento_boleto,"%d%m%Y") '. ($filter2 == 1 ? '<' : '>=') .' now()
				)
			');
		}
		
		// impresso
		if ($filter3 && $filter != 9) {
			$usuarioCredenciamento = $usuarioCredenciamento->whereRaw('
			    exists (
					select 0 from arquivo_remessa_boleto_dets ar
					where trim(ar.documento_sacado) = cpf
					and ar.impresso '. ($filter3 == 1 ? 'is not null' : 'is null') .'
				)
			');
		}

		$usuarioCredenciamento = $usuarioCredenciamento->orderBy('created_at','desc')->paginate(10);
		$usuarioCredenciamento->setPath('credenciamentoboleto');

		return view('admin.credenciamentoboleto.home')
		->with('usuarioCredenciamento', $usuarioCredenciamento);
	}
	
	public function show($id)
	{
		$user = User::where('users.id',$id)
		   ->leftJoin('cidades','cidades.id','=','users.cidade_id')
		   ->select('cidades.nome as cidade','cidades.uf as uf','users.*')
		   ->first();

		$imagemCredencimento = ImagemCredenciamento::join('tipo_imagem', 'tipo_imagem.id', '=', 'imagem_credenciamento.tipo_imagem')
								->select('tipo_imagem.descricao as tipo_imagem', 'imagem_credenciamento.path as path')
								->where('ultima', 1)
								->where('id_user', $id)
								->get();

		$filter = intval(Input::get('startusCreden'));

		if( Input::get('pesquisar') ){
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

			$usuarioCredenciamentoEmpresas = Representante::where('id_user', $id)
			->orWhere(function($query) use ($pesquisar){
				$query->orWhere('cnpj','like',$pesquisar)
						->orWhere('razao','like',$pesquisar)
						->orWhere(DB::raw('replace(replace(replace(cnpj,".",""),"-",""),"/","")'),'like',$pesquisar);
			})->orderBy('created_at','desc')->paginate(10);		
		}
		elseif ($filter && $filter != 9) {
			if($filter < 5){
				if ($filter == 4) {
					$filter = 0;
				}
				$usuarioCredenciamentoEmpresas = $usuarioCredenciamentoEmpresas->where('papel_id',8)->where('creden', $filter)->orderBy('created_at','desc')->paginate(10);
			} else {
				if($filter == 5){
					$usuarioCredenciamentoEmpresas = $usuarioCredenciamentoEmpresas->where('papel_id',8)->whereNotNull('adesao_at')->orderBy('adesao_at','desc')->paginate(10);
				} else {
					$usuarioCredenciamentoEmpresas = $usuarioCredenciamentoEmpresas->where('papel_id',8)->whereNull('adesao_at')->orderBy('created_at','desc')->paginate(10);
				}
			}
		}
		else {
			$usuarioCredenciamentoEmpresas = Representante::where('user_id', $id)->orderBy('created_at','desc')->paginate(10);
		}

		$usuarioCredenciamentoEmpresas->setPath('credenciamentoboleto');
						
		return view('admin.credenciamentoboleto.visualizar')
			->with('usuario',$user)
			->with('creden',$imagemCredencimento)
			->with('usuarioCredenciamento',$usuarioCredenciamentoEmpresas);
	}

	public function edit($id, $creden, Request $request)
	{
		$user = User::find($id);

		if ($creden != 0) {
			$motivoDescredeciamento = Input::get('motivoDesc');
			
			$user->creden = $creden;
			if ($motivoDescredeciamento) {
				$user->motivo_descrendenciamento = $motivoDescredeciamento;
			}
			$user->save();	

			$dadosUsuario = [
				'usuario' => strtoupper($user->name),
				'documento' => $user->cpf,
				'motivo' => $motivoDescredeciamento
 			];

			if ($creden == 1) {
				Mail::send('emails.credenciamentopf',["dados"=>$dadosUsuario],function($email) use ($user){
					$email->subject('Credenciamento - Pessoa Física');
					$email->to($user->email);
					$email->from('intimacao@2protestoslz.com.br','2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís');
				});
			} else {
				Mail::send('emails.credenciamento_failpf',["dados"=>$dadosUsuario],function($email) use ($user){
					$email->subject('Credenciamento - Pessoa Física');
					$email->to($user->email);
					$email->from('intimacao@2protestoslz.com.br','2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís');
				});
			}

			return redirect('admin/credenciamentoboleto')->with('sucesso',true);
		} else {
			$authUser = Auth::user();
			if( $authUser->papel_id!=1){
				$cartorio = Cartorio::where('id', $authUser->cartorio_id )->first();
			}
			else {
				$cartorio = Cartorio::get();
			}
			
			// Block profile roles to lower roles
			if($authUser->papel_id>2)  
				$perfis = Perfil::where('id','>=',$authUser->papel_id)->get();
			else $perfis = Perfil::get();
	
			$user = User::leftJoin('cartorios','cartorios.id','=','users.cartorio_id')
				  ->leftJoin('cidades','cidades.id','=','users.cidade_id')
				  ->select('cidades.nome as cidade','cidades.ibge as ibge','cartorios.nome as cartorio','users.*')
				  ->where('users.id',$id)->first();
	
			return view('admin.credenciamentoboleto.editar')
				->with('perfis',$perfis)
				->with('cartorio',$cartorio)
				->with('loggedUser',$authUser)
				->with('isAdmin',$authUser->papel_id==1?true:false)
				->with('registro',$user);
				
		}
	}

	public function update($id, Request $retorno)
	{
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
		$user->data_nascimento = Input::get('dtNasc');
		$user->cidade_id = $idCidade[0]['id'];

		if($loggedUser->papel_id==1){
			$user->cartorio_id = Input::get('cartorio');
		}
		else{
			$user->cartorio_id = $loggedUser->cartorio_id;
		} 

		if( Input::get('senha') ){
			$user->password = Hash::make( Input::get('senha') );
		}
		
		$user->save();

		$arquivo1 = Input::file('doccreden1');
		if ($arquivo1){
			$extensao = $arquivo1->getClientOriginalExtension();
			File::move( $arquivo1, public_path().'/images/'.$user->id.'-1-imagem.'.$extensao );
			$creden_image1 = '/images/'.$user->id.'-1-imagem.'.$extensao;
		}

		$arquivo2 = Input::file('doccreden2');
		if ($arquivo2){
			$extensao = $arquivo2->getClientOriginalExtension();
			File::move( $arquivo2, public_path().'/images/'.$user->id.'-2-imagem.'.$extensao );
			$creden_image2 = '/images/'.$user->id.'-2-imagem.'.$extensao;
		}

		if ($arquivo1) {
			// Atualiza os documentos anteriores do usuario para null
			ImagemCredenciamento::where('id_user', $id)->where('tipo_imagem',1)->update(['ultima' => 0]);

			// Atualiza os novos documentos para os últimos informados
			$documentoCreden = new ImagemCredenciamento;
			$documentoCreden->path = $creden_image1;
			$documentoCreden->tipo_imagem = 1;
			$documentoCreden->id_user = $id;
			$documentoCreden->ultima = 1;
			$documentoCreden->save();
		} else if ($arquivo2) {
			ImagemCredenciamento::where('id_user', $id)->where('tipo_imagem',2)->update(['ultima' => 0]);

			$documentoCreden = new ImagemCredenciamento;
			$documentoCreden->path = $creden_image2;
			$documentoCreden->tipo_imagem = 2;
			$documentoCreden->id_user = $id;
			$documentoCreden->ultima = 1;
			$documentoCreden->save();
		}

		return redirect('admin/credenciamentoboleto/'.$user->id.'/0/edit')
			->with('sucesso',true);	
	}

	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();

		return redirect('admin/credenciamentoboleto')->with('sucesso',true);		
	}

	public function enviaVerificacaoEmail($idUser){
		$user = User::find($idUser);
		// $user = User::find(82);

		try {
			Mail::to($user->email)->send(new VerifyMail($user));
		} catch (Exception $e) {
			return redirect('admin/credenciamentoboleto')
			->with('sucesso',false)
			->with('email', false);	
		}
		return redirect('admin/credenciamentoboleto')
			->with('sucesso',true)
			->with('email', true);	
	}
}