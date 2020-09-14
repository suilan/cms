<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RemessaBoleto;
use App\ArquivoBoletoDet;

use Carbon\Carbon;

use Input;
use DB;

class AdminRemessaBoletoController extends Controller
{
    public function __construct()
	{
		view()->share('page_title','Remessas de Boletos');
		view()->share('page_description','Edição, criação e exclusão de Remessas de Boletos');
    }
    
    public function index()
	{
		if ( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

			$remessaBoleto = RemessaBoleto::WhereNull('status')
				->orWhere('titulo','like',$pesquisar)
                ->orWhere('users.name','like',$pesquisar);
		}
		else
		{
			$remessaBoleto = RemessaBoleto::WhereNull('status');
		}

        $remessaBoleto = $remessaBoleto->orderBy('created_at','desc')
						   			   ->paginate(10);
						   
        $remessaBoleto->setPath('remessaboleto');

  		return view('admin.remessaboleto.home')
  		->with('remessaboleto',$remessaBoleto);
	}

	public function show($id){
		$qtdTitulos = RemessaBoleto::select('quantidade_remessa as qtdTitulos')
					  ->where('id',$id)->first();

		$qtdTitulosAVencer = RemessaBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
							 ->where('arquivo_remessa_boletos.id',$id)
							 ->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'>=',Carbon::now()->setTimezone('America/Fortaleza')->toDateString())
							 ->count();

		$qtdTitulosImpressos = ArquivoBoletoDet::where('id_arquivo_boleto',$id)
							 ->where('impresso','<>',0)
							 ->count();
		
		$registros = RemessaBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
		->select('arquivo_remessa_boleto_dets.id as id','nome_apresentante','especie_titulo',DB::raw('date_format(STR_TO_DATE(data_apontamento,"%d%m%Y"),"%d/%m/%Y") as data_emissao_titulo'),DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),'valor_total_boleto','valor_custas_emolumento','valor_principal_titulo','impresso')
		->where('id_arquivo_boleto',$id)
		->orderBy('arquivo_remessa_boleto_dets.data_emissao_titulo','desc',DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y")'),'desc')
		->paginate(10);

		$registros->setPath('remessaboleto');

		return view('admin.remessaboleto.visualizar')
		->with('qtdTitulos',$qtdTitulos)
		->with('qtdTitulosAVencer',$qtdTitulosAVencer)
		->with('qtdTitulosImpressos',$qtdTitulosImpressos)
		->with('registros',$registros);
	}

	public function destroy($id)
	{
		RemessaBoleto::find($id)->delete();
		return redirect('admin/remessaboleto')->with('sucesso',true);
	}
}