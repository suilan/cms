<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;

use App\User;
use App\Representante;

use App\ArquivoBoleto;
use App\Cidade;
use Carbon\Carbon;

use Redirect;
use Session;
use File;
use DB;

use Intervention\Image\ImageManagerStatic as Image;

class AdminRepresentanteBoletoController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Credenciamento de Representantes');
		view()->share('page_description','');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		if( Input::get('pesquisar') ){
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

			if(Auth::user()->papel_id != 2){
				$registros = Representante::where('user_id','=',Auth::user()->id)
											->where(function($query) use ($pesquisar){
												$query->orWhere('cnpj','like',$pesquisar)
													->orWhere('razao','like',$pesquisar);
											})
											->get();
			} else {
				$registros = Representante::where('cnpj','like',$pesquisar)
											->orWhere('razao','like',$pesquisar)
											->get();
			}
		}else {
			if(Auth::user()->papel_id != 2){
				$registros = Representante::where('user_id','=',Auth::user()->id)
										->get();
			} else {
				$registros = Representante::get();
			}
		}
		
		return view('admin.representante.home')
				->with('registros', $registros);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request){
		$registro = new Representante;

		return view('admin.representante.editar')
		->with('registro',$registro);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request){
        $this->validate( $request, $this->validationRules(), $this->validationMessages() );

		$representante = new Representante;

		$idCidade = Cidade::where('ibge',Input::get('cidade'))->get()->toArray();
		
		$representante->user_id  = Auth::user()->id;
		$representante->razao   = Input::get('razao');
		$representante->cnpj   = Input::get('cnpj');
		$representante->cep = Input::get('cep');
		$representante->cidade_id = $idCidade[0]['id'];
		$representante->endereco = Input::get('endereco');
		$representante->bairro = Input::get('bairro');
		$representante->numero = Input::get('numero');
		$representante->complemento = Input::get('complemento');
		$representante->telefone = Input::get('telefone');
		$representante->email = Input::get('email');
		$representante->creden = 0;
		$representante->save();

		$contratosocial = Input::file('contratosocial');
		if ($contratosocial) {
			$extensao = $contratosocial->getClientOriginalExtension();
			File::move( $contratosocial, public_path().'/representante/contratosocial-id_'.$representante->id.'.'.$extensao );
			$representante->contratosocial = '/representante/contratosocial-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$cartaocnpj = Input::file('cartaocnpj');
		if ($cartaocnpj) {
			$extensao = $cartaocnpj->getClientOriginalExtension();
			File::move( $cartaocnpj, public_path().'/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao );
			$representante->cartaocnpj = '/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$procuracao = Input::file('procuracao');
		if ($procuracao) {
			$extensao = $procuracao->getClientOriginalExtension();
			File::move( $procuracao, public_path().'/representante/procuracao-id_'.$representante->id.'.'.$extensao );
			$representante->procuracao = '/representante/procuracao-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

        return redirect('admin/representante')
            ->with('sucesso',true);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
        //	public function show($id)
	//{
		//
	//}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$representante = Representante::find($id);

        // Se houver dados de formularios anteriores
        if( Input::old('_token') )
		{
			$representante->razao   = Input::old('razao');
			$representante->cnpj   = Input::old('cnpj');
			$representante->cep = Input::old('cep');
			$representante->cidade_id = Input::old('cidade');
			$representante->endereco = Input::old('endereco');
			$representante->bairro = Input::old('bairro');
			$representante->numero = Input::old('numero');
			$representante->complemento = Input::old('complemento');
			$representante->telefone = Input::old('telefone');
			$representante->email = Input::old('email');

			$contratosocial = Input::file('contratosocial');
			if ($contratosocial) {
				$extensao = $contratosocial->getClientOriginalExtension();
				File::move( $contratosocial, public_path().'/representante/contratosocial-id_'.$representante->id.'.'.$extensao );
				$representante->contratosocial = '/representante/contratosocial-id_'.$representante->id.'.'.$extensao;
				$representante->save();
			}

			$cartaocnpj = Input::file('cartaocnpj');
			if ($cartaocnpj) {
				$extensao = $cartaocnpj->getClientOriginalExtension();
				File::move( $cartaocnpj, public_path().'/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao );
				$representante->cartaocnpj = '/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao;
				$representante->save();
			}

			$procuracao = Input::file('procuracao');
			if ($procuracao) {
				$extensao = $procuracao->getClientOriginalExtension();
				File::move( $procuracao, public_path().'/representante/procuracao-id_'.$representante->id.'.'.$extensao );
				$representante->procuracao = '/representante/procuracao-id_'.$representante->id.'.'.$extensao;
				$representante->save();
			}
        }

        return view('admin.representante.editar')
            ->with('registro',$representante);
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$representante = Representante::find($id);

		$representante->razao   = Input::get('razao');
		$representante->cnpj   = Input::get('cnpj');
		$representante->cep = Input::get('cep');
		$representante->cidade_id = Input::get('cidade');
		$representante->endereco = Input::get('endereco');
		$representante->bairro = Input::get('bairro');
		$representante->numero = Input::get('numero');
		$representante->complemento = Input::get('complemento');
		$representante->telefone = Input::get('telefone');
		$representante->email = Input::get('email');
		$representante->save();

		$contratosocial = Input::file('contratosocial');
		if ($contratosocial) {
			$extensao = $contratosocial->getClientOriginalExtension();
			File::move( $contratosocial, public_path().'/representante/contratosocial-id_'.$representante->id.'.'.$extensao );
			$representante->contratosocial = '/representante/contratosocial-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$cartaocnpj = Input::file('cartaocnpj');
		if ($cartaocnpj) {
			$extensao = $cartaocnpj->getClientOriginalExtension();
			File::move( $cartaocnpj, public_path().'/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao );
			$representante->cartaocnpj = '/representante/cartaocnpj-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		$procuracao = Input::file('procuracao');
		if ($procuracao) {
			$extensao = $procuracao->getClientOriginalExtension();
			File::move( $procuracao, public_path().'/representante/procuracao-id_'.$representante->id.'.'.$extensao );
			$representante->procuracao = '/representante/procuracao-id_'.$representante->id.'.'.$extensao;
			$representante->save();
		}

		return redirect('admin/representante')
            ->with('sucesso',true);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$representante = Representante::find($id);
		$representante->delete();

		return redirect('admin/representante');
	}

    // PRIVATE METHODS
    private function validationRules(){
        $rules = [
            'razao' => 'required',
            'cnpj' => 'required',
            'cep' => 'required'
        ];

        return  $rules;

    }

    private function validationMessages()
    {
        return [
            'razao.required' => 'Razão social é Obrigatório',
            'cnpj.required_if'  => 'CNPJ é obrigatória',
            'cep.required_if'  => 'O CEP obrigatório'
        ];
    }

}
