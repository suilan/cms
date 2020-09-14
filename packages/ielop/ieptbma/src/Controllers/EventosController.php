<?php
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Evento;
use App\Estado;
use App\Cidade;
use App\EventoInscricao;
use DB;
use File;
use Redirect;
use Session;
use Carbon\Carbon;

use Validator;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class EventosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$eventosProximos = Evento::where('data_final','>=', Carbon::now()->toDateString())
			->where('status','=',1)
			->orderBy('data_inicial','desc')
			->select('*',DB::raw("date_format(data_inicial,'%d') as dia"),
			DB::raw("date_format(data_inicial,'%b') as mes"))
			->get();

		$eventoPassados = Evento::where('data_final','<', Carbon::now()->toDateString())
			->where('status','=',1)
			->orderBy('data_inicial','desc')
			->select('*',DB::raw("date_format(data_inicial,'%d') as dia"),
			DB::raw("date_format(data_inicial,'%b') as mes"))
			->paginate(6);
		
		$qtd_confirmados = EventoInscricao::where('confirmado','=',1)->where('evento_id','=',16)
		->count();

		// Replace maonths returned by database
		$months = ['Jan' => 'Jan','Feb' => 'Fev','Mar' => 'Mar','Apr' => 'Abr','May' => 'Mai',
		'Jun' => 'Jun','Jul' => 'jul','Aug' => 'Ago','Sep' => 'Set','Oct' => 'Out','Nov' => 'Nov','Dec' => 'Dez'];

		return view('ieptbma::eventos')
			->with('eventosProximos',$eventosProximos)
			->with('eventosPassados',$eventoPassados)
			->with('qtd_confirmados', $qtd_confirmados)
			->with('mes', $months);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	//
	// }

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
		$cidades = Cidade::where('estado_id','10')->get();
		$estados = Estado::select('id','nome')->get();

		$evento = Evento::where('slug','=', Input::get('slug'))
				->first();

		if ( !$validator->fails() ) {

			$valida_cpf = Input::get('cpf');

			if(EventoInscricao::where('cpf','=',$valida_cpf)->where('evento_id','=',16)->first()){
				return view('ieptbma::evento')
				->with('evento',$evento)
				->with('cidades', $cidades)
				->with('estados', $estados)	
				->with('statusError', 'CPF já cadastrado. Mais informações, contate nosso suporte pelo telefone : (98) 9 9218-2518"');

			}else if(EventoInscricao::where('cpf','=',$valida_cpf)->where('evento_id','=',16)->first() == null){

				$estado_selecionado = Input::get('estado');

				$cidade_selecionada = Input::get('cidade');

				$cidade_escolhida = Cidade::join('estados','estados.id','=','cidades.estado_id')
									->select('cidades.id')
									->where('cidades.id','=',$cidade_selecionada)
									->first();
				

				$registro = new EventoInscricao;
				$registro->nome = Input::get('nome');
				$registro->cpf = Input::get('cpf');
				$registro->rg = Input::get('rg');
				$registro->email = Input::get('email');
				$registro->telefone = Input::get('telefone');
				$registro->celular = Input::get('celular');
				$registro->cidade_id = $cidade_escolhida->id;
				$registro->empresa = Input::get('empresa');
				$registro->endereco = Input::get('endereco');
				$registro->inscricao = Input::get('inscricao');
				$registro->evento_id = 16; // Último evento, depois refatorar, pra v como pegar o id do evento de inscricao
				$registro->comprovante_estudante = '';
				$registro->comprovante_url = '';
				
				$imagem = Input::file('comprovanteEstudante');
				$imagem_comprovante = Input::file('comprovantePagamento');

				if($imagem){
					$extensao = $imagem->getClientOriginalExtension();
					File::move( $imagem, public_path().'/images/comprovante_estudante-id_'.$registro->cpf.'.'.$extensao);
					$registro->comprovante_estudante = '/images/comprovante_estudante-id_'.$registro->cpf.'.'.$extensao;

					$registro->save();
					return view('ieptbma::evento')
					->with('evento',$evento)
					->with('cidades', $cidades)
					->with('estados', $estados)					
					->with('status', 'Caro estudante, Comprovante de estudante enviado com sucesso. ');

				}else if($imagem_comprovante){

							$extensao = $imagem_comprovante->getClientOriginalExtension();
							File::move( $imagem_comprovante, public_path().'/images/comprovante-id_'.$registro->cpf.'.'.$extensao);
							$registro->comprovante_url = '/images/comprovante-id_'.$registro->cpf.'.'.$extensao;
							$registro->save();
							return view('ieptbma::evento')
							->with('evento',$evento)
							->with('cidades', $cidades)
							->with('estados', $estados)
							->with('status', 'Cadastro realizado com sucesso. Comprovante de pagamento enviado com sucesso. ');

				}else{
							$registro->save();
							
							return view('ieptbma::evento')
							->with('evento',$evento)
							->with('cidades', $cidades)
							->with('estados', $estados)
							// ->with('status', 'Para confirmar sua inscrição, nos envie o comprovante clicando no botão -Enviar Pagamento- que se encontra ao final da descrição do evento. Obrigado.')
							->with('status', 'INSCRIÇÃO REALIZADA COM SUCESSO! Enviaremos um e-mail após a validação dos seu cadastro. Obrigado.')
							->with('pgStatus01', 'Clique no botão ENVIAR PAGAMENTO, localizado no final da página do evento, informe seu CPF e anexe a imagem do comprovante de transferência.')
							->with('pgStatus02', 'Imediatamente após a identificação do crédito correspondente ao pagamento da inscrição, você receberá um e-mail* com a informação que "SUA INSCRIÇÃO FOI CONFIRMADA COM SUCESSO"');
				}
			}
		} else{
			return view('ieptbma::evento')
				->with('evento',$evento)
				->with('cidades', $cidades)
				->with('estados', $estados)
				->with('statusError', 'Erro ao realizar o cadastro. Por favor, tente novamente.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$estados = Estado::select('id','nome')->get();
		$cidades = Cidade::get();

		$evento = Evento::where('slug','=', $id)
			->join('users','users.id','=','eventos.user_id')
			->select('users.id as user_id','eventos.*')
			->first();

		$qtd_confirmados = EventoInscricao::where('confirmado','=',1)->where('evento_id','=',16)
                           ->count();

		return view('ieptbma::evento')
			->with('evento',$evento)
			->with('estados', $estados)
			->with('cidades', $cidades)
			->with('qtd_confirmados', $qtd_confirmados)
			->with('status', '');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function edit($id)
	// {
	// 	//
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $slug)
	{
			$registro = EventoInscricao::Join('eventos','eventos.id','=','eventos_inscricao.evento_id')
						->select('eventos_inscricao.*','eventos.slug')
						->where('cpf','=',Input::get('cpf'))
						->where('evento_id','=',16)
						->first();

			$cidades = Cidade::where('estado_id','10')->get();
		    $estados = Estado::select('id','nome')->get();

			$evento = Evento::where('slug','=', $slug)
				->first();
			
			if ($registro){
					$imagem = Input::file('comprovante');
					$imagemEstudante = Input::file('comprovante_estudante');

					if ($imagem){
							$extensao = $imagem->getClientOriginalExtension();

							File::move( $imagem, public_path().'/images/comprovante-id_'.$registro->cpf.'.'.$extensao);
							$registro->comprovante_url = '/images/comprovante-id_'.$registro->cpf.'.'.$extensao;

							$registro->save();

							return view('ieptbma::evento')
										->with('evento',$evento)
										->with('cidades', $cidades)
										->with('estados', $estados)
										->with('pgStatus01', '')
										->with('pgStatus02', '')
										->with('status', 'Comprovante de pagamento enviado com sucesso. Em breve entraremos em contato com você.');
					}
					elseif ($imagemEstudante){
							$extensao = $imagemEstudante->getClientOriginalExtension();

							File::move( $imagemEstudante, public_path().'/images/comprovante_estudante-id_'.$registro->cpf.'.'.$extensao);
							$registro->comprovante_estudante = '/images/comprovante_estudante-id_'.$registro->cpf.'.'.$extensao;

							$registro->save();

							return view('ieptbma::evento')
										->with('evento',$evento)
										->with('cidades', $cidades)
										->with('estados', $estados)
										->with('pgStatus01', '')
										->with('pgStatus02', '')
										->with('status', 'Comprovante de estudante enviado com sucesso. Em breve entraremos em contato com você.');
					}
					else{
							return view('ieptbma::evento')
										->with('evento',$evento)
										->with('cidades', $cidades)
										->with('estados', $estados)
										->with('pgStatus01', '')
										->with('pgStatus02', '')
										->with('status', 'Favor informar o comprovante no envio do mesmo.');
					}
			}else{
					return view('ieptbma::evento')
					->with('evento',$evento)
					->with('cidades', $cidades)
					->with('estados', $estados)
					->with('statusError', 'CPF não foi localizado na base de dados do evento. Em caso de dúvidas, favor entrar em contato com o IEPTB-MA.');
			}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function destroy($id)
	// {
	// 	//
	// }

	// PRIVATE METHODS
	private function validationRules(){
		$rules = [
	        'nome' => 'required|max:255',
	        'cpf' => 'required|max:255',
	        // 'rg' => 'required|max:255',
	        'celular' => 'required|max:300',
	        'endereco' => 'required|max:300'
	    ];

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	    	'nome.required' => 'O Nome é Obrigatório',
	        'cpf.required' => 'O CPF é Obrigatório',
	        // 'rg.required' => 'O RG é Obrigatório',
	        'celular.required' => 'O Celular é Obrigatório',
	        'endereco.required' => 'O Endereço é Obrigatório'
	    ];
	}

}
