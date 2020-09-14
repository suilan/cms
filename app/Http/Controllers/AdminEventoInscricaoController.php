<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\EventoInscricao;
use App\Cidade;
use App\Estado;
use Input;
use File;
use Auth;
use Mail;
use DB;

use Validator;

class AdminEventoInscricaoController extends Controller
{
    public function __construct()
	{
		view()->share('page_title','Inscritos no evento');
		view()->share('page_description','Visualização de inscritos no evento');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if ( Input::get('pesquisar') || Input::get('inscricao') || Input::get('status')){
    		$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
    		$inscricao = Input::get('inscricao');
    		$status = Input::get('status');

    		$inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
				->join('users','users.id','=','eventos.user_id')
				->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
    			->select('users.name as name','cidades.nome as cidade',DB::raw('DATE_FORMAT(eventos_inscricao.created_at,"%d/%m/%Y") as data_insc'),'eventos_inscricao.*')
				// ->where('confirmado','=',null)
				->where('eventos.id','=',16);

    		if ($pesquisar != "%%"){
    			$inscritos = $inscritos->where('eventos_inscricao.nome','like',$pesquisar)
    			->orWhere('eventos_inscricao.cpf','like',$pesquisar)->where('eventos.id','=',16)
    			->orWhere('eventos_inscricao.rg','like',$pesquisar)->where('eventos.id','=',16)
    			->orWhere('eventos_inscricao.email','like',$pesquisar)->where('eventos.id','=',16);
    		}
    		if($inscricao != "0"){
				$inscritos = $inscritos->where('eventos_inscricao.inscricao','like',$inscricao);
				$qtd_inscritos = EventoInscricao::where('evento_id','=',16)->where('inscricao',$inscricao)->count('*');
				$qtd_confirmados = EventoInscricao::where('confirmado','=',1)->where('inscricao',$inscricao)->where('evento_id','=',16)
					->count();
    		} else {
				$qtd_inscritos = EventoInscricao::where('evento_id','=',16)->count('*');
				$qtd_confirmados = EventoInscricao::where('confirmado','=',1)->where('evento_id','=',16)
								->count();
			}
    		if($status != "0"){
      			if($status == "1"){
      				$inscritos = $inscritos->where('eventos_inscricao.confirmado','=','1');
      			}elseif ($status == "2") {
      				$inscritos = $inscritos->where('eventos_inscricao.comprovante_url','<>','')
              ->whereNull('eventos_inscricao.confirmado');
      			}else{
      				$inscritos = $inscritos->where('eventos_inscricao.comprovante_url','=','');
      			}
			}
		}
		else
		{
			$inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
				->join('users','users.id','=','eventos.user_id')
				->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
				->select('users.name as name','cidades.nome as cidade',DB::raw('DATE_FORMAT(eventos_inscricao.created_at,"%d/%m/%Y") as data_insc'),'eventos_inscricao.*')
				// ->where('confirmado','=',null)
				->where('eventos.id','=',16);

			$qtd_inscritos = EventoInscricao::where('evento_id','=',16)->count('*');
			$qtd_confirmados = EventoInscricao::where('confirmado','=',1)->where('evento_id','=',16)
								->count();
		}

		// If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $inscritos = $inscritos->where('eventos.user_id','=', $user->id);
		}
		
        $inscritos = $inscritos->orderBy('confirmado','asc')
                               ->paginate(10);
        $inscritos->setPath('eventosinscritos');

		return view('admin.eventosinscritos.home')
			->with('inscritos',$inscritos)
			->with('qtd_inscritos',$qtd_inscritos)
      		->with('qtd_confirmados',$qtd_confirmados);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cidades = Cidade::get();
		$estados = Estado::select('id','nome')->get();

		$inscrito = new EventoInscricao;
		$inscrito->nome = Input::old('nome');
		$inscrito->cpf = Input::old('cpf');

		return view('admin.eventosinscritos.editar')
		->with('inscrito',$inscrito)
		->with('cidades', $cidades)
		->with('estados', $estados);
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

		$inscrito = new EventoInscricao;
		$inscrito->nome = Input::get('nome');
		$inscrito->cpf = Input::get('cpf');
		$inscrito->rg = Input::get('rg');
		$inscrito->email = Input::get('email');
		$inscrito->telefone = Input::get('telefone');
		$inscrito->celular = Input::get('celular');
		$inscrito->cidade_id = Input::get('cidade');
		$inscrito->empresa = Input::get('empresa');
		$inscrito->endereco = Input::get('endereco');
		$inscrito->inscricao = Input::get('inscricao');
		$inscrito->confirmado = Input::get('confirmado');
		$inscrito->evento_id = 16; // Último evento, depois refatorar, pra v como pegar o id do evento de inscricao

        $inscrito->save();

		return redirect('admin/eventosinscritos/'.$inscrito->cpf.'/edit')
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
		$inscrito = EventoInscricao::join('cidades','cidade_id','=','cidades.id')
					->select('cidades.nome as cidade','eventos_inscricao.*')
					->where('cpf', '=', $id)
					->where('evento_id','=',16)
					->first();

		return view('admin.eventosinscritos.visualizar')->with('inscrito',$inscrito);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$inscrito = EventoInscricao::where('cpf','=',$id)
									->where('evento_id','=',16)
									->first();
		$cidades = Cidade::get();
		$estados = Estado::select('id','nome')->get();

