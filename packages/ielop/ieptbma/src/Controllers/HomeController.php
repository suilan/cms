<?php 
namespace Ielop\Ieptbma\Controllers;

use App\Http\Controllers\Controller;
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
		$banner[0]->imagem = 'default/img/temp-banner.jpg';

		$columns = ['titulo','descricao', 'slug',
			DB::raw("date_format(noticias.created_at,'%d') as dia"),
			DB::raw("date_format(noticias.created_at,'%b') as mes"),
			"imagem_url",'imagem','conteudo'];

		$imagemCarousel = ImagemCarousel::join('users','users.id','=','imagem_carousels.user_id')
			->orderBy('imagem_carousels.created_at','desc')
			->whereNull('users.cartorio_id')
			->where('imagem_carousels.status','1')
			->get();

		$ultimaCartilha = Download::join('users','users.id','=','downloads.user_id')
			->whereNull('users.cartorio_id')
			->where('downloads.status',1)
			->orderBy('downloads.created_at','desc')->first();

		if(!$ultimaCartilha){
			$ultimaCartilha = new Download();
		}

		$noticias = Noticia::join('users','users.id','=','noticias.user_id')
			->whereNull('users.cartorio_id')
			->where('noticias.status','=','1')
			->orderBy('noticias.created_at','desc')
			->select( $columns )
			->limit(3)
			->get();

		return view('ieptbma::home')
            ->with('noticias', $noticias)
			->with('mes', $months)
			->with('banner', $banner)
			->with('carousel',$imagemCarousel)
			->with('ultimaCartilha',$ultimaCartilha);
    }
}
