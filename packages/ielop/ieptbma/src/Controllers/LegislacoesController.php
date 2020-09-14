<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Legislacao;
use DB;

use Illuminate\Http\Request;

class LegislacoesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$legislacao = Legislacao::orderBy('tipo_legislacao_id','created_at','desc')->get();

        return view('ieptbma::legislacao')
            ->with('legislacao',$legislacao);
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
			->where('status','=', 1)
			->select('noticias.*','users.name')
			->join('users','users.id','=','noticias.user_id')
			->first();

		$images = NoticiaGaleria::where('noticia_id','=',$noticia->id)
			->whereNotNull('path')
			->get();
		//return view('new.noticia')->with('noticia',$noticia);
		return view('default.noticia')
			->with('imagens',$images)
			->with('noticia',$noticia);
	}

}
