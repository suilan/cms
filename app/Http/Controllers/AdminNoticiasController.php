<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;
use App\Noticia;
use App\NoticiaImagem;
use App\User;
use Redirect;
use Session;
use File;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class AdminNoticiasController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Notícias');
		view()->share('page_description','Edição, criação e exclusão de notícias no site');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        Session::forget('noticia');

		if ( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$noticia = Noticia::join('users','users.id','=','noticias.user_id')
				->select('users.name as name','noticias.*')
                ->orWhere('conteudo','like',$pesquisar)
				->orWhere('titulo','like',$pesquisar)
                ->orWhere('users.name','like',$pesquisar);
		}
		else
		{
			$noticia = Noticia::join('users','users.id','=','noticias.user_id')
                ->select('users.name','noticias.*');
		}

        // If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $noticia = $noticia->where('noticias.user_id','=', $user->id);
        }

        $noticia = $noticia->orderBy('created_at','desc')
                           ->paginate(10);
        $noticia->setPath('noticias');

  		return view('admin.noticias.home')
  		->with('noticia',$noticia);
	}

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create(Request $request)
        {
            $noticia = new Noticia;
            $noticia->titulo = Input::old('titulo');
            $noticia->status = Input::old('status');
            // $noticia->user_id = Input::old('user_id');
            // $noticia->slug = Input::old('slug');
            // $noticia->imagem = Input::old('imagem');
            // $noticia->imagem_url = Input::old('imagem_url');
            // $noticia->descricao = Input::old('descricao');
            $noticia->conteudo = Input::old('conteudo');

            return view('admin.noticias.editar')
                ->with('registro',$noticia);

        }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $extensao = "";
        // A propria controller ja trata a validação, se falhar,
        //ela mesma faz o redirect para a pagian anterior

        $this->validate( $request, $this->validationRules(), $this->validationMessages() );

		$noticia = new Noticia;
		$noticia->titulo      = Input::get('titulo');
		$noticia->slug        = str_slug( $noticia->titulo , "-");
		$noticia->status      = Input::get('tipostatus');
		$noticia->conteudo    = Input::get('conteudo');
		$noticia->descricao 	= str_limit(trim(trim(html_entity_decode(strip_tags($noticia->conteudo)),chr(0xC2).chr(0xA0))),200);
		$noticia->user_id     = Auth::user()->id;
        $noticia->save();


        return redirect('admin/noticias/'.$noticia->id.'/edit')
            ->with('sucesso',true);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
        //	public function show($id)
	//{
		//
	//}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$noticia = Noticia::find($id);

        // Se houver dados de formularios anteriores
        if( Input::old('_token') )
		{
            $noticia->titulo 	= Input::old('titulo');
            $noticia->status 	= Input::old('tipostatus');
            $noticia->conteudo 	= Input::old('conteudo');
        }

        return view('admin.noticias.editar')
            ->with('registro',$noticia);
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
        $this->validate( $request, $this->validationRules(), $this->validationMessages() );

        // Se não houver falhas
        $noticia = Noticia::find( $id );
        $noticia->titulo 	= Input::get('titulo');
        $noticia->slug 		= str_slug( $noticia->titulo , "-");
		$noticia->conteudo 	= Input::get('conteudo');
        $noticia->descricao = str_limit(trim(trim(html_entity_decode(strip_tags($noticia->conteudo)),chr(0xC2).chr(0xA0))),200);
        $noticia->status 	= Input::get('tipostatus');
        $noticia->user_id 	= Auth::user()->id;
        $noticia->save();


        return redirect('admin/noticias/'.$noticia->id.'/edit')
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
		$noticia = Noticia::find($id);
		File::delete(public_path().$noticia->imagem);
		$noticia->delete();
		return redirect('admin/noticias');
	}

    // PRIVATE METHODS
    private function validationRules(){
        $rules = [
            'titulo' => 'required|max:255',
            // 'tipoimagem' => 'required',
            // 'imagemurl'=>'required_if:tipoimagem,img-url',
            // 'imagemarquivo'=>'required_if:tipoimagem,img-file|image',
            'conteudo'=>'required',
            'tipostatus'=>'required|boolean'
        ];

        return  $rules;

    }

    private function validationMessages()
    {
        return [
            'titulo.required' => 'O Título é Obrigatório',
            'imagemurl.required_if'  => 'A URL da imagem é obrigatória',
            'imagemarquivo.required_if'  => 'O Arquivo da imagem é obrigatório',
            'conteudo.required'  => 'O Conteúdo é obrigatorio',
            'tipostatus.required'  => 'O Status é obrigatorio',

            'titulo.max' => 'O Título ultrapassa o limite de 255 caracteres',
            'tipostatus.required'  => 'O valor do Status não corresponde ao esperado',
            'imagemarquivo.image'=>'Apenas arquivos com a extensão: .png, .jpg, .bmp e .gif',
        ];
    }

}
