<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use DB;
use Auth;
use App\SiteContato;

use Illuminate\Http\Request;

class AdminSiteContatosController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Contatos');
		view()->share('page_description','Listagem de Mensagens de Contato');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		// If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        if( $user->papel_id!=1 ){
            $registros = SiteContato::join('cartorios','cartorios.id','=','site_contatos.cartorio')
                                   ->join('users','cartorios.id','=','users.cartorio_id')
            					   ->where('users.id','=', $user->id);
        }else{
        	$registros = SiteContato::where('cartorio', '=', '');
        }

		if( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$registros = $registros::where('nome','like',$pesquisar)
				->orWhere('assunto','like',$pesquisar)
				->orWhere('mensagem','like',$pesquisar)
				->select('id','nome','email','assunto','mensagem',
					DB::raw("date_format(created_at,'%d/%m/%Y %H:%i:%s') as created_at_br"));
		}
		// else
		// {
		// 	$registros = $registros::select('id','nome','email','assunto','mensagem',
		// 			DB::raw("date_format(created_at,'%d/%m/%Y %H:%i:%s') as created_at_br"));
		// }

        $registros = $registros->orderBy('created_at','desc')
                               ->paginate(10);

		// for paginate purpose, set the path that will apear on the links
		$registros->setPath('contatos');

		return view('admin.site-contatos.home')
			->with('registros',$registros);
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
		$registro = SiteContato::find($id);

		return view('admin.site-contatos.editar')->with('registro',$registro);
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
		$registro = SiteContato::find($id);

		$registro->delete();

		return redirect('admin/contatos')
			->with('sucesso',true);
	}

}
