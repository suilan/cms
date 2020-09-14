<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\Endosso;
use Redirect;

use Illuminate\Support\Facades\Request;

class AdminEndossosController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Tipos de Endosso');
		view()->share('page_description','Edição, criação e exclusão de tipos de endosso');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$tiposEndossos = Endosso::paginate(10);
		$tiposEndossos->setPath('tiposEndossos');
		return view('admin.endossos.home')->with('tiposEndossos',$tiposEndossos);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tiposEndossos = new Endosso;    
        return view('admin.endossos.editar')
        	   ->with('tiposEndossos',$tiposEndossos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$endosso= new Endosso;
		$endosso->nome = Input::get('nome');
		$endosso->status = Input::get('status',0);
		$endosso->save();

		return redirect('admin/endossos')->with('sucesso',true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tiposEndossos = Endosso::find($id);
		return view('admin.endossos.visualizar')
			   ->with('tiposEndossos',$tiposEndossos);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tiposEndossos = Endosso::find($id);
		return view('admin.endossos.editar')
				->with('tiposEndossos',$tiposEndossos);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$endosso = Endosso::find($id);
		$endosso->nome = Input::get('nome');
		$endosso->status = Input::get('status', 0);
		$endosso->save();

		return redirect('admin/endossos/'.$id.'/edit')->with('sucesso',true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Endosso::find($id)->delete();
   		return redirect('admin/endossos')->with('sucesso',true);
	}

}
