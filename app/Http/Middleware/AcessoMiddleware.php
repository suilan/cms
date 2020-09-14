<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Permissao;

class AcessoMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Exclui as páginas do 404 e do cartorios do filtro,
		// esse o associado pode visualizar
		$exceptions = ['404'];
		if(!in_array($request->segment(2), $exceptions))
		{
			// Se o usuário for do tipo associado,
			// ele só pode acessar o create e o edit dos cartorios
			$user = Auth::user();

			// Checa as permissões que o usuário tem para a pagina atual
			$permissoes = Permissao::join('papeis','papeis.id','=','permissoes.papel_id')
				->join('paginas','paginas.id','=','permissoes.pagina_id')
				->where('papeis.id','=',$user->papel_id)
				->where('paginas.status','=',1)
				->where('paginas.caminho','=',$request->segment(1).'/'.$request->segment(2))
				->select('permissoes.ler','permissoes.escrever')
				->orderBy('paginas.ordem')
				->get();


			// Todos os menus que o usuário tem acesso
			$menu = Permissao::join('papeis','papeis.id','=','permissoes.papel_id')
				->join('paginas','paginas.id','=','permissoes.pagina_id')
				->where('papeis.id','=',$user->papel_id)
				->where('paginas.status','=',1)
				->where('paginas.admin','=',1)
				->where('permissoes.ler','=',1)
				->orderBy('ordem')
				->orderBy('paginas.id')
				->select('paginas.nome','paginas.caminho','paginas.pai','paginas.icon')
				->get();

			view()->share('menu',$menu);

			if( $permissoes->count()==0){
				return view('admin/404');
			}
		}
		return $next($request);
	}

}
