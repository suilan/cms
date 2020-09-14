<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\ArquivoBoleto;
use App\Cartorio;
use DB;

class PesquisaEditalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$documento = Input::get('documento');

		$registros = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
				->select('arquivo_remessa_boleto_dets.id as id','nome_apresentante','especie_titulo',DB::raw('date_format(data_emissao_titulo,"%d/%m/%Y") as data_emissao_titulo'),
						DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),'valor_total_boleto','valor_custas_emolumento','valor_principal_titulo','nome_sacado', 'endereco_sacado',
						'protocolo', DB::raw('date_format(STR_TO_DATE(data_apontamento,"%d%m%Y"),"%d/%m/%Y") as data_apontamento'), 'numero_titulo','data_vencimento_titulo')
				->where('documento_sacado','=',$documento)
				->where(DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y")'),'>=',DB::raw('curdate()'))
				->first();
		
		// Endereço do 2 cartório
		$enderecoCartorio = Cartorio::join('cartorio_responsavels','cartorio_responsavels.cartorio_id','=','cartorios.id')
							->where('cartorios.id','=',194)
							->where('cartorio_responsavels.tipo_responsavel_id','=','9')
							->first();
		
		return view('ieptbma::jornal/resultadobusca')
				   ->with('documento',$documento)
				   ->with('registros',$registros)
				   ->with('enderecoCartorio', $enderecoCartorio);
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
		return view('ieptbma::jornal/resultadobusca')
			   ->with('documento',$id);
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