        // Se houver dados de formularios anteriores
    if( Input::old('_token') )
		{
            $inscrito->nome = Input::get('nome');
			$inscrito->cpf = Input::get('cpf');
			$inscrito->rg = Input::get('rg');
			$inscrito->email = Input::get('email');
			$inscrito->telefone = Input::get('telefone');
			$inscrito->celular = Input::get('celular');
			$inscrito->cidade_id = Input::get('cidade');
			$inscrito->empresa = Input::get('empresa');
			$inscrito->endereco = Input::get('endereco');
			$inscrito->inscricao = Input::get('inscricao');
			$inscrito->confirmado = Input::get('confirmado');
			$inscrito->evento_id = 16; // Último evento, depois refatorar, pra v como pegar o id do evento de inscricao
        }

        return view('admin.eventosinscritos.editar')
        ->with('inscrito',$inscrito)
        ->with('cidades', $cidades)
		->with('estados', $estados);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request){
		$certificadoEnviado = false;

    	// Envio do comprovante de pagamento
		$inscrito = EventoInscricao::where('cpf','=',$id)
		->where('evento_id','=',16)
		->first();

    	$imagem = Input::file('comprovante');
      	$imagemComprovanteEstudante = Input::file('comprovante_estudante');
		$imagemCertificado = Input::file('certificado');

    	if ($imagem) {
      		$extensao = $imagem->getClientOriginalExtension();

      		File::move( $imagem, public_path().'/images/comprovante-id_'.$inscrito->cpf.'.'.$extensao);
      		$inscrito->comprovante_url = '/images/comprovante-id_'.$inscrito->cpf.'.'.$extensao;

      		$inscrito->save();
    	}
		elseif ($imagemComprovanteEstudante) {
			$extensao = $imagemComprovanteEstudante->getClientOriginalExtension();

			File::move( $imagemComprovanteEstudante, public_path().'/images/comprovante_estudante-id_'.$inscrito->cpf.'.'.$extensao);
			$inscrito->comprovante_estudante = '/images/comprovante_estudante-id_'.$inscrito->cpf.'.'.$extensao;

			$inscrito->save();
		}
		elseif ($imagemCertificado) {
			$extensao = $imagemCertificado->getClientOriginalExtension();

			File::move( $imagemCertificado, public_path().'/images/certificado-id_'.$inscrito->cpf.'.'.$extensao);
			$inscrito->certificado = '/images/certificado-id_'.$inscrito->cpf.'.'.$extensao;

			$inscrito->save();

			Mail::send('admin.email.notificacao_email',$request->all(),function($email) use ($inscrito, $extensao){
				$email->subject('Certificado de Participação - PROVIMENTO 88 CNJ: ATUAÇÃO DOS TABELIÃES DE NOTAS E PROTESTO NA PREVENÇÃO À LAVAGEM DE DINHEIRO');
				$email->to($inscrito->email);
				$email->from('contato@ieptbma.com.br','IEPTB-MA Eventos');
				$email->attach(public_path().'/images/certificado-id_'.$inscrito->cpf.'.'.$extensao, [
					'as' => 'certificado-id_'.$inscrito->cpf.'.'.$extensao,
					'mime' => 'application/'.$extensao,
				]);
			});

			$certificadoEnviado = true;

			return redirect('admin/eventosinscritos/'.$inscrito->cpf.'/edit')
			->with('sucesso',true)
			->with('certificado', $certificadoEnviado);
		}
		else{
			$inscrito = EventoInscricao::where('cpf','=',$id)
										->where('evento_id','=',16)
										->first();
			$cidades = Cidade::where('estado_id','10')->get();

			$inscrito->nome = Input::get('nome');
			$inscrito->cpf = Input::get('cpf');
			$inscrito->rg = Input::get('rg');
			$inscrito->email = Input::get('email');
			$inscrito->telefone = Input::get('telefone');
			$inscrito->celular = Input::get('celular');
			$inscrito->cidade_id = Input::get('cidade');
			$inscrito->empresa = Input::get('empresa');
			$inscrito->endereco = Input::get('endereco');
			$inscrito->inscricao = Input::get('inscricao');
			$inscrito->confirmado = Input::get('confirmado');
			$inscrito->evento_id = 16; // Último evento, depois refatorar, pra v como pegar o id do evento de inscricao

			if($inscrito->confirmado == 1){
				Mail::send('admin.email.notificacao_email',$request->all(),function($email){
					$email_inscrito = Input::get('email');
					$email->subject('Confirmação de Inscrição');
					$email->to($email_inscrito);
					$email->from('contato@ieptbma.com.br','IEPTB-MA Eventos');
				});
			}
			$inscrito->save();
		}

		return redirect('admin/eventosinscritos/'.$inscrito->cpf.'/edit')
			->with('sucesso',true)
			->with('certificado', $certificadoEnviado);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$inscrito = EventoInscricao::where('cpf','=',$id)
									->where('evento_id','=',16)
									->first();
		$inscrito->delete();

		return redirect('admin/eventosinscritos');
	}

	// PRIVATE METHODS
	private function validationRules(){
		$rules = [
	        'nome' => 'required|max:255',
	        'cpf' => 'required|max:255',
	        'rg' => 'required|max:255',
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
	        'rg.required' => 'O RG é Obrigatório',
	        'celular.required' => 'O Celular é Obrigatório',
	        'endereco.required' => 'O Endereço é Obrigatório'
	    ];
	}
}
