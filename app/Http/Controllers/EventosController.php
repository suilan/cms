<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Evento;
use DB;

class EventosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$eventosProximos = Evento::join('users','users.id','=','eventos.user_id')
			->where('users.papel_id',1)
			->where('data_final','>=',date('Y-m-d H:i:s') )
			->where('status','=',1)
			->orderBy('data_final')
			->get();

		$eventoPassados = Evento::join('users','users.id','=','eventos.user_id')
			->where('users.papel_id',1)
			->where('data_final','<',date('Y-m-d H:i:s') )
			->where('status','=',1)
			->orderBy('data_final')
			->select('*',DB::raw("date_format(eventos.created_at,'%d') as dia"),
			DB::raw("date_format(eventos.created_at,'%b') as mes"))
			->paginate(6);


		// Replace maonths returned by database
		$months = ['Jan' => 'Jan','Feb' => 'Fev','Mar' => 'Mar','Apr' => 'Abr','May' => 'Mai',
		'Jun' => 'Jun','Jul' => 'jul','Aug' => 'Ago','Sep' => 'Set','Oct' => 'Out','Nov' => 'Nov','Dec' => 'Dez'];

		return view('new.eventos')
			->with('eventosProximos',$eventosProximos)
			->with('eventosPassados',$eventoPassados)
			->with('mes', $months);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	//
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	// public function store()
	// {
	// 	//
	// }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$evento = Evento::where('slug','=', $id)
			->join('users','users.id','=','eventos.user_id')
			->first();

		return view('new.evento')
			->with('evento',$evento);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function edit($id)
	// {
	// 	//
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function update($id)
	// {
	// 	//
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function destroy($id)
	// {
	// 	//
	// }

}
