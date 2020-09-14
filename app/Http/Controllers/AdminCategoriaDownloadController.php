<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CategoriaDownload;
use Illuminate\Http\Request;
use Input;

class AdminCategoriaDownloadController extends Controller {


    public function __construct()
    {
        view()->share('page_title','Categorias para downloads');
        view()->share('page_description','Edição, criação de categorias para download');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $categoriasDownload = CategoriaDownload::paginate(10);
        $categoriasDownload->setPath('categoriadownloads');
        return view('admin.categoriadownload.home')
            ->with('categoriasDownload',$categoriasDownload);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categoriasDownload = new CategoriaDownload;
        return view('admin.categoriadownload.criar')
            ->with('categoriadownload',$categoriasDownload);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $categoriasDownload = new CategoriaDownload;
        $categoriasDownload->descricao = Input::get('descricao');
        $categoriasDownload->save();

        return redirect('admin/categoriadownloads/'.$categoriasDownload->id.'/edit')
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
        $categoriasDownload = CategoriaDownload::find($id);
        return view('admin.categoriadownload.visualizar')->with('categoriadownload',$categoriasDownload);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $categoriasDownload = CategoriaDownload::find($id);
        // Se houver dados de formularios anteriores
        if( Input::old('_token') ){
            $categoriasDownload->descricao 	= Input::old('descricao');
        }
        return view('admin.categoriadownload.editar')->with('categoriadownload',$categoriasDownload);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        // Se não houver falhas
        $categoriasDownload = CategoriaDownload::find( $id );

        $categoriasDownload->descricao 	= Input::get('descricao');
        $categoriasDownload->save();

        return redirect('admin/categoriadownloads/'.$categoriasDownload->id.'/edit')
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
        $categoriasDownload = CategoriaDownload::find($id);
        $categoriasDownload->delete();
        return redirect('admin/categoriadownloads');
	}
}
