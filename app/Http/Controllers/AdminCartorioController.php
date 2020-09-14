<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cartorio;
use App\CartorioResponsavel;
use App\Cidade;
use App\TipoContato;
use App\TipoAtribuicao;
use App\TipoResponsavel;
use App\Banco;
use App\Contato;
use App\Atribuicao;
use App\CartorioBanco;
use Input;
Use Auth;
use File;

use DB;

use Illuminate\Support\Facades\Request;

class AdminCartorioController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Cartórios');
		view()->share('page_description','Edição, criação e exclusão de Cartórios');
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$user = Auth::user();
		$cidades = Cidade::where('estado_id','10')->get();

		if( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$cartorios = Cartorio::join('cidades','cidades.id','=','cartorios.cidade_id')
			->select('cidades.nome as cidade','cartorios.*')
			->where('cartorios.nome','like',$pesquisar)
			->orWhere('cartorios.cnpj','like',$pesquisar)
			->orWhere('cidades.nome','like',$pesquisar)
			->orderBy('created_at','desc');
		} else {
			$cartorios = Cartorio::leftjoin('cidades','cidades.id','=','cartorios.cidade_id')
			->select('cidades.nome as cidade','cartorios.*')
			->orderBy('cidade','asc');
		}

		// Se for associado, retorna apenas o cartorio cadastrado por ele
		if( $user->papel_id!=1 )
		{
			$cartorios = $cartorios->join('users','users.cartorio_id','=', 'cartorios.id')
			->where('users.id','=', $user->id);
		}

		$cartorios = $cartorios->paginate(10);
		$cartorios->setPath('cartorios');

		return view('admin.cartorios.home')
		->with('cartorios',$cartorios)
		->with('associado', $user->papel_id==5?true:false )
		->with('cidades',$cidades);
	}

	public function postUpload()
	{
		$cartorioId = Input::get('id');
		if( $cartorioId )
		{
			// Find cartorio
			$cartorio = Cartorio::find($cartorioId);

			// file upload
			$file = Input::file('arquivo');
			$extensao = $file->getClientOriginalExtension();

			File::move( $file, public_path().'/arquivos/cartorio-id_'.$cartorioId.'.'.$extensao );
			$cartorio->upload = '/arquivos/cartorio-id_'.$cartorioId.'.'.$extensao;
			$cartorio->save();

			return redirect('admin/cartorios')
				->with('sucesso',true);
		}

		return redirect('admin/cartorios')
			->with('erro',true);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{
		$cidades = Cidade::where('estado_id','10')->get();
		$tipoContatos = TipoContato::all();
		$tipoAtribuicoes = TipoAtribuicao::all();
		$tipoResponsaveis = TipoResponsavel::all();
		$bancos = Banco::all();

		// Minimun requirement
		$contatos[] = new Contato;
		$contatos[] = new Contato;
		$contatos[] = new Contato;
		$contatos[] = new Contato;
		$totalContatos = 4;

		$tipoAtribuicoes = TipoAtribuicao::all();

		return view('admin.cartorios.criar')
		->with('cartorio', new Cartorio)
		->with('tabeliao', new CartorioResponsavel)
		->with('substituto', new CartorioResponsavel)
		->with('responsavel', new CartorioResponsavel)
		->with('contatos', $contatos)
		->with('totalContatos', $totalContatos)
		->with('cidades',$cidades)
		->with('tipoContatos',$tipoContatos)
		->with('tipoResponsaveis',$tipoResponsaveis)
		->with('bancos',$bancos)
		->with('cartorioBanco',new CartorioBanco)
		->with('tipoAtribuicoes',$tipoAtribuicoes)
		->with('oficiounico', false);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{
		$user = Auth::user();

		if( !$user->cartorio_id )
		{
			try {

				DB::transaction(function(){

					$request=Request::all();
					$idCidade = Cidade::where('ibge',$request['cidadeIBGE'])->first()->id;

					// Aba Informações, Localização
					$cartorio = new Cartorio;
					$cartorio->nome          = $request['nome'];
					if(strlen($request['cnpj'])>0){
						$cartorio->cnpj          = $request['cnpj'];
					}elseif( strlen($request['tabeliaoCPF'])>0 ){
						$cartorio->cnpj          = $request['tabeliaoCPF'];
					}
					$cartorio->cep           = $request['cep'];
					$cartorio->cidade_id     = $idCidade;
					$cartorio->endereco      = $request['endereco'];
					$cartorio->bairro        = $request['bairro'];
					$cartorio->numero        = $request['numero'];
					$cartorio->complemento   = $request['complemento']?$request['complemento']:'';

					$cartorio->site          = $request['site']?$request['site']:'';
					$cartorio->informatizado = $request['optradio'];
					$cartorio->empresainfo   = $request['empreFornNome']?$request['empreFornNome']:'';
					$cartorio->responsavelinfo   = $request['empreFornResp']?$request['empreFornResp']:'';
					$cartorio->contatoinfo   = $request['empreFornTel']?$request['empreFornTel']:'';
					$cartorio->save();

					$cartorioID = $cartorio->id;

					// Abas Tabeliao, Responsavel e Substituto
					$tipoResponsaveis = TipoResponsavel::pluck('slug','id');
					// responsaveis - Titular, substituto e responsavel
					foreach ($tipoResponsaveis as $key => $value) {
						$responsavel = new CartorioResponsavel;
						$responsavel->cartorio_id=$cartorioID;
						$responsavel->tipo_responsavel_id=$key; // Tabelião ou Titular
		                $responsavel = $this->montarResponsavel($responsavel,$request, $value);
						$responsavel->save();
					}

					// Aba Contatos
					// Telefone 1 and 2 - Mandatory
					foreach ($request['contact'] as $key => $value) {
						if( $value['type'] ){
							$cartorioContatos = new Contato;
							$cartorioContatos->cartorio_id     = $cartorioID;
							$cartorioContatos->tipocontato_id = $value['type'];
							$cartorioContatos->contato         = $value['number'];
							$cartorioContatos->save();
							// Contato::create($cartorioContatos->toArray());
						}
					}

					// Aba de Atribuições
					$informatizado = Input::get('informatizado',array());
					foreach ($request['atribuicoes'] as $key => $value) {
						$cartorioAtribuicoes = new Atribuicao;
						$cartorioAtribuicoes->cartorio_id        = $cartorioID;
						$cartorioAtribuicoes->tipoatribuicao_id  = $value;
						// Checa se essa atribuição foi informatizada
						$cartorioAtribuicoes->informatizado = isset($informatizado[$key])?true:false;
						$cartorioAtribuicoes->save();
						$cartorioAtribuicoes->save();
					}

					// Aba de Dados Bancarios
					$cartorioBancoFavorecido = new CartorioBanco;
					$cartorioBancoFavorecido->cartorio_id     = $cartorioID;
					$cartorioBancoFavorecido->banco_id        = $request['banco_id'];
					$cartorioBancoFavorecido->favorecido      = $request['favorecido'];
					$cartorioBancoFavorecido->cpf_cnpj        = $request['ident']['1']['number'];
					$cartorioBancoFavorecido->tipo_favorecido = $request['ident']['1']['type'];
					$cartorioBancoFavorecido->agencia         = $request['agencia'];
					if( $request['optionsConta']=='cc' ){
						$cartorioBancoFavorecido->conta_corrente  = $request['conta'];
					}
					else{
						$cartorioBancoFavorecido->conta_poupanca  = $request['conta'];
					}
					$cartorioBancoFavorecido->save();

					$user = Auth::user();
					if( $user->papel_id==5 ){
						$user->cartorio_id = $cartorio;
						$user->save();
					}
				});

				$cartorioID = Cartorio::where('cnpj','=',Input::get('cnpj')?Input::get('cnpj'):Input::get('tabeliaoCPF'))->first()->id;

				return redirect('admin/cartorios/'.$cartorioID.'/edit')->with('sucesso',true);

			} catch (Exception $e) {
				return redirect('admin/cartorios/create')
					->with('error',false)
					->withInput();
			}
		}

	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		$cartorio = Cartorio::select('cidades.nome as cidade','cidades.uf as uf','cartorios.*')
		->leftJoin('cidades','cidades.id','=','cartorios.cidade_id')
		->where('cartorios.id',$id)
		->first();

		$contatos = Contato::join('tipo_contatos','tipo_contatos.id','=','contatos.tipocontato_id')
		->select('contatos.*','tipo_contatos.nome as tipo')
		->where('cartorio_id',$id)
		->orderBy('tipocontato_id','asc')
		->get();

		$tipoAtribuicoes = TipoAtribuicao::leftJoin('atribuicoes','tipo_atribuicoes.id','=','tipoatribuicao_id')
			->select('informatizado','tipo_atribuicoes.nome','tipo_atribuicoes.id','tipoatribuicao_id as marcado')
			->where('cartorio_id',$id)
			->get();

		$banco = CartorioBanco::leftJoin('bancos','bancos.id','=','cartorio_bancos.banco_id')
		->select('cartorio_bancos.*','bancos.nome as banco')
		->where('cartorio_id',$id)
		->orderBy('created_at','asc')
		->first();
		if(!$banco) $banco = new CartorioBanco;

		// Tabeliao, Substituto, Responsavel
		$tabeliao = CartorioResponsavel::getResponsavel($id,'tabeliao');
		if( !$tabeliao ) $tabeliao = new CartorioResponsavel;
		$substituto = CartorioResponsavel::getResponsavel($id,'substituto');
		if( !$substituto ) $substituto = new CartorioResponsavel;
		$responsavel = CartorioResponsavel::getResponsavel($id,'responsavel');
		if( !$responsavel ) $responsavel = new CartorioResponsavel;

		return view('admin.cartorios.visualizar')
		->with('cartorio',$cartorio)
		->with('contatos',$contatos)
		->with('atribuicoes',$tipoAtribuicoes)
		->with('tabeliao',$tabeliao)
		->with('substituto',$substituto)
		->with('responsavel',$responsavel)
		->with('banco',$banco);
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
		// Get cartorio info
		$cartorio = Cartorio::select('cidades.nome as cidade','cidades.uf as uf','cidades.ibge as ibge','cartorios.*')
			->leftJoin('cidades','cidades.id','=','cartorios.cidade_id')
			->find($id);

		// Tabeliao, Substituto, Responsavel
		$tabeliao = CartorioResponsavel::getResponsavel($id,'tabeliao');
		if( !$tabeliao ) $tabeliao = new CartorioResponsavel;
		$substituto = CartorioResponsavel::getResponsavel($id,'substituto');
		if( !$substituto ) $substituto = new CartorioResponsavel;
		$responsavel = CartorioResponsavel::getResponsavel($id,'responsavel');
		if( !$responsavel ) $responsavel = new CartorioResponsavel;

		//Get all contatos
		$contatos = Contato::where('cartorio_id',$id)
			->join('tipo_contatos','tipo_contatos.id','=','tipocontato_id')
			->select('contatos.*','tipo_contatos.nome as tipo_contato')
			->orderBy("contatos.id",'asc')
			->get();
		$totalContatos = $contatos->count();
		if( $totalContatos < 4){
			for ($i=$totalContatos; $i < 4; $i++) {
				$contatos[$i] = new Contato;
			}
		}

		// Get all attributions
		$totalAtribuicoes = TipoAtribuicao::join('atribuicoes','tipo_atribuicoes.id','=','tipoatribuicao_id')
			->count();
		$tipoAtribuicoes = TipoAtribuicao::leftJoin('atribuicoes', function($join) use ($id){
			$join->on('tipo_atribuicoes.id','=','tipoatribuicao_id');
			$join->on('cartorio_id','=',DB::raw($id));
		})
		->select('atribuicoes.informatizado','tipo_atribuicoes.nome','tipo_atribuicoes.id','tipoatribuicao_id as marcado')
		->get();

		// Checa se o cartorio é de oficio unico - Se possui todas as atribuições
		$oficiounico = ($tipoAtribuicoes->count()==$totalAtribuicoes)?true:false;

		// Bank Info
		$cartorioBanco = CartorioBanco::leftJoin('bancos','bancos.id','=','cartorio_bancos.banco_id')
			->select('cartorio_bancos.*','bancos.nome as banco','bancos.id as idBanco')
			->where('cartorio_id',$id)
			->orderBy('created_at','asc')
			->first();
		if(!$cartorioBanco) $cartorioBanco = new CartorioBanco;


		// Get default values
		$tipoContatos = TipoContato::all();
		// $tipoAtribuicoes = TipoAtribuicao::all();
		$tipoResponsaveis = TipoResponsavel::all();
		$bancos = Banco::all();

		return view('admin.cartorios.criar')
			->with('cartorio',$cartorio)
			->with('tabeliao',$tabeliao)
			->with('substituto',$substituto)
			->with('responsavel',$responsavel)
			->with('contatos',$contatos)
			->with('totalContatos',$totalContatos)
			->with('oficiounico',$oficiounico)
			->with('bancos',$bancos)
			->with('cartorioBanco',$cartorioBanco)
			->with('tipoContatos',$tipoContatos)
			->with('tipoAtribuicoes',$tipoAtribuicoes)
			->with('tipoResponsaveis',$tipoResponsaveis);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
		try{
			DB::transaction(function() use ($id){

				$cartorioID = $id;
				$request = array();
				$idCidade = array();

				$request=Request::all();

				$idCidade = Cidade::where('ibge',$request['cidadeIBGE'])->first()->id;

				// Cartorio
				$cartorio = Cartorio::find($id);
				$cartorio->nome          = $request['nome'];
	            if(strlen($request['cnpj'])>0){
	            	$cartorio->cnpj          = $request['cnpj'];
	            }elseif( strlen($request['tabeliaoCPF'])>0 ){
	            	$cartorio->cnpj          = $request['tabeliaoCPF'];
	            }
	            $cartorio->cep           = $request['cep'];
	            $cartorio->cidade_id     = $idCidade;
	            $cartorio->endereco      = $request['endereco'];
	            $cartorio->bairro        = $request['bairro'];
	            $cartorio->numero        = $request['numero'];
	            $cartorio->complemento   = $request['complemento'];
	            $cartorio->site          = $request['site'];
	            $cartorio->informatizado = $request['optradio'];
	            $cartorio->empresainfo   = Input::get('empreFornNome','');
	            $cartorio->responsavelinfo   = $request['empreFornResp'];
	            $cartorio->contatoinfo   = $request['empreFornTel'];

				$arquivo = Input::file('arquivo');
				if( $arquivo ){
					$path = '/arquivos/cartorio-id_'.$cartorioID.'.'.$extensao;
					$extensao = $arquivo->getClientOriginalExtension();
					File::move( $arquivo, public_path().$path );
					$cartorio->upload = $path;
				}

				$cartorio->save();

				// Abas Tabeliao, Responsavel e Substituto
	            $tipoResponsaveis = TipoResponsavel::pluck('slug','id');
				CartorioResponsavel::where('cartorio_id',$cartorioID)->delete();
	            foreach ($tipoResponsaveis as $key => $value) {
					$responsavel = new CartorioResponsavel;
					$responsavel->cartorio_id=$cartorioID;
					$responsavel->tipo_responsavel_id=$key; // Tabelião ou Titular
	                $responsavel = $this->montarResponsavel($responsavel, $request, $value);
	                $responsavel->save();
	            }

				// Telefone 1 and 2, Cellphone are Mandatory
				Contato::where('cartorio_id',$cartorioID)->delete();
				foreach ($request['contact'] as $key => $value) {
					if( $value['type'] ){
	                    $cartorioContatos = new Contato;
	                    $cartorioContatos->cartorio_id     = $cartorioID;
	                    $cartorioContatos->tipocontato_id = $value['type'];
	                    $cartorioContatos->contato         = $value['number'];
	                    $cartorioContatos->save();
	                }
				}

				$informatizado = Input::get('informatizado',array());
				Atribuicao::where('cartorio_id',$cartorioID)->delete();
				foreach ($request['atribuicoes'] as $key => $value) {
	                $cartorioAtribuicoes = new Atribuicao;
	                $cartorioAtribuicoes->cartorio_id        = $cartorioID;
	                $cartorioAtribuicoes->tipoatribuicao_id  = $value;
	                // Checa se essa atribuição foi informatizada
	                $cartorioAtribuicoes->informatizado = isset($informatizado[$key])?true:false;
	                $cartorioAtribuicoes->save();
	            }

				// Banco
				#$cartorioBancoFavorecido = new CartorioBanco::where('cartorio_id',$cartorioID)->first();
				CartorioBanco::where('cartorio_id',$cartorioID)->delete();
				$cartorioBancoFavorecido = new CartorioBanco;
				$cartorioBancoFavorecido->banco_id        = $request['banco_id'];
				$cartorioBancoFavorecido->cartorio_id     = $cartorioID;
				$cartorioBancoFavorecido->cidade_id       = $idCidade;
				$cartorioBancoFavorecido->favorecido      = $request['favorecido'];
				$cartorioBancoFavorecido->cpf_cnpj        = $request['ident']['1']['number'];
				$cartorioBancoFavorecido->tipo_favorecido = $request['ident']['1']['type'];
				$cartorioBancoFavorecido->agencia         = $request['agencia'];
				if( $request['optionsConta']=='cc' ){
					$cartorioBancoFavorecido->conta_corrente  = $request['conta'];
				}
				else{
					$cartorioBancoFavorecido->conta_poupanca  = $request['conta'];
				}
				$cartorioBancoFavorecido->save();
			});

			return redirect('admin/cartorios/'.$id.'/edit')->with("success",true);

		}catch(Exception $e){

			return redirect('admin/cartorios/'.$id.'/edit')
				->with("success",false)
				->withInput();
		}

	}
	/**
	* Manage the tabelião data.
	*
	* @param  int cartorioId, resquest
	* @return array
	*/

	private function montarResponsavel($responsavel, $request, $tipoResponsavel){
		$responsavel->nome=$request[$tipoResponsavel.'Nome'];
		$responsavel->cpf=$request[$tipoResponsavel.'CPF'];
		$responsavel->rg=$request[$tipoResponsavel.'RG'];
		if( $tipoResponsavel=='tabeliao' ){
			$responsavel->endereco=$request[$tipoResponsavel.'Endereco'];
			$responsavel->numero=$request[$tipoResponsavel.'Numero'];
			$responsavel->bairro=$request[$tipoResponsavel.'Bairro'];
			$responsavel->cep=$request[$tipoResponsavel.'CEP'];
			$responsavel->complemento=$request[$tipoResponsavel.'Complemento'];

			if( $request[$tipoResponsavel.'CidadeIBGE'] ){
				$cidadeId = Cidade::where('ibge',$request[$tipoResponsavel.'CidadeIBGE'])->first()->id;
				$responsavel->cidade_id = $cidadeId;
			}
		}
		$responsavel->tel=$request[$tipoResponsavel.'Telefone'];
		$responsavel->cel1=$request[$tipoResponsavel.'Celular1'];
		$responsavel->cel2=$request[$tipoResponsavel.'Celular2'];
		$responsavel->email=$request[$tipoResponsavel.'Email'];

		return $responsavel;
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		DB::transaction(function() use ($id){
			CartorioResponsavel::where('cartorio_id',$id)->delete();
			Contato::where('cartorio_id',$id)->delete();
			Atribuicao::where('cartorio_id',$id)->delete();
			CartorioBanco::where('cartorio_id',$id)->delete();
			Cartorio::find($id)->delete();
		});

		return redirect('admin/cartorios')->with('error',true);
	}

}
