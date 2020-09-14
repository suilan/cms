<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Auth;
use App\User;
use App\Especie;
use App\Perfil;
use App\Pagina;
use App\Permissao;
use Redirect;
use DB;

class AdminPerfilController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Perfis de Acessos dos Usuários');
		view()->share('page_description','Edição, criação e exclusão dos perfis de acessos e usuários');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$user = Auth::user();

		$perfil = Perfil::where('id','>=',$user->papel_id)
		          		  ->paginate(10);
		$perfil->setPath('perfil');
		return view('admin.perfil.home')
		       ->with('registros',$perfil);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$perfil = new Perfil;   
		$paginas = Pagina::where('admin','=',1)
			->where('status','=',1)
			->orderBy('pai')
			->orderBy('nome')
			->select('paginas.*')
			->get();     

		if( Input::old('nome') ) {
			$perfil->nome = Input::old('nome');
			$perfil->descricao = Input::old('descricao');
			$perfil->status = Input::old('status');

			$selected = Input::old('paginas');
			foreach($paginas as $key => $p) {
				if( isset($selected[$p->id]) ){
					$p->selecionado=1;
				} 
			}
		}

        return view('admin.perfil.editar')
        	   ->with('registro',$perfil)
        	   ->with('paginas',$paginas);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store( Request $request)
	{
		$this->validate( $request, $this->validationRules(), $this->validationMessages() );

		$perfil= new Perfil;
		$perfil->nome = Input::get('nome');
		$perfil->descricao = Input::get('descricao');
		$perfil->status = Input::get('status',0);
		$perfil->save();

		$paginas = Input::get('paginas');
		$novasPaginas = array();
		foreach ($paginas as $k => $p) {
			$novasPaginas[] = array('pagina_id'=>$k,'papel_id'=>$perfil->id,'ler'=>1,'escrever'=>1);
		}

		//Add new permissions
		DB::table('permissoes')->insert($novasPaginas);

		return redirect('admin/perfil')->with('sucesso',true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$perfil = Perfil::find($id);
		return view('admin.perfil.visualizar')
			   ->with('perfil',$perfil);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perfil = perfil::find($id);
		$paginas = Pagina::leftJoin('permissoes',function($join) use ($id){
				$join->on('paginas.id','=','permissoes.pagina_id')
					->on('permissoes.papel_id','=',DB::raw($id));
			})
			->where('paginas.admin','=',1)
			->where('paginas.status','=',1)
			->orderBy('pai')
			->orderBy('nome')
			->select('paginas.*','permissoes.id as selecionado')
			->get();

		if( Input::old('nome') ) {
			$perfil->nome = Input::old('nome');
			$perfil->descricao = Input::old('descricao');
			$perfil->status = Input::old('status');

			$selected = Input::old('paginas');
			foreach ($paginas as $key => $p) {
				if( isset($selected[$p->id]) ){
					$p->selecionado=1;
				} 
			}
		}

		return view('admin.perfil.editar')
				->with('registro',$perfil)
				->with('paginas',$paginas);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$this->validate( $request, $this->validationRules(), $this->validationMessages() );

		$perfil = Perfil::find($id);
		$perfil->nome = Input::get('nome');
		$perfil->descricao = Input::get('descricao');
		$perfil->status = Input::get('status',0);
		$perfil->save();

		$paginas = Input::get('paginas');
		$novasPaginas = array();
		foreach ($paginas as $k => $p) {
			$novasPaginas[] = array('pagina_id'=>$k,'papel_id'=>$id,'ler'=>1,'escrever'=>1);
		}
		// Delete old permissions
		Permissao::where('papel_id','=',$id)->delete();

		//Add new permissions
		DB::table('permissoes')->insert($novasPaginas);

		// Redirect with success message to edit page
		return redirect('admin/perfil/'.$id.'/edit')->with('sucesso',true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// If is not the admin user
		if($id!=1){
			Perfil::find($id)->delete();
		}
   		return redirect('admin/perfil')->with('sucesso',true);
	}

	// PRIVATE METHODS
	private function validationRules( ){
		$rules = [
	        'nome' => 'required|max:255',
	        'descricao' => 'required|max:255',
	        'paginas' => 'required',
	    ];

		return  $rules;

	}

	private function validationMessages()
	{
	    return [
	        'nome.required' => 'O Nome é Obrigatório',
	        'descricao.required'  => 'A Descrição é obrigatoria',
	        'paginas.required'  => 'Pelo menos uma página deve ser selecionada.',
	    ];
	}

}
