<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Request;

use App\User;
use App\Cartorio;
use App\Perfil;
use App\Cidade;
use App\ImagemCredenciamento;

use Mail;
use DB;
use File;

use App\Representante;

use Illuminate\Support\Facades\Input;
use Auth;

class AdminCredeciamentoRepresentanteController extends Controller {

	public function __construct(){
        view()->share('page_title','Credenciamento de Representantes');
        view()->share('page_description','');
    }

    public function index(){
		$filter = intval(Input::get('startusCreden'));
		$filter2 = intval(Input::get('statusVencimento'));
		$filter3 = intval(Input::get('statusImpressao'));

		$user = intval(Input::get('userid'));

		if($user){
			$usuarioCredenciamento = Representante::select('representante.*','adesao_at')->join('users','users.id','=','representante.user_id')->where('users.id',$user);
		} else {
			$usuarioCredenciamento = Representante::select('representante.*','adesao_at')->join('users','users.id','=','representante.user_id');
		}

		if( Input::get('pesquisar') ){
            $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

            $usuarioCredenciamento = $usuarioCredenciamento->orWhere(function($query) use ($pesquisar){
                $query->orWhere('cnpj','like',$pesquisar)
                      ->orWhere('razao','like',$pesquisar)
                      ->orWhere(DB::raw('replace(replace(replace(cnpj,".",""),"-",""),"/","")'),'like',$pesquisar);
            });
                
		}
		elseif ($filter && $filter != 9) {
			if($filter < 5){
				if ($filter == 4) {
					$filter = 0;
				}
				$usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->where('representante.creden', $filter);
			} else {
				if($filter == 5){
					$usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->whereNotNull('adesao_at');
				} else {
					$usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->whereNull('adesao_at');
				}
			}
		} else {
			$usuarioCredenciamento = $usuarioCredenciamento;
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

		if($user){
			$user = User::where('users.id',$user)
			->leftJoin('cidades','cidades.id','=','users.cidade_id')
			->select('cidades.nome as cidade','cidades.uf as uf','users.*')
			->first();

			$imagemCredencimento = ImagemCredenciamento::join('tipo_imagem', 'tipo_imagem.id', '=', 'imagem_credenciamento.tipo_imagem')
								->select('tipo_imagem.descricao as tipo_imagem', 'imagem_credenciamento.path as path')
								->where('ultima', 1)
								->where('id_user', $user)
								->get();

			$usuarioCredenciamento->setPath('credenciamentoboleto');

			return view('admin.credenciamentoboleto.visualizar')
			->with('usuario',$user)
			->with('creden',$imagemCredencimento)
			->with('usuarioCredenciamento',$usuarioCredenciamento);
		} else {
			$usuarioCredenciamento->setPath('credenciamentorepresentante');

			return view('admin.credenciamentorepresentante.home')
			->with('usuarioCredenciamento', $usuarioCredenciamento);
		}
	}
	
	public function visualizar($id, $representanteid)
	{
		$user = User::where('users.id',$id)
		   ->leftJoin('cidades','cidades.id','=','users.cidade_id')
		   ->select('cidades.nome as cidade','cidades.uf as uf','users.*')
		   ->first();
		
		$empresa = Representante::where('representante.id',$representanteid)
		   ->leftJoin('cidades','cidades.id','=','representante.cidade_id')
		   ->select('cidades.nome as cidade','cidades.uf as uf','representante.*')
		   ->first();

		return view('admin.credenciamentorepresentante.visualizar')
		->with('usuario',$user)
		->with('empresa',$empresa);
	}

	public function alterar($id, $creden, Request $request)
	{
		$user = Representante::join('cidades', 'cidades.id', '=', 'representante.cidade_id')
							   ->select('representante.*','cidades.nome', 'cidades.ibge')
							   ->find($id);
		
		$usuarioRepresentante = User::find($user->user_id);

		if ($creden != 0) {
			$motivoDescredeciamento = Input::get('motivoDesc');

			$user->creden = $creden;
			if ($motivoDescredeciamento) {
				$user->motivo_descrendenciamento = $motivoDescredeciamento;
			}
			$user->save();	

			$dadosRepresentante = [
				'usuario' => strtoupper($usuarioRepresentante->name),
				'documento' => $user->cnpj,
				'motivo' => $motivoDescredeciamento
 			];

			if ($creden == 1) {
				Mail::send('emails.credenciamentopj',["dados"=>$dadosRepresentante],function($email) use ($user){
					$email->subject('Credenciamento - Pessoa Jurídica');
					$email->to($user->email);
					$email->from('intimacao@2protestoslz.com.br','2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís');
				});
			} else {
				Mail::send('emails.credenciamento_failpj',["dados"=>$dadosRepresentante],function($email) use ($user){
					$email->subject('Credenciamento - Pessoa Jurídica');
					$email->to($user->email);
					$email->from('intimacao@2protestoslz.com.br','2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís');
				});
			}

			return redirect('admin/credenciamentorepresentante')->with('sucesso',true);
		} else {
			$authUser = Auth::user();
			if( $authUser->papel_id!=1){
				$cartorio = Cartorio::where('id', $authUser->cartorio_id )->first();
			}
			else $cartorio = Cartorio::get();
			
			// Block profile roles to lower roles
			if($authUser->papel_id>2)  
				$perfis = Perfil::where('id','>=',$authUser->papel_id)->get();
			else $perfis = Perfil::get();
	
			return view('admin.credenciamentorepresentante.editar')
				->with('perfis',$perfis)
				->with('cartorio',$cartorio)
				->with('loggedUser',$authUser)
				->with('isAdmin',$authUser->papel_id==1?true:false)
				->with('representante', $usuarioRepresentante)
				->with('registro',$user);
		}
	}

	public function update(Request $request,$id)
	{
		$representante = Representante::find($id);

		$idCidade = Cidade::where('ibge',Input::get('cidadeUsuarioIBGE'))->get()->toArray();

		$representante->razao = Input::get('razao');
		$representante->email = Input::get('email');
		$representante->cnpj = Input::get('cnpj');
		$representante->cep = Input::get('cep');
		$representante->endereco = Input::get('usuarioEndereco');
		$representante->bairro = Input::get('usuarioBairro');
		$representante->numero = Input::get('usuarioNumero');
		$representante->complemento = Input::get('usuarioComplemento');
		$representante->telefone = Input::get('telefone');

		$representante->cidade_id = $idCidade[0]['id'];

		$representante->save();

		$contratosocial = Input::file('contratosocial');
		if ($contratosocial) {
			$extensao = $contratosocial->getClientOriginalExtension();
			File::move( $contratosocial, public_path().'/representante/contratosocial-id_'.$representante->id.'.'.$extensao );
			$representante->contratosocial = '/representante/contratosocial-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$cartaocnpj = Input::file('cartaocnpj');
		if ($cartaocnpj) {
			$extensao = $cartaocnpj->getClientOriginalExtension();
			File::move( $cartaocnpj, public_path().'/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao );
			$representante->cartaocnpj = '/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$procuracao = Input::file('procuracao');
		if ($procuracao) {
			$extensao = $procuracao->getClientOriginalExtension();
			File::move( $procuracao, public_path().'/representante/procuracao-id_'.$representante->id.'.'.$extensao );
			$representante->procuracao = '/representante/procuracao-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		return redirect('admin/credenciamentorepresentante/'.$representante->id.'/0/edit')
			->with('sucesso',true);	
	}

	public function destroy($id)
	{
		$user = Representante::find($id);
		$user->delete();

		return redirect('admin/credenciamentorepresentante')->with('sucesso',true);		
	}
}