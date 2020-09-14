<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Legislacao;
use App\TipoLegislacao;
use Input;
use Auth;
use File;

class AdminLegislacaoController extends Controller
{
    public function __construct()
	{
		view()->share('page_title','Legislação');
		view()->share('page_description','Edição, criação e exclusão de Legislação');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		if ( Input::get('pesquisar') )
		{
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
			$legislacao = Legislacao::join('users','users.id','=','legislacoes.user_id')
				->join('tipo_legislacoes','legislacoes.tipo_legislacao_id','=','tipo_legislacoes.id')
				->select('users.name as name','legislacoes.*','tipo_legislacoes.descricao as categoria')
                ->orWhere('legislacoes.descricao','like',$pesquisar)
				->orWhere('tipo_legislacoes.descricao','like',$pesquisar)
				->orderBy('legislacoes.created_at','desc')
				->paginate(10);
		}
		else
		{
			$legislacao = Legislacao::join('users','users.id','=','legislacoes.user_id')
				->join('tipo_legislacoes','legislacoes.tipo_legislacao_id','=','tipo_legislacoes.id')
				->select('users.name as name','legislacoes.*','tipo_legislacoes.descricao as categoria')
                ->orderBy('legislacoes.created_at','desc')
                ->paginate(10);
		}

		$legislacao->setPath('legislacao');

      	return view('admin.legislacoes.home')
      		->with('legislacao',$legislacao);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$legislacoes = new Legislacao;

        $tipoLegislacoes = TipoLegislacao::orderBy('descricao')->get();

        return view('admin.legislacoes.editar')
        ->with('legislacoes',$legislacoes)
        ->with('tipoLegislacoes',$tipoLegislacoes);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Se não houver falhas
        $legislacoes = new Legislacao;
        
        $legislacoes->descricao = Input::get('descricao');
        $legislacoes->status = Input::get('tipostatus');
        $legislacoes->tipo_legislacao_id = Input::get('tipoLegislacoes');
        $legislacoes->user_id = Auth::user()->id;

        // Tratamento da Imagem
        if( Input::get('tipoarquivo')=='arq-url' )
        {
            $legislacoes->arquivo_url = Input::get('arquivourl');
            $legislacoes->save();
        }
        else
        {
            $arquivo = Input::file('arquivofile');
        	$extensao = $arquivo->getClientOriginalExtension();
            File::move( $arquivo, public_path().'/images/legislacoes-id_'.$legislacoes->id.'.'.$extensao);
            $legislacoes->arquivo = '/images/legislacoes-id_'.$legislacoes->id.'.'.$extensao;
            $legislacoes->save();
        }

        return redirect('admin/legislacoes/'.$legislacoes->id.'/edit')
        ->with('sucesso',true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$legislacoes = Legislacao::find($id);
        $tipoLegislacoes = TipoLegislacao::orderBy('descricao')->get();

        return view('admin.legislacoes.editar')
        ->with('legislacoes',$legislacoes)
        ->with('tipoLegislacoes',$tipoLegislacoes);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$legislacoes = Legislacao::find($id);
		if ($legislacoes->arquivo != null){
			File::delete(public_path().$legislacoes->arquivo);
		}
		$legislacoes->delete();
		return redirect('admin/legislacoes');
	}
}
