<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Noticia;
use DB;

use Illuminate\Http\Request;

class NoticiasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Replace maonths returned by database
		$months = ['Jan' => 'Jan','Feb' => 'Fev','Mar' => 'Mar','Apr' => 'Abr','May' => 'Mai',
		'Jun' => 'Jun','Jul' => 'jul','Aug' => 'Ago','Sep' => 'Set','Oct' => 'Out','Nov' => 'Nov','Dec' => 'Dez'];
		
		$columns = ['titulo','descricao', 'slug',
			DB::raw("date_format(noticias.created_at,'%d') as dia"),
			DB::raw("date_format(noticias.created_at,'%b') as mes"),
			"imagem_url",'imagem','conteudo'];

		$noticias = Noticia::join('users','users.id','=','noticias.user_id')
			->where('users.papel_id',1)
			->where('noticias.status','=','1')
			->orderBy('noticias.created_at','desc')
			->select( $columns )
			->paginate(6);

		return view('new.noticias')->with('noticias',$noticias)->with('mes',$months);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$noticia = Noticia::where('slug','=', $id)
			->select('noticias.*','users.name')
			->join('users','users.id','=','noticias.user_id')
			->first();

		return view('new.noticia')->with('noticia',$noticia);
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
