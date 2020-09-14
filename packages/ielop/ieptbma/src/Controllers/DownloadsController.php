<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Download;
use App\User;

class DownloadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $downloads = Download::join('users','users.id','=','downloads.user_id')
			->where('status','1')
			->whereNull('users.cartorio_id')
			->where('downloads.categoria_downloadid','<>','3')
            ->get();

		return view('ieptbma::downloads')
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
                $downloads = Download::where('slug','=', $id)
                        ->join('users','users.id','=','downloads.user_id')
                        ->first();

		return view('site/links-uteis/download')->with('downloads',$downloads);	
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
