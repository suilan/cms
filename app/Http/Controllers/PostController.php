<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App\Posts;
use Redirect;
use File;
class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Posts::all();
      		return view('admin.noticia')->with('posts',$posts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
      	    if(Input::file('imagem'))
      	    {
        	$imagem = Input::file('imagem');
	        $extensao = $imagem->getClientOriginalExtension();
	        if($extensao != 'jpg' && $extensao != 'png')
        	{
			return back()->with('erro','Erro: Este arquivo não é imagem');
        	}
	    }
		$post = new Posts;
	        $post->titulo = Input::get('titulo');
	        $post->conteudo = Input::get('conteudo');
	        $post->imagem = "";
	        $post->save();
	        
		if(Input::file('imagem'))
      		{
		        File::move($imagem,public_path().'/images/post-id_'.$post->id.'.'.$extensao);
		        $post->imagem = '/images/post-id_'.$post->id.'.'.$extensao;
		        $post->save();
	        }
	         return redirect('/');
	}
	
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
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
		$post = Posts::find($id);
		return view('admin.visualizar-noticia')->with('post',$post);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Posts::find($id);
                return view('admin.editar-noticia')->with('post',$post);

	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$post = Posts::find($id);
		if(Input::file('imagem'))
        {
			$imagem = Input::file('imagem');
			$extensao = $imagem->getClientOriginalExtension();
			if($extensao != 'jpg' && $extensao != 'png')
			{
			 	 return back()->with('erro','Erro: Este arquivo não é imagem');
			}
        }
		if($post->titulo != Input::get("titulo"))
		{
			$post->titulo = Input::get("titulo");
		}
		if($post->conteudo != Input::get("conteudo"))
		{
		    $post->conteudo = Input::get("conteudo");
		}
		$post->save();
	
		if(Input::file('imagem'))
	    {
			File::delete(public_path().$post->imagem);	
			File::move($imagem,public_path().'/images/post-id_'.$post->id.'.'.$extensao);
			$post->imagem = '/images/post-id_'.$post->id.'.'.$extensao;
			$post->save();
	    }
	    
	    return redirect('visualizar-noticia/'.$post->id);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Posts::find($id);
		File::delete(public_path().$post->imagem);
		$post->delete();
		return redirect('noticias');
	}

}
