<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Download;
use App\User;
use DB;

class JornaisController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $downloads = Download::join('users','users.id','=','downloads.user_id')
        	->select('downloads.*',DB::raw("date_format(downloads.created_at,'%d/%m/%Y') as data_postagem"))
			->where('status','1')
			->whereNull('users.cartorio_id')
			->where('downloads.categoria_downloadid','=','3')
			->orderBy('downloads.created_at','desc')
            ->paginate(6);

		return view('ieptbma::jornal/jornais')
                    ->with('downloads',$downloads);
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
		$downloads = Download::join('users','users.id','=','downloads.user_id')
        	->select('downloads.*',DB::raw("date_format(downloads.created_at,'%d/%m/%Y') as data_postagem"))
			->where('status','1')
			->whereNull('users.cartorio_id')
			->where('downloads.id','=',$id)
			->where('downloads.categoria_downloadid','=','3')
			->orderBy('downloads.created_at','desc')
			->paginate(6);
			
		return view('ieptbma::jornal/jornaldoprotestoma')
                    ->with('downloads',$id);
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