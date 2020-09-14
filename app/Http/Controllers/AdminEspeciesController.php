<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\Especie;
use Redirect;

use Illuminate\Support\Facades\Request;

class AdminEspeciesController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Especies de Protesto');
		view()->share('page_description','Edição, criação e exclusão de especies de protesto');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$especies = Especie::paginate(10);

		$especies->setPath('especies');
		return view('admin.especies.home')->with('especies',$especies);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$especies = new Especie;    
        return view('admin.especies.editar')
        	   ->with('especies',$especies);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$especie= new Especie;
		$especie->nome = Input::get('nome');
		$especie->status = Input::get('status',0);
		$especie->codigo = Input::get('codigo',0);
		$especie->save();

		return redirect('admin/especies/'.$especie->id.'/edit')->with('sucesso',true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$especies = Especie::find($id);
		return view('admin.especies.visualizar')
			   ->with('especies',$especies);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$especies = Especie::find($id);
		return view('admin.especies.editar')
				->with('especies',$especies);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$especie = Especie::find($id);
		$especie->nome = Input::get('nome');
		$especie->codigo = Input::get('codigo',0);
		$especie->status = Input::get('status', 0);
		$especie->save();

		return redirect('admin/especies/'.$id.'/edit')->with('sucesso',true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Especie::find($id)->delete();
   		return redirect('admin/especies')->with('sucesso',true);
	}

}
