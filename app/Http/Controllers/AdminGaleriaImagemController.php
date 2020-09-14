<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GaleriaImagem;
use App\Galeria;
use App\ImageRepository;
use Input;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminGaleriaImagemController extends Controller
{	
    public function __construct()
	{
		view()->share('page_title','Galeria de Imagens');
		view()->share('page_description','Edição, criação e exclusão de Galeria de Imagens');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$geleria = Galeria::join('users','users.id','=','albuns.user_id')
				->select('users.name as name','albuns.*')
                ->orWhere('albuns.descricao','like',$pesquisar)
				->orderBy('albuns.created_at','desc')
				->paginate(10);
		}
		else
		{
			$geleria = Galeria::join('users','users.id','=','albuns.user_id')
				->select('users.name as name','albuns.*')  
				->orderBy('albuns.created_at','desc')
				->paginate(10);
		}

		$geleria->setPath('galeria_imagens');

      	return view('admin.galeria.home')
      		->with('geleria',$geleria);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$galeria = new GaleriaImagem;

        return view('admin.galeria.editar')
        ->with('galeria',$galeria);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$album = "Teste de galeria de imagem";
		
		$galeria = new Galeria;
        $galeria->user_id = Auth::user()->id;
        $galeria->descricao = $album;
        $albumId = $galeria->save();

		$image = new ImageRepository;
		$photo = Input::all();

        $response = $image->upload($photo, $albumId);

        return redirect('admin/galeria/'.$albumId.'/edit')
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

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
