<?php 
namespace Ielop\Ieptbma\Controllers;

use Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\SiteContato;
use App\Especie;
use App\AnuenciaPDF;
use App\PromissoriaPDF;
use App\DesistenciaPDF;

class ModelosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$especies = Especie::all();

		return view('ieptbma::modelo')
		->with('especies', $especies);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$return = array();
		// A propria controller ja trata a validação, se falhar, 
		//ela mesma faz o redirect para a pagian anterior
		//$validator = Validator::make( $request->all(), $this->validationRules(), $this->validationMessages() );

		// if ( !$validator->fails() ) {
			if ($request->tipo_modelo == 'anum'){
				$imagePath = null;
				$image = $request->file('img_empresa');
				
				if ($image){
					$name = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('/images');
					$image->move($destinationPath, $name);

					$imagePath = $destinationPath.'/'.$name;
				}
				
				$fpdf = new AnuenciaPDF();
				$fpdf->AddPage();
				$fpdf->content( $request, $imagePath);
				$fpdf->Output();
				exit;
			} else if ($request->tipo_modelo == 'prom') {
				$fpdf = new PromissoriaPDF();
				$fpdf->AddPage();
				$fpdf->content( $request );
				$fpdf->Output();
				exit;
			} else if ($request->tipo_modelo == 'desist') {
				$fpdf = new DesistenciaPDF();
				$fpdf->AddPage();
				$fpdf->content( $request );
				$fpdf->Output();
				exit;
			}
		// } else {
		// 	return redirect('modelos')
		// 	->with('error',true)
        //     ->withInput();
		// }
	}

	// PRIVATE METHODS
	private function validationRules(){
		$rules = [
	        'credor' => 'required|max:255',
	        'cnpj' => 'required|max:255',
	        'cep' => 'required|max:255',
			'devedor' => 'required|max:300',
			'documento' => 'required|max:300',
			'num_titulo' => 'required|max:300',
			'especie' => 'required|max:300',
			'valor' => 'required|max:300',
			'emissao_titulo' => 'required|max:300',
			'vencimento_titulo' => 'required|max:300'
	    ];

		return  $rules;
	}

	private function validationMessages()
	{
	    return [
	        'credor.required' => 'O Credor é Obrigatório',
	        'cnpj.required'  => 'O CNPJ do Credor é obrigatório',
	        'cep.required'  => 'O CEP é obrigatório',
			'devedor.required'  => 'O Devedor é obrigatório',
			'documento.required'  => 'O Documento do devedor é obrigatório',
			'num_titulo.required'  => 'O Número do título é obrigatório',
			'especie.required'  => 'O Número da espécie é obrigatório',
			'valor.required'  => 'O Valor do Título é obrigatório',
			'emissao_titulo.required'  => 'A Data de Emissão do Título é obrigatória',
			'vencimento_titulo.required'  => 'A Data de Vencimento do Título é obrigatória'
	    ];
	}

}
