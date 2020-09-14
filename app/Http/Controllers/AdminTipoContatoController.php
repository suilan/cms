<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\TipoContato;
use Redirect;
use Form;

use Illuminate\Support\Facades\Request;

class AdminTipoContatoController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Tipos de contato');
		view()->share('page_description','Edição, criação e exclusão de tipos de contato');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$tiposContatos = TipoContato::paginate(10);
		$tiposContatos->setPath('tiposContatos');
		return view('admin.tipocontatos.home')->with('tiposContatos',$tiposContatos);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tiposContatos = new TipoContato;    
        return view('admin.tipocontatos.criar')
        	   ->with('tiposContatos',$tiposContatos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$tiposContatos=Request::all();
		TipoContato::create($tiposContatos);
		return redirect('admin/tipocontatos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tiposContatos = TipoContato::find($id);
		return view('admin.tipocontatos.visualizar')
			   ->with('tiposContatos',$tiposContatos);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tiposContatos = TipoContato::find($id);
		return view('admin.tipocontatos.editar')
				->with('tiposContatos',$tiposContatos);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tiposContatosUpdate=Request::all();
		$tiposContatos = TipoContato::find($id);
		$tiposContatos->update($tiposContatosUpdate);
		return redirect('admin/tipocontatos');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		TipoContato::find($id)->delete();
   		return redirect('admin/tipocontatos');
	}

}
