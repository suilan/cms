<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App\Download;
use App\User;
use App\CategoriaDownload;
use Auth;
use Redirect;
use File;

class AdminDownloadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
    {
            view()->share('page_title','Arquivos para downloads');
            view()->share('page_description','Criação e uploads de arquivos para Download');
    }

	public function index()
	{
        if( Input::get('pesquisar') )
        {
                $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
                $downloads = Download::join('users','users.id','=','downloads.user_id')
                        ->select('users.name','downloads.*')
                        ->where('titulo','like',$pesquisar)
                        ->orWhere('conteudo','like',$pesquisar);
        }
        else
        {
                $downloads = Download::join('users','users.id','=','downloads.user_id')
                        ->select('users.name','downloads.*');
        }

        // If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $downloads = $downloads->where('downloads.user_id','=', $user->id);
        }

        $downloads = $downloads->orderBy('created_at','desc')
                               ->paginate(10);


        $downloads->setPath('downloads');

        return view('admin.downloads.home')
                ->with('downloads',$downloads);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
                $downloads = new Download;

                $categoriadownloads = CategoriaDownload::orderBy('descricao')->get();

                return view('admin.downloads.criar')
                ->with('downloads',$downloads)
                ->with('categoriadownload',$categoriadownloads);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
                // A propria controller ja trata a validação, se falhar, 
                //ela mesma faz o redirect para a pagian anterior
                //$this->validate( $request, $this->validationRules(), $this->validationMessages() );

                // Se não houver falhas
                $downloads = new Download;
                $downloads->titulo = Input::get('titulo');
                $downloads->slug = str_slug( $downloads->titulo , "-");
                $downloads->conteudo = Input::get('conteudo');
                $downloads->status = Input::get('tipostatus');
                $downloads->categoria_downloadid = Input::get('categoriadownload');
                $downloads->user_id = Auth::user()->id;
                $downloads->save();                

                // Tratamento da Imagem
                if( Input::get('tipoarquivo')=='arq-url' )
                {
                    $downloads->arquivo_url = Input::get('arquivourl');
                    $downloads->save();
                }
                else
                {
                    $arquivo = Input::file('arquivofile');
            	    $extensao = $arquivo->getClientOriginalExtension();
                    File::move( $arquivo, public_path().'/images/downloads-id_'.$downloads->id.'.'.$extensao );
                    $downloads->arquivo = '/images/downloads-id_'.$downloads->id.'.'.$extensao;
                    $downloads->save();
                }

                return redirect('admin/downloads/'.$downloads->id.'/edit')
                ->with('sucesso',true);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
        public function show($id)
        {
            $downloads = Download::find($id);
            return view('admin.downloads.visualizar')->with('downloads',$downloads);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */

	public function edit($id)
	{
                $downloads = Download::find($id);
                $categoriadownloads = CategoriaDownload::orderBy('descricao')->get();

                if( Input::old('_token') ){
                        $downloads->titulo 	= Input::old('titulo');
                        $downloads->status 	= Input::old('tipostatus');
                        $downloads->arquivo_url = Input::old('arquivourl');
                        $downloads->arquivo 	= Input::old('arquivofile');
                        $downloads->conteudo 	= Input::old('conteudo');
                }
                return view('admin.downloads.editar')->with('downloads',$downloads)->with('categoriadownload',$categoriadownloads);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
                // A propria controller ja trata a validação, se falhar, 
                //ela mesma faz o redirect para a pagian anterior
                $this->validate( $request,
                                $this->validationRules(Input::get('tipoarquivo')=='arq-file' && Input::get('arqfile')),
                                $this->validationMessages() );

                // Se não houver falhas
                $downloads = Download::find( $id );
                $downloads->titulo 	               = Input::get('titulo');
                $downloads->slug 	               = str_slug( $downloads->titulo , "-");
                $downloads->conteudo               = Input::get('conteudo');
                $downloads->status 	               = Input::get('tipostatus');
                $downloads->categoria_downloadid = Input::get('categoriadownload');
                $downloads->user_id 	           = Auth::user()->id;

                // Tratamento da Imagem
                if( Input::get('tipoarquivo')=='arq-url' )
                {
                        $downloads->arquivo_url = Input::get('arquivourl');
                        if( $downloads->arquivo_url ){
                                $downloads->arquivo = '';
                        }

                        $downloads->save();
                }
                else
                {
                        // Se já tiver arguma imagem ou se for submetida uma nova
                        if( !Input::get('arqfile') || Input::file('arquivofile') )
                        {
                                // Apaga qualquer imagem  da u rl
                                $downloads->arquivo_url = '';

                                $arquivo = Input::file('arquivofile');
                        	$extensao = $arquivo->getClientOriginalExtension();
                                File::move( $arquivo, public_path().'/images/download-id_'.$downloads->id.'.'.$extensao );
                                $downloads->arquivo = '/images/download-id_'.$downloads->id.'.'.$extensao;
                        }

                        $downloads->save();
                }

                	return redirect('admin/downloads/'.$downloads->id.'/edit')
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
                $downloads = Download::find($id);

                File::delete(public_path().$downloads->arquivo);
                $downloads->delete();
                return redirect('admin/downloads');

	}
    // PRIVATE METHODS
    private function validationRules( $arqfile = false ){
            $rules = [
            'titulo' => 'required|max:255',
            'tipoarquivo' => 'required',
            'arquivourl'=>'required_if:tipoarquivo,arq-url',
            'arquivofile'=>'required_if:tipoarquivo,arq-file|mimes',
            'conteudo'=>'required',
            'tipostatus'=>'required|boolean'
        ];

            if( $arqfile ) {
                    $rules['arquivofile'] = 'required_if:arqfile,false|mimes:zip,pdf';
            }
            return  $rules;

    }

    private function validationMessages()
    {
        return [
            'titulo.required' => 'O Título é Obrigatório',
            'arquivourl.required_if'  => 'A URL do arquivo é obrigatória',
            'arquivofile.required_if'  => 'O Arquivo é obrigatório',
            'conteudo.required'  => 'O Conteúdo é obrigatorio',
            'tipostatus.required'  => 'O Status é obrigatorio',

            'titulo.max' => 'O Título ultrapassa o limite de 255 caracteres',
            'tipostatus.required'  => 'O valor do Status não corresponde ao esperado',
            'arquivofile.mimes'=>'Apenas arquivos com a extensão: .png, .jpg, .bmp e .gif, .mp4, .avi, .pdf, .zip, .rar',
        ];
    }
}
