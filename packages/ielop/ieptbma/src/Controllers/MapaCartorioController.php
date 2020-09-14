<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cidade;
use App\Cartorio;
use Geocode;

use Response;

use Illuminate\Support\Facades\Request;

class MapaCartorioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cartorios = Cartorio::select('cartorios.id as id_cartorio','cartorios.nome as cartorio','cidades.nome as municipio','estados.nome as estado', 'cidades.id as municipio_id', 'cartorios.*','cidades.*')
					 ->join('cidades','cidades.id','=','cartorios.cidade_id')
					 ->join('estados','estados.id','=','cidades.estado_id')
					 ->where('estado_id','10')
					 ->whereNotNull('cartorios.latitude')
					 ->orderBy('cidades.id')->get();
		
		$cidades = Cidade::join('estados','estados.id','=','cidades.estado_id')
				   ->select('cidades.nome as cidade', 'cidades.id as id_municipio')
				   ->where('estado_id','10')
				   ->orderBy('cidades.id')->get();

		// for($i = 0; $i < count($cartorios); $i++){
		// 	$id_cartorio = $cartorios[$i]->id_cartorio;
		// 	$endereco_cartorio = $cartorios[$i]->endereco. ', ' .$cartorios[$i]->numero. ' - ' .$cartorios[$i]->municipio. ' - ' .$cartorios[$i]->estado. ' - Brazil, ' .$cartorios[$i]->cep;
		// 	$geolocalization = Geocode::make()->address($endereco_cartorio);
			
		// 	if($geolocalization){
		// 		$cartorio = Cartorio::find($id_cartorio);
		// 		$cartorio->latitude = $geolocalization->latitude();
		// 		$cartorio->longitude = $geolocalization->longitude();

		// 		$cartorio->save();
		// 	}
		// }

		return view('ieptbma::mapa')
				->with('cartorios',$cartorios)
				->with('cidades',$cidades);

	}

	public function retornaCartorioMunicipio($municipioId){
		$cartorios = Cartorio::where('cidade_id',$municipioId)->get();
		return Response::json($cartorios);
	}

	public function retornaCartorio($cartorio){
		$cartorios = Cartorio::find($cartorio);
		return Response::json($cartorios);
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
		//
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
