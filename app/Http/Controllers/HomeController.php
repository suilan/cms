<?php namespace App\Http\Controllers;

use App\Noticia;
use App\ImagemCarousel;
use App\Download;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class HomeController extends Controller {

    public function __construct()
	{
		// $this->middleware('guest');
	}

    public function index()
	{
		// Replace maonths returned by database
		$months = ['Jan' => 'Jan','Feb' => 'Fev','Mar' => 'Mar','Apr' => 'Abr','May' => 'Mai',
		'Jun' => 'Jun','Jul' => 'jul','Aug' => 'Ago','Sep' => 'Set','Oct' => 'Out','Nov' => 'Nov','Dec' => 'Dez'];

		$banner[0] = new ImagemCarousel();
		$banner[0]->imagem = '/new/img/temp-banner.jpg';

		$columns = ['titulo','descricao', 'slug',
			DB::raw("date_format(noticias.created_at,'%d') as dia"),
			DB::raw("date_format(noticias.created_at,'%b') as mes"),
			"imagem_url",'imagem','conteudo'];

		$imagemCarousel = ImagemCarousel::orderBy('created_at','desc')
		                  ->where('status','1')
		                  ->get();

		$ultimaCartilha = Download::join('users','users.id','=','downloads.user_id')
		->where('users.papel_id',1)
		->where('downloads.status',1)
		->orderBy('downloads.created_at','desc')->limit(1)->first();

		$noticias = Noticia::join('users','users.id','=','noticias.user_id')
			->where('noticias.status','=','1')
			->orderBy('noticias.created_at','desc')
			->select( $columns )
			->limit(3)
			->get();

		return view('new/home')
            ->with('noticias', $noticias)
			->with('mes', $months)
			->with('banner', $banner)
			->with('carousel',$imagemCarousel)
			->with('ultimaCartilha',$ultimaCartilha);;
    }
}