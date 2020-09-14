<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App\Evento;
use Redirect;
use File;
class AdminEventosController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Eventos');
		view()->share('page_description','Edição, criação e exclusão de eventos no site');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$registros = Evento::join('users','users.id','=','eventos.user_id')
				->select('users.name','eventos.*')
				->where('titulo','like',$pesquisar)
				->orWhere('conteudo','like',$pesquisar);
		}
		else
		{
			$registros = Evento::join('users','users.id','=','eventos.user_id')
				->select('users.name','eventos.*');
		}

		// If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $registros = $registros->where('eventos.user_id','=', $user->id);
        }

        $registros = $registros->orderBy('created_at','desc')
                           	   ->paginate(10);

		// for paginate purpose, set the path that will apear on the links
		$registros->setPath('eventos');

		return view('admin.eventos.home')
			->with('registros',$registros);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$registro = new Evento;
        
        return view('admin.eventos.criar')
        	->with('registro',$registro);
	}
	
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{

		// A propria controller ja trata a validação, se falhar, 
		//ela mesma faz o redirect para a pagian anterior
		$this->validate( $request, $this->validationRules(), $this->validationMessages() );

		// Se não houver falhas
		$registro = new Evento;
		$registro->titulo = Input::get('titulo');
		$registro->slug = str_slug( $registro->titulo , "-");
		$registro->data_inicial = Input::get('data_inicial');
		$registro->data_final = Input::get('data_final');
		$registro->conteudo = Input::get('conteudo');
		$registro->status = Input::get('status');
		$registro->user_id = Auth::user()->id;

		// Tratamento da data para o banco
		$periodo = explode(' - ',Input::get('periodo'));
		$registro->data_inicial = $this->dateTimeBanco($periodo[0]);
		$registro->data_final = $this->dateTimeBanco($periodo[1]);

		// Tratamento da Imagem
		if( Input::get('tipoimagem')=='img-url' )
		{
			$registro->imagem_url = Input::get('imagemurl');
			$registro->save();
		}
		else
		{
			$registro->save();

			$imagem = Input::file('imagemarquivo');

        	$extensao = $imagem->getClientOriginalExtension();

			File::move( $imagem, public_path().'/images/evento-id_'.$registro->id.'.'.$extensao );
			$registro->imagem_arquivo = '/images/evento-id_'.$registro->id.'.'.$extensao;
			$registro->save();
		}

		return redirect('admin/eventos/'.$registro->id.'/edit')
        	->with('sucesso',true);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function show($id)
	// {

	// }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$registro = Evento::find($id);

		// Se houver dados de formularios anteriores
		if( Input::old('_token') ){
			$registro->titulo = Input::old('titulo');
			$registro->status = Input::old('status');
			$registro->imagem_url = Input::old('imagemurl');
			$registro->imagem_arquivo = Input::old('imagemarquivo');
			$registro->conteudo = Input::old('conteudo');
		}

		if( Input::old('periodo') )
		{
			$registro->periodo = Input::old('periodo');
		}
		else{
			$registro->periodo = $this->dateTimeBr($registro->data_inicial).' - '.$this->dateTimeBr($registro->data_final);
		}

		return view('admin.eventos.editar')->with('registro',$registro);
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		// A propria controller ja trata a validação, se falhar, 
		//ela mesma faz o redirect para a pagian anterior
		$this->validate( $request, 
				$this->validationRules(Input::get('tipoimagem')=='img-file' && Input::get('imgarq')), 
				$this->validationMessages() );

		// Se não houver falhas
		$registro = Evento::find( $id );
		$registro->titulo = Input::get('titulo');
		$registro->slug = str_slug( $registro->titulo , "-");
		$registro->data_inicial = Input::get('data_inicial');
		$registro->data_final = Input::get('data_final');
		$registro->conteudo = Input::get('conteudo');
		$registro->status = Input::get('status');
		$registro->user_id = Auth::user()->id;

		// Tratamento da data para o banco
		$periodo = explode(' - ',Input::get('periodo'));
		$registro->data_inicial = $this->dateTimeBanco($periodo[0]);
		$registro->data_final = $this->dateTimeBanco($periodo[1]);

		// Tratamento da Imagem
		if( Input::get('tipoimagem')=='img-url' )
		{
			$registro->imagem_url = Input::get('imagemurl');
			if( $registro->imagem_url ){
				$registro->imagem_arquivo = '';
			}

			$registro->save();
		}
		else
		{
			// Se já tiver arguma imagem ou se for submetida uma nova
			if( !Input::get('imgarq') || Input::file('imagemarquivo') )
			{
				// Apaga qualquer imagem  da u rl
				$registro->imagem_url = '';

				$imagem = Input::file('imagemarquivo');
	        	$extensao = $imagem->getClientOriginalExtension();

				File::move( $imagem, public_path().'/images/noticia-id_'.$registro->id.'.'.$extensao );
				$registro->imagem_arquivo = '/images/noticia-id_'.$registro->id.'.'.$extensao;
			}

			$registro->save();
		}

		return redirect('admin/eventos/'.$registro->id.'/edit')
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
		$registro = Evento::find($id);

		File::delete(public_path().$registro->imagem);

		$registro->delete();

		return redirect('admin/eventos')
			->with('sucesso',true);
	}


	// PRIVATE METHODS
	private function validationRules( $imgarq = false ){
		$rules = [
	        'titulo' => 'required|max:255',
	        'periodo' => 'required|regex:/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}\ [0-9]{2}\:[0-9]{2}\ \-\ [0-9]{2}\/[0-9]{2}\/[0-9]{4}\ [0-9]{2}\:[0-9]{2}$/',
	        'tipoimagem' => 'required',
	        'imagemurl'=>'required_if:tipoimagem,img-url',
	        'imagemarquivo'=>'required_if:tipoimagem,img-file|image',
	        'conteudo'=>'required',
	        'status'=>'required|boolean'
	    ];

		if( $imgarq ) {
			$rules['imagemarquivo'] = 'required_if:imgarq,false|image';
		}

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	        'titulo.required' => 'O Título é Obrigatório',
	        'periodo.required'  => 'O Período é obrigatorio',
	        'imagemurl.required_if'  => 'A URL da imagem é obrigatória',
	        'imagemarquivo.required_if'  => 'O Arquivo da imagem é obrigatório',
	        'conteudo.required'  => 'O Conteúdo é obrigatorio',
	        'status.required'  => 'O Status é obrigatorio',

	       	'titulo.max' => 'O Título ultrapassa o limite de 255 caracteres',
	        'periodo.regex'  => 'O Perído não está no padrão exigido',
	        'status.required'  => 'O valor do Status não corresponde ao esperado',
	        'imagemarquivo.image'=>'Apenas arquivos com a extensão: .png, .jpg, .bmp e .gif',
	    ];
	}

	private function dateTimeBanco( $data )
	{
		$dia = substr($data, 0,2);
		$ano = substr($data, 6,4);
		
		// Inclusao dos segundos
		return str_replace([$dia.'/','/'.$ano], [$ano.'-','-'.$dia], $data).':00';
	}

	private function dateTimeBr($data)
	{
		$dia = substr($data, 0,4);
		$ano = substr($data, 8,2);
		
		// Retorna sem os segundos
		return substr( str_replace([$dia.'-','-'.$ano], [$ano.'/','/'.$dia], $data),0,16);
	}
}
