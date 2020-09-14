<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use App\Download;
use App\User;
use App\Edital;
use App\EditalPdf;
use App\Cartorio;
use App\Cidade;
use App\Titulo;
use App\TituloPdf;
use Auth;
use DB;
use Input;
use Request;

class EditaisController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipoConsulta = Input::get('tipo-consulta','1');

		$search = array();
		$search['tipo-consulta'] = Input::get('tipo-consulta',1);
		$search['tipo-documento'] = Input::get('tipo-documento',1);
		$search['documento'] = Input::get('documento');
		$search['nome'] = Input::get('nome');
		$search['municipio'] = Input::get('municipio');

		if( $tipoConsulta==1 )
		{
			$registros = Edital::leftJoin('remessas','remessas.edital_id','=','editais.id')
			    ->leftJoin('titulos','titulos.remessa_id','=','remessas.id')
			    ->leftJoin('devedores','titulos.devedor_id','=','devedores.id')
			    ->leftJoin('cartorios','remessas.cartorio_id','=','cartorios.id')
			    ->select('editais.id',DB::raw('count( distinct remessas.id) as qtd_remessas'),
			        'cartorios.nome as cartorio_nome', 'editais.created_at',
			        DB::raw('count(distinct titulos.id) as qtd_titulos'),'editais.cancelado')
			    ->where('editais.cancelado','=',0)
			    ->where('titulos.cancelado','=',0)
			    ->where('remessas.cancelado','=',0)
			    ->groupBy('edital_id')
			    ->orderBy('id','desc');
		}
		else{
			$registros = Titulo::leftJoin('cartorios','titulos.cartorio_id','=','cartorios.id')
				->leftJoin('devedores','titulos.devedor_id','=','devedores.id')
				->leftJoin('remessas','titulos.remessa_id','=','remessas.id')
				->where('titulos.cancelado','=',0)
				->where('remessas.cancelado','=',0)
				->select('titulos.*','devedores.nome as devedor_nome','cartorios.nome as cartorio_nome',
					'devedores.documento', 'remessas.edital_id',
					DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%m/%d/%Y\') as vencimento'))
				->orderBy('id','desc');
		}   

		// Documento CPF ou CNPJ
		$documento = Input::get('documento');
		if( $documento )
		{
			$registros = $registros->where('devedores.documento','=',$documento);
		}

		// Nome Devedor
		$nomeDevedor = Input::get('nome');
		if( $nomeDevedor )
		{
			$registros = $registros->where('devedores.nome','like','%'.str_replace(' ', '%', $nomeDevedor).'%');
		}

		// Id do Cartorio
		$municipioID = Input::get('municipio');
		if( $municipioID )
		{
			$registros = $registros->where('cartorios.cidade_id','=',$municipioID);
		}

		$registros = $registros->get();
		$municipios = Cidade::where('uf','=','MA')->lists('nome','id');

		return view('site.edital')
            ->with('registros', $registros)
            ->with('search', $search)
            ->with('municipios', $municipios);
	}

	public function show($id)
	{
		header('Content-Type: application/pdf');
		header("Content-Disposition: attachment; filename=\"edital_$id.pdf\"");
		$titulos = Titulo::join('devedores','devedores.id','=','titulos.devedor_id')
		    ->join('especies','especies.id','=','titulos.especie_id')
		    ->join('cidades','cidades.id','=','devedores.cidade_id')
		    ->join('endossos','endossos.id','=','titulos.endosso_id')
		    ->join('remessas','remessas.id','=','titulos.remessa_id')
		    ->join('editais','editais.id','=','remessas.edital_id')
		    ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento', 'devedores.tipo_doc',
		        'devedores.endereco','devedores.numero','devedores.bairro','devedores.cep',
		        'cidades.nome as cidade','cidades.uf','endossos.nome as endosso_nome',
		        DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%m/%d/%Y\') as emissao'),
		        DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%m/%d/%Y\') as vencimento'),'especies.nome as especie_nome',
		        DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo'),
		        DB::raw('format(`titulos`.`valor`,2,\'de_DE\') as valor') )
		    ->where('editais.id','=',$id)
		    ->get();

		$usuario = Auth::user();

		$fpdf = new EditalPdf();
		$fpdf->edital=Edital::find($id);

		// Check if has titulos and if it does, 
		// load the cartorio from the first result 
		if( $titulos->count()>0 )
		{
		    $fpdf->cartorio = Cartorio::join('cidades','cidades.id','=','cartorios.cidade_id')
		        ->leftJoin('cartorio_responsavels','cartorio_responsavels.cartorio_id','=','cartorios.id')
		        ->where('cartorios.id','=',$titulos[0]->cartorio_id)
		        ->where('cartorio_responsavels.tipo_responsavel_id','=',9) // Tabelião
		        ->first(array('cartorios.*','cartorio_responsavels.nome as responsavel_nome','cidades.nome as cidade_nome','cidades.uf'));
		}

		$fpdf->AddPage();
        $fpdf->textoLegal();
		foreach ($titulos as $t) {
		    
		    $fpdf->content( $t );
		}

		$fpdf->Output();
		exit;
	}

	public function getTitulo($id)
	{
        $titulo = Titulo::leftJoin('devedores','devedores.id','=','titulos.devedor_id')
            ->leftJoin('especies','especies.id','=','titulos.especie_id')
            ->leftJoin('cidades','cidades.id','=','devedores.cidade_id')
            ->leftJoin('endossos','endossos.id','=','titulos.endosso_id')
            ->where('titulos.id','=',$id)
            ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento',
                'devedores.endereco','devedores.numero','devedores.bairro','devedores.cep',
                'cidades.nome as cidade','cidades.uf','endossos.nome as endosso_nome',
                DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%m/%d/%Y\') as emissao'),
                DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%m/%d/%Y\') as vencimento'),'especies.nome as especie_nome',
                DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo'),
                DB::raw('format(`titulos`.`valor`,2,\'de_DE\') as valor') )
            ->first();

        $cartorio = Cartorio::join('cidades','cidades.id','=','cartorios.cidade_id')
            ->where('cartorios.id','=', $titulo->cartorio_id)
            ->first(array('cartorios.*','cidades.nome as cidade_nome','cidades.uf'));

        $fpdf = new TituloPdf();
        $fpdf->AddPage();
        $fpdf->content( $titulo, $cartorio );
        $fpdf->Output();
        exit;
	}

	
}
