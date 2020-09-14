<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;
use App\Edital;
use App\Remessa;
use App\Titulo;
use App\Cartorio;
use App\EditalPdf;
use App\User;
use Redirect;
use File;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class AdminEditaisController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Editais');
		view()->share('page_description','Edição, criação de editais no site');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $editais = Edital::leftJoin('remessas','remessas.edital_id','=','editais.id')
            ->leftJoin('titulos','titulos.remessa_id','=','remessas.id')
            ->leftJoin('cartorios','remessas.cartorio_id','=','cartorios.id')
            ->select('editais.id',DB::raw('count( distinct remessas.id) as qtd_remessas'),
                'cartorios.nome as cartorio_nome', 'editais.created_at',
                DB::raw('count(distinct titulos.id) as qtd_titulos'),'editais.cancelado')
            ->groupBy('edital_id')
            ->orderBy('id','desc')
            ->paginate(10);

		$editais->setPath('editais');
      		return view('admin.editais.home')
            ->with('isAdmin',Auth::user()->papel_id==1)
      		->with('registros',$editais);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // header('Content-Type: application/pdf');
        // header("Content-Disposition: attachment; filename=\"edital_$id.pdf\"");
        $titulos = Titulo::join('devedores','devedores.id','=','titulos.devedor_id')
            ->join('especies','especies.id','=','titulos.especie_id')
            ->join('cidades','cidades.id','=','devedores.cidade_id')
            ->join('endossos','endossos.id','=','titulos.endosso_id')
            ->join('remessas','remessas.id','=','titulos.remessa_id')
            ->join('editais','editais.id','=','remessas.edital_id')
            ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento', 'devedores.tipo_doc',
                'devedores.endereco','devedores.numero','devedores.bairro','devedores.cep', 
                'cidades.nome as cidade','cidades.uf','endossos.nome as endosso_nome',
                DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%m/%d/%Y\') as emissao'),
                DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%m/%d/%Y\') as vencimento'),'especies.codigo as especie_nome',
                DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo'),
                DB::raw('format(`titulos`.`valor`,2,\'de_DE\') as valor') )
            ->where('editais.id','=',$id)
            ->get();

        $usuario = Auth::user();

        $fpdf = new EditalPdf();
        $fpdf->edital = Edital::find($id);

        // Check if has titulos and if it does, 
        // load the cartorio from the first result 
        if( $titulos->count()>0 )
        {
            $fpdf->cartorio = Cartorio::leftJoin('cidades','cidades.id','=','cartorios.cidade_id')
                ->leftJoin('cartorio_responsavels',function($join){
                    $join->on('cartorio_responsavels.cartorio_id','=','cartorios.id')
                        ->on('cartorio_responsavels.tipo_responsavel_id','=',DB::raw(9));// Tabelião
                })
                ->where('cartorios.id','=', $titulos[0]->cartorio_id)
                ->first(array('cartorios.*','cartorio_responsavels.nome as responsavel_nome',
                    'cidades.nome as cidade_nome','cidades.uf'));
            $fpdf->cartorioContato = 
                                      DB::select('select cc.contato as contato from contatos cc
                                              where cc.cartorio_id =' .$titulos[0]->cartorio_id.
                                              ' and cc.tipocontato_id in (1,2)
                                              and cc.contato is not null
                                              order by cc.tipocontato_id
                                              limit 1');
        }
        $fpdf->AddPage();
        foreach ($titulos as $r=>$t) {
            $background = false;
            if ($r % 2 != 0){
                $fpdf->SetFillColor(192,192,192);
                $background = true;
            }
            $fpdf->content($t, $background);
        }
        $fpdf->Ln(7);
        $fpdf->paragrafoFinal();
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

        $cartorioId = $usuario->cartorio_id;
        if( $usuario->papel_id==1 )
        {
            $cartoriosIDs = Remessa::whereNull('edital_id')
            ->where('cancelado','=','0')
            ->groupBy('cartorio_id')
            ->pluck('cartorio_id');

            for ($i=0; $i < sizeof($cartoriosIDs) ; $i++) { 
                $this->newEdital($usuario,$cartoriosIDs[$i]);
            }
        }
        else{
            $this->newEdital($usuario,$cartorioId);
        }

        return redirect('admin/editais')
           ->with('sucesso',true);

    }

    /*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$edital = Edital::find($id);
		File::delete(public_path().$edital->imagem);
		$edital->delete();
		return redirect('admin/editais');
	}

    // New edital 
    private function newEdital($usuario, $cartorioId='')
    {
        $remessas = Remessa::whereNull('edital_id')
            ->where('cancelado','=','0')
            ->where('cartorio_id','=', $cartorioId)
            ->pluck('id'); 

        $edital = new Edital;
        $edital->cartorio_id = $cartorioId;
        $edital->user_id = $usuario->id;
        $edital->save();

        Remessa::whereIn('id', $remessas)
            ->update(['edital_id'=>$edital->id]);
    }


    public function getStatus($id)
    {
        $edital = Edital::find($id);

        if( $edital->cancelado )
        {
            $edital->cancelado = 0;
        }
        else{
            $edital->cancelado = 1;
        }
        
        $edital->save();
        return redirect('admin/editais')->with('sucesso',true);
    }
}
