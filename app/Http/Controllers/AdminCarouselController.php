<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App\ImagemCarousel;
use App\User;
use Auth;
use Redirect;
use File;
use Intervention\Image\ImageManagerStatic as Image;


class AdminCarouselController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    // Sizes that are used in the images crop process
    private $imgSize = array(
        array(50,40),
        array(1416,446),
        array(3430,1135)
    );

    public function __construct()
    {
            view()->share('page_title','Carousel');
            view()->share('page_description','Criação e uploads das imagens do Carousel');
    }

	public function index()
	{
        //Start the search
        $ImagemCarousel = ImagemCarousel::join('users','users.id','=','imagem_carousels.user_id')
                ->select('users.name','imagem_carousels.*');

        //If there is a search
        if( Input::get('pesquisar') )
        {
            $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
            $ImagemCarousel = $ImagemCarousel->where('titulo','like',$pesquisar);
        }

        // If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $ImagemCarousel = $ImagemCarousel->where('imagem_carousels.user_id','=', $user->id);
        }

        // Paginate and set the paginate path
        $ImagemCarousel = $ImagemCarousel->orderBy('created_at','desc')->paginate(10);
        $ImagemCarousel->setPath('carousel');

        return view('admin.carousel.home')
                ->with('carousel',$ImagemCarousel);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
        $carousel = new ImagemCarousel;

        return view('admin.carousel.editar')
            ->with('carousel',$carousel);

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
        $this->validate( $request, $this->validationRules(), $this->validationMessages() );

        // Se não houver falhas
        $carousel = new ImagemCarousel;
        $this->loadValues($carousel);

        return redirect('admin/carousel/'.$carousel->id.'/edit')
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
        $carousel = ImagemCarousel::find($id);
        $user = User::find($carousel->user_id);
        $page_description = 'Data: '.date('d/m/Y',strtotime($carousel->created_at)).
            ' -- Usuário: '.$user->name;

        return view('admin.carousel.visualizar')
                ->with('carousel',$carousel)
                ->with('user', $user);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $carousel = ImagemCarousel::find($id);

        // Se houver dados de formularios anteriores
        if( Input::old('_token') ){
            $carousel->titulo 	= Input::old('titulo');
            $carousel->status 	= Input::old('tipostatus');
            $carousel->imagem_url = Input::old('imagemurl');
            $carousel->imagem 	= Input::old('imagemarquivo');
            $carousel->conteudo 	= Input::old('conteudo');
        }

        return view('admin.carousel.editar')->with('carousel',$carousel);

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
        $this->validationRules(Input::get('tipoimagem')=='img-file' && Input::get('imgarq')),
        $this->validationMessages() );

        // Se não houver falhas
        $carousel = ImagemCarousel::find( $id );
        $this->loadValues($carousel);

        return redirect('admin/carousel/'.$carousel->id.'/edit')
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
        $carousel = ImagemCarousel::find($id);
        File::delete(public_path().$carousel->imagem);
        $carousel->delete();
        return redirect('admin/carousel')
            ->with('sucesso',true);

	}

   // PRIVATE METHODS
    private function validationRules( $imgarq = false )
   {
        $rules = [
            'titulo' => 'required|max:255',
            'tipoimagem' => 'required',
            'imagemurl'=>'required_if:tipoimagem,img-url',
            'imagemarquivo'=>'required_if:tipoimagem,img-file|image',
            'tipostatus'=>'required|boolean'
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
            'imagemurl.required_if'  => 'A URL da imagem é obrigatória',
            'imagemarquivo.required_if'  => 'O Arquivo da imagem é obrigatório',
            'tipostatus.required'  => 'O Status é obrigatorio',

            'titulo.max' => 'O Título ultrapassa o limite de 255 caracteres',
            'tipostatus.required'  => 'O valor do Status não corresponde ao esperado',
            'imagemarquivo.image'=>'Apenas arquivos com a extensão: .png, .jpg, .bmp e .gif',
        ];
    }

    private function loadValues($carousel)
    {
        $carousel->titulo   = Input::get('titulo');
        $carousel->slug     = str_slug( $carousel->titulo , "-");
        $carousel->status   = Input::get('tipostatus');
        $carousel->user_id  = Auth::user()->id;
        $carousel->link = Input::get('link');
        $carousel->save();

        // Tratamento da Imagem
        if( Input::get('tipoimagem')=='img-url' )
        {
            $url = Input::get('imagemurl');
            $header = get_headers($url);

            // if has header and is not 404 status(not found)
            if( sizeof($header)>0 && substr_count($header[0], '404')==0)
            {
                $extension = pathinfo($url,PATHINFO_EXTENSION);
                $position = strpos($extension,'?');
                if( $position>-1 ){
                    $extension = substr($extension, 0,$position);
                }

                if( $extension ){
                    $newName = '/images/carousel-id_'.$carousel->id.'.'.$extension;
                }
                else{
                    $newName = '/images/carousel-id_'.$carousel->id;
                }

                // Get image online
                $ch = curl_init($url);
                $fp = fopen( public_path().$newName, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                
                $carousel->imagem_url = $url;
                $carousel->imagem = $newName;

                // Erase resized images
                for ($i=0; $i < sizeof($this->imgSize); $i++) { 
                    $carousel->eraseImage($this->imgSize[$i][0],$this->imgSize[$i][1]);
                }
            }

            $carousel->save();
        }
        else
        {
            // Se já tiver alguma imagem ou se for submetida uma nova
            if( !Input::get('imgarq') || Input::file('imagemarquivo') )
            {
                // Apaga qualquer imagem da url
                $carousel->imagem_url = '';

                $imagem = Input::file('imagemarquivo');
                $extensao = $imagem->getClientOriginalExtension();
                $pathImg = '/images/carousel-id_'.$carousel->id.'.'.$extensao;
                File::move( $imagem, public_path().$pathImg );
                $carousel->imagem = $pathImg;

                // Crop image
                for ($i=0; $i < sizeof($this->imgSize); $i++) { 
                    $img = Image::make(public_path().$carousel->imagem)
                        ->fit($this->imgSize[$i][0], $this->imgSize[$i][1])
                        ->save(public_path().'/images/carousel-id_'.$carousel->id.'-'.$this->imgSize[$i][0].'x'.$this->imgSize[$i][1].'.'.$extensao);
                }
            }

            $carousel->save();
        }
    }
}
