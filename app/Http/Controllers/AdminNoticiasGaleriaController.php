<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;
use App\Noticia;
use App\NoticiaGaleria;
use App\User;
use Redirect;
use Session;
use File;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class AdminNoticiasGaleriaController extends Controller {

    public function __construct()
    {
        view()->share('page_title','Notícias');
        view()->share('page_description','Edição, criação e exclusão de notícias no site');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($noticia_id)
	{
        $noticia = Noticia::find($noticia_id);
        $imagens = NoticiaGaleria::where('noticia_id','=',$noticia_id)
            ->whereNotNull('path')
            ->get();

        return view('admin.noticias.galeria')
            ->with('registro',$noticia)
            ->with('imagens',$imagens);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $htmlStatus = 417; //Expectation Failed
        $response = array('status' => 'error', 'message'=>'' );

        // Get the image and the news id
        $imagem = Input::file('files');
        $noticia_id = $request->noticia_id;

        if(!$imagem){
            $response['message'] = 'A imagem não foi enviada para nosso servidor.';
            return response()->json($response, $htmlStatus);
        }

        if(!$noticia_id){
            $response['message'] = 'Não foi possivel identificar a notícia da qual a imagem pertence.';
            return response()->json($response, $htmlStatus);
        }

        // Only if both are filled
        try{
            // Create the id of the new image in th database
            $img = new NoticiaGaleria();
            $img->noticia_id = $noticia_id;
            $img->tipo_arquivo = 1;
            $img->save();

            // Move the image to the server
            $extensao = $imagem->getClientOriginalExtension();
            $path = '/images/noticia-id_'.$noticia_id.'_'.$img->id.'.'.$extensao;

            File::move( $imagem, public_path().$path );

            // Save the path in the database
            $img->path = $path;
            $img->save();


            // Return success message
            $response = array('status' => 'success', 'id'=>$img->id,'message'=>$img->getOtherImage(250,150) );
            $htmlStatus = 200; //OK

        }catch( Exception $e){
            $response['message'] = $e->getMessage();
        }

        return response()->json($response, $htmlStatus);
	}

    public function update(Request $request){
        $htmlStatus = 417; //Expectation Failed
        $response = array('status' => 'error', 'message'=>'' );

        // Get the image and the news id
        $imagem = Input::file('files');
        $noticia_id = $request->noticia_id;

        if(!$noticia_id){
            $response['message'] = 'Não foi possivel identificar a notícia da qual a imagem pertence.';
        }elseif(!$imagem){
            $url = $request->get('url');
            if( $url ){
                $noticia = Noticia::find($noticia_id);
                $header = get_headers($url);
                
                if( sizeof($header)>0 && substr_count($header[0], '404')==0)
                {
                    $extension = pathinfo($url,PATHINFO_EXTENSION);
                    $position = strpos($extension,'?');
                    if( $position>-1 ){
                        $extension = substr($extension, 0,$position);
                    }
                    if( $extension ){
                        $newName = '/images/noticia-id_'.$noticia->id.'.'.$extension;
                    }
                    else{
                        $newName = '/images/noticia-id_'.$noticia->id;
                    }
                    
                    // Get image online
                    $ch = curl_init($url);
                    $fp = fopen( public_path().$newName, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);
                
                    $noticia->imagem_url = $url;
                    $noticia->imagem = $newName;
                    $noticia->save();

                    // Erase previews crops                
                    $noticia->eraseAuxImgs();
                    
                    // Return success message
                    $response = array('status' => 'success', 'message'=>$noticia->getOtherImage(410,220) );
                    $htmlStatus = 200; //OK
                }
                else{
                    $response['message'] = 'Não foi possivel salvar a imagem da url enviada.';

                }
         
            }else{
                $response['message'] = 'A imagem não foi enviada para nosso servidor.';
            }
        } else{

            // Only if both are filled
            try{
                $noticia = Noticia::find($noticia_id);

                // Move the image to the server
                $extensao = $imagem->getClientOriginalExtension();
                $path = '/images/noticia-id_'.$noticia_id.'.'.$extensao;

                File::move( $imagem, public_path().$path );

                // Save the path in the database
                if($noticia->imagem){
                    $noticia->eraseAuxImgs();
                }
                $noticia->imagem = $path;
                $noticia->save();

                // Return success message
                $response = array('status' => 'success', 'message'=>$noticia->getOtherImage(410,220) );
                $htmlStatus = 200; //OK

            }catch( Exception $e){
                $response['message'] = $e->getMessage();
            }
        }

        return response()->json($response, $htmlStatus);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function show(Request $request)
	{
        $htmlStatus = 417; //Expectation Failed
        $response = array('status' => 'error', 'message'=>'' );

        $noticia_id = $request->noticia_id;
        $youtube_id = $request->youtube_id;

        if(!$noticia_id){
            $response['message'] = 'Não foi possivel identificar a notícia da qual a imagem pertence.';
            return response()->json($response, $htmlStatus);
        }

        if( !$youtube_id ){
            $response['message'] = 'Não foi possivel encontrar o identificador do video.';
            return response()->json($response, $htmlStatus);
        }


        // Only if both are filled
        try{
            // Create the id of the new image in th database
            $img = new NoticiaGaleria();
            $img->noticia_id = $noticia_id;
            $img->tipo_arquivo = 2;
            // Save the path in the database
            $img->path = $youtube_id ;
            $img->save();


            // Return success message
            $response = array('status' => 'success', 
                'id'=>$img->id,'message'=>'O video do youtube foi salvo na galeria' );
            $htmlStatus = 200; //OK

        }catch( Exception $e){
            $response['message'] = $e->getMessage();
        }

        return response()->json($response);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy( $noticia_id, $id)
	{
        $htmlStatus = 417; //Expectation Failed
        $response = array('status' => 'error', 'message'=>'' );

         if(!$id){
            $response['message'] = 'Não foi possivel encontrar o identificador da imagem.';
        }

		$imagem = NoticiaGaleria::find($id);
        if(!$imagem){
            // Check if it is the main image
            if($id==='0'){
                $noticia = Noticia::find($noticia_id);
                File::delete(public_path().$noticia->imagem);
                $noticia->eraseAuxImgs();
                $noticia->imagem='';
                $noticia->save();

                // Return success message
                $response = array('status' => 'success', 'message'=>'A imagem foi excluída da nossa base com sucesso.' );
                $htmlStatus = 200; //OK
            }else{
                $response['message'] = 'Não foi possivel localizar a imagem.';
            }
        }
        else{
            File::delete(public_path().$imagem->path);
            $imagem->delete();

            // Return success message
            $response = array('status' => 'success', 'message'=>'A imagem foi excluída da nossa base com sucesso.' );
            $htmlStatus = 200; //OK
        }

        return response()->json($response, $htmlStatus);
	}

}
