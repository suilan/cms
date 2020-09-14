<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Noticia;
use App\NoticiaGaleria;
use DB;
use Input;

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

		if( Input::get('busca') ){
			$pesquisar = '%'.str_replace(' ','%',Input::get('busca')).'%';
			$noticias = Noticia::where('status','=','1')
						 ->join('users','users.id','=','noticias.user_id')
						 ->whereNull('users.cartorio_id')
						 ->where(function($query) use ($pesquisar){
							$query->orWhere('titulo','like',$pesquisar)
						 	      ->orWhere('conteudo','like',$pesquisar);
						 })->orderBy('noticias.created_at','desc')
						 ->select( $columns )
						 ->paginate(6);
		} else {
			$noticias = Noticia::where('status','=','1')
				->join('users','users.id','=','noticias.user_id')
				->whereNull('users.cartorio_id')
				->orderBy('noticias.created_at','desc')
				->select( $columns )
				->paginate(6);
		}

		return view('ieptbma::noticias')->with('noticias',$noticias)->with('mes',$months);
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
