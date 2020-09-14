<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;
use App\Remessa;
use App\User;
use App\Cartorio;
use App\Titulo;
use App\Devedor;
use App\TituloPdf;
use App\TituloXls;
use Redirect;
use File;
use DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;

class AdminRemessasController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Remessas');
		view()->share('page_description','Edição, criação e exclusão de remessas no site');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        Session::forget('remessa');
        
        $remessa = Remessa::leftJoin('cartorios','cartorios.id','=','remessas.cartorio_id')
            ->leftJoin('titulos','titulos.remessa_id','=','remessas.id')
            ->select('remessas.*','cartorios.nome as cartorio_nome',
                 DB::raw('count(titulos.id) as qtd_titulos')
                )
            ->groupBy('remessas.id')
            ->orderBy('id','desc');

        // If is a super user, can see all remessas
        // Otherwise, show only his titles
        $user = Auth::user();
        $remessa = $remessa->join('users','users.id','=','remessas.user_id')
            ->where('remessas.user_id','=', $user->id);

        $remessa = $remessa->paginate(10);
        $remessa->setPath('remessas');
        // $cartorios = Cartorio::select('id','nome')->get();


        return view('admin.remessas.home')
            ->with('isAdmin',$user->papel_id==1)
            ->with('registros',$remessa);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $remessa = Remessa::find( $id );
        $usuario = Auth::user();

        $reader = new TituloXls( public_path().$remessa->arquivo );
        $reader->dump( $usuario->id, $usuario->cartorio_id, $id );
    }

    public function getPrint($id)
    {
        $titulos = Titulo::join('devedores','devedores.id','=','titulos.devedor_id')
            ->join('especies','especies.id','=','titulos.especie_id')
            ->join('cidades','cidades.id','=','devedores.cidade_id')
            ->join('endossos','endossos.id','=','titulos.endosso_id')
            ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento',
                'devedores.endereco','devedores.numero','devedores.bairro','devedores.cep',
                'cidades.nome as cidade','cidades.uf','endossos.nome as endosso_nome',
                DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%d/%m/%Y\') as emissao'),
                DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%d/%m/%Y\') as vencimento'),'especies.codigo as especie_nome',
                DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo'),
                DB::raw('format(`titulos`.`valor`,2,\'de_DE\') as valor') )
            ->where('remessa_id','=',$id)
            ->get();


        $fpdf = new TituloPdf();
        $fpdf->ficha = "REMESSA";
        $fpdf->AddPage();

        // Check if has titulos and if it does, 
        // load the cartorio from the first result 
        if( $titulos->count()>0 )
        {
            $cartorio = Cartorio::leftJoin('cidades','cidades.id','=','cartorios.cidade_id')
                ->where('cartorios.id','=',$titulos[0]->cartorio_id)
                ->first(array('cartorios.*','cidades.nome as cidade_nome','cidades.uf'));
        }

        foreach ($titulos as $t) {
            
            $fpdf->content( $t, $cartorio );
        }

        $fpdf->Output();
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $usuario = Auth::user();

        $cartorios = Cartorio::select('id','nome')->get();
        $remessa = new Remessa;

        return view('admin.remessas.editar')
            ->with('isAdmin', $usuario->papel_id==1)
            ->with('cartorios',$cartorios)
            ->with('registro',$remessa);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        // A propria controller ja trata a validação, se falhar,
        //ela mesma faz o redirect para a pagian anterior
        // $this->validate( $request, $this->validationRules(), $this->validationMessages() );
        $user = Auth::user();

        if( $user->papel_id=1 ){
            $cartorioID = Input::get('cartorio');
        }
        else{
            $cartorioID = $user->cartorio_id;
        }

        DB::beginTransaction();

        // Create the register
		$remessa = new Remessa;
        $remessa->user_id     = $user->id;
		$remessa->cartorio_id = $cartorioID;
        $remessa->save();

        // Save the file
        $arquivo = Input::file('arquivoRemessa');
        $extensao = $arquivo->getClientOriginalExtension();
        File::move( $arquivo, public_path().'/arquivos/remessa-id_'.$remessa->id.'.'.$extensao );
        $remessa->arquivo = '/arquivos/remessa-id_'.$remessa->id.'.'.$extensao;
        $remessa->save();

        // Read file
        $reader = new TituloXls( public_path().$remessa->arquivo );
        $reader->save($user->id, $cartorioID, $remessa->id);

        if( Session::has('errors') )
        {
            DB::rollback();
            return redirect('admin/remessas/create');
        }
        else{
            DB::commit();
            return redirect('admin/remessas')
                ->with('sucesso',true);
        }

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$remessa = Remessa::find($id);
        $cartorios = Cartorio::select('id','nome')->get();

        // Se houver dados de formularios anteriores
        if( Input::old('_token') )
    	{
            $remessa->cartorio_id 	= Input::old('cartorio');
        }

        return view('admin.remessas.editar')
            ->with('cartorios',$cartorios)
            ->with('isAdmin',Auth::user()->papel_id==1)
            ->with('registro',$remessa);
	}

  
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        // delete all titles
        Titulo::where('remessa_id','=',$id)->delete();
        Devedor::leftJoin('titulos','titulos.devedor_id','=','devedores.id')
            ->whereNull('titulos.devedor_id')
            ->delete();

        // Delete File uploaded
        $remessa = Remessa::find( $id );
        File::delete(public_path().$remessa->arquivo);

        // delete remessa
        Remessa::where('id','=',$id)->delete();
        
        return redirect('admin/remessas')->with('sucesso',true);
	}

    public function getStatus($id)
    {
        $remessa = Remessa::find($id);

        if( $remessa->cancelado )
        {
            $remessa->cancelado = 0;
        }
        else{
            $remessa->cancelado = 1;
        }
        
        $remessa->save();
        return redirect('admin/remessas')->with('sucesso',true);
    }
}
