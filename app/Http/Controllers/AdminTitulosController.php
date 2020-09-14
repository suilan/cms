<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input;
use Auth;
use App\Titulo;
use App\Devedor;
use App\User;
use App\Endosso;
use App\Especie;
use App\Cidade;
use App\Cartorio;
use App\Remessa;
use App\TipoVencimento;
use App\TituloPdf;
use App\Feriado;
use App\Edital;
use Redirect;
use File;
use DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;

class AdminTitulosController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Títulos');
		view()->share('page_description','Apresentação de Títulos Online');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        // If the user get in this page, then the remessa was abandoned
        Session::forget('remessa');

        $titulo = Titulo::join('devedores','devedores.id','=','titulos.devedor_id')
            ->join('especies','especies.id','=','titulos.especie_id')
            ->leftJoin('cartorios','cartorios.id','=','titulos.cartorio_id')
            ->join('remessas','remessas.id','=','titulos.remessa_id')
            ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento',
                DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%d/%m/%Y\') as emissao'),
                'cartorios.nome as cartorio_nome','especies.codigo as especie_nome','remessas.edital_id',
                DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo')
                    )
            ->orderBy('created_at','desc');

        // If is a super user, can see all titulos
        // Otherwise, show only his titles
        $user = Auth::user();
        $titulo = $titulo->join('users','users.id','=','titulos.user_id')
            ->where('titulos.user_id','=', $user->id);

        // Mount the search
        if ( Input::get('pesquisa') )
        {
            $titulo = $this->search($titulo);
        }

        // Fill 
        $cartorio_id = Input::get('cartorio');
        $remessa = Input::get('remessa');
        if( !$cartorio_id ){
            if( $remessa ){
                $remessa = Remessa::find($remessa);
                if($remessa) $cartorio_id = $remessa->cartorio_id;
            }
        }

        $titulo = $titulo->paginate(10);

		$titulo->setPath('titulos');
        $cartorios = Cartorio::pluck('nome','id');

      	return view('admin.titulos.home')
            ->with('isAdmin',Auth::user()->papel_id==1)
            ->with('cartorios',$cartorios)
            ->with('cartorio_id',$cartorio_id)
      		->with('registros',$titulo);
	}

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $titulo = Titulo::leftJoin('devedores','devedores.id','=','titulos.devedor_id')
            ->leftJoin('especies','especies.id','=','titulos.especie_id')
            ->leftJoin('remessas','remessas.id','=','titulos.remessa_id')
            ->leftJoin('cidades','cidades.id','=','devedores.cidade_id')
            ->leftJoin('endossos','endossos.id','=','titulos.endosso_id')
            ->where('titulos.id','=',$id)
            ->select('titulos.*','devedores.nome as devedor_nome','devedores.documento',
                'devedores.endereco','devedores.numero','devedores.bairro','devedores.cep',
                'cidades.nome as cidade','cidades.uf','endossos.nome as endosso_nome',
                DB::raw('DATE_FORMAT(`titulos`.`emissao`,\'%d/%m/%Y\') as emissao'),
                DB::raw('DATE_FORMAT(`titulos`.`vencimento`,\'%d/%m/%Y\') as vencimento'),'especies.codigo as especie_nome',
                'remessas.edital_id as edital',
                DB::raw('format(`titulos`.`saldo`,2,\'de_DE\') as saldo'),
                DB::raw('format(`titulos`.`valor`,2,\'de_DE\') as valor') )
            ->first();

        // var_dump($titulo->cartorio_id);
        // exit;
        $cartorio = Cartorio::leftJoin('cidades','cidades.id','=','cartorios.cidade_id')
            ->where('cartorios.id','=', $titulo->cartorio_id)
            ->first(array('cartorios.*','cidades.nome as cidade_nome','cidades.uf'));

        $fpdf = new TituloPdf();
        $fpdf->AddPage();
        $fpdf->content( $titulo, $cartorio );
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
        $registro = new Titulo;

        // Devedor fixo
        if( Session::has('devedorId') ){
            $devedor = Devedor::join('cidades','cidades.id','=','devedores.cidade_id')
            ->select('devedores.*','cidades.ibge','cidades.nome as cidade')
            ->find(Session::get('devedorId'));

            $registro->devedor_id = $devedor->id;
            $registro->tipo_doc = $devedor->tipo_doc;
            $registro->documento = $devedor->documento;
            $registro->nome = $devedor->nome;
            $registro->cep = $devedor->cep;
            $registro->cidade_id = $devedor->cidade_id;
            $registro->cidade = $devedor->cidade;
            $registro->ibge = $devedor->ibge;
            $registro->endereco = $devedor->endereco;
            $registro->numero = $devedor->numero;
            $registro->bairro = $devedor->bairro;
        }

        // Se houver erro na hora de inserir, mostrar o q foi preenchido
        if( Input::old('_token') )
        {
            $registro = $this->fillOld($registro);
        }

        // Se tiver remessa
        if( Session::has('remessa') )
        {
             $registro->cartorio_id = Remessa::find(Session::get('remessa'))->cartorio_id;
        }

        $endossos = Endosso::orderBy('nome')->get();
        $especies = Especie::orderBy('nome')->get();

        $cartorios = Cartorio::join('cidades','cidades.id','=','cartorios.cidade_id')
                             ->select('cartorios.id as id','cartorios.nome as nome','cidades.nome as cidade')
                             ->get();

        return view('admin.titulos.editar')
        ->with('isAdmin',Auth::user()->papel_id==9)
        ->with('registro',$registro)
        ->with('cartorios',$cartorios)
        ->with('endossos',$endossos)
        ->with('especies',$especies)
        ->with('remessa',Session::get('remessa'));

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
        //ela mesma faz o redirect para a pagina anterior
        // $this->validate( $request, $this->validationRules(), $this->validationMessages() );

        // $localizacaoArquivo = $product->id.'.'.$request->file('arquivoRemessa')->getClientOriginalExtension();

        try {
            DB::transaction(function(){
                $usuario = Auth::user();

                // if there is now remessa yet
                if( !Session::has('remessa') )
                {
                    $remessa = new Remessa;
                    $remessa->user_id = $usuario->id;
                    if( $usuario->papel_id!=9 ){
                        $remessa->cartorio_id = $usuario->cartorio_id;
                    }
                    else{
                        $remessa->cartorio_id = Input::get('cartorio');
                    }

                    $remessa->save();
                    Session::put('remessa', $remessa->id);
                }else{
                    $remessa = Remessa::find(Session::get('remessa'));
                }
                
                // Check if the devedor already exits, otherwise create
                $devedorId = Input::get('devedor');
                if( !$devedorId  ){
                    $devedor = new Devedor;
                    $devedor->tipo_doc = Input::get('tipo-doc');
                    $devedor->documento = Input::get('documento');
                    $devedor->nome = Input::get('nome');
                    $devedor->cep = Input::get('cep');
                    $devedor->cidade_id = Cidade::where('ibge','=',Input::get('cidadeIBGE'))->first()->id;
                    $devedor->endereco = Input::get('logradouro');
                    $devedor->numero = Input::get('numero');
                    $devedor->bairro = Input::get('bairro');
                    $devedor->save();

                    $devedorId = $devedor->id;
                }

                // Input to set the devedor as fixed fields
                if( Input::get('fixardevedor') ){
                    Session::put('devedorId', $devedorId);
                }
                else{
                    Session::forget('devedorId');
                }
                

                $titulo = new Titulo;
                $titulo->user_id = $usuario->id;
                $titulo->cartorio_id = $remessa->cartorio_id;
                $titulo->remessa_id = Session::get('remessa');
                $titulo->devedor_id = $devedorId;
                $titulo->cedente = Input::get('cedente');
                $titulo->protocolo = Input::get('protocolo');
                $titulo->numero_titulo = Input::get('numero-titulo');
                $titulo->nosso_numero = Input::get('nossonumero');
                $titulo->especie_id = Input::get('especie');
                //1-Cartorio, 2-Devedor
                $titulo->praca_protesto_id = Input::get('praca');
                //1- Manual | 2- À vista
                $titulo->tipo_vencimento_id = Input::get('tipo-vencimento');
                $titulo->apresentante = Input::get('apresentante');
                $titulo->fim_falimentar = Input::get('fimfalimentar');
                $titulo->endosso_id = Input::get('endosso');

                // Dados tratados para serem salvos no banco              
                $titulo->emissao = Titulo::dataDB(Input::get('emissao'));
                //$titulo->vencimento = Titulo::dataDB(Input::get('vencimento'));

                $titulo->valor = str_replace('R$ ','',Input::get('valor'));
                $titulo->valor = str_replace(',','.', $titulo->valor);

                $titulo->custas = str_replace('R$ ','',Input::get('custas'));
                $titulo->custas = str_replace(',','.', $titulo->custas);

                $titulo->saldo = str_replace('R$ ','',Input::get('saldo'));
                $titulo->saldo = str_replace(',','.', $titulo->saldo);

                // Data de vencimento é 1 dia após a publicação
                // -- Só Vale dia util para a publicação
                // -- A publicação é um dia depois do cadastro

                $titulo->vencimento = $this->calculaDataPublicacao(date('Y-m-d',time()+ 86400));
                $titulo->save();
            });

            $titulo = Titulo::where('protocolo','=',Input::get('protocolo'))
                ->where('numero_titulo','=',Input::get('numero-titulo'))
                ->first();

            // If the user desires to insert new titles
            if( Input::get('novo') )
            {
                return redirect('admin/titulos/create')
                    ->with('sucesso',true); // show success message
            }
            else{
                // Erase saved id from remessa
                Session::forget('remessa');
                Session::forget('devedorId');

                // Send the user to the remessa list
                return redirect('admin/remessas')
                    ->with('sucesso',true);
            }
        } catch (Exception $e) {
            return redirect('admin/titulos/create')
                ->with('error',false)
                ->withInput();
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
		$titulo = Titulo::join('devedores','devedores.id','=','titulos.devedor_id')
            ->join('cidades','cidades.id','=','devedores.cidade_id')
            ->select('titulos.*','devedores.tipo_doc','devedores.documento','devedores.nome','devedores.id as devedor_id','devedores.cep','devedores.endereco','devedores.bairro','devedores.numero',
                'cidades.nome as cidade','cidades.ibge')
            ->where('titulos.id','=',$id)
            ->first();

        if( Input::old('_token') )
        {
            $registro = $this->fillOld($registro);
        }

        // Correction to show data in the correct format       
        $titulo->emissao = Titulo::dataBr($titulo->emissao);
        $titulo->vencimento = Titulo::dataBr($titulo->vencimento);

        $titulo->valor = 'R$ '.number_format($titulo->valor,2,',','');
        $titulo->custas = 'R$ '.number_format($titulo->custas,2,',','');
        $titulo->saldo = 'R$ '.number_format($titulo->saldo,2,',','');

        $cartorios = Cartorio::join('cidades','cidades.id','=','cartorios.cidade_id')
                             ->select('id','cartorios.nome as nome','cidades.nome as cidade')
                             ->get();

        $endossos = Endosso::orderBy('nome')->get();
        $especies = Especie::orderBy('nome')->get();

        return view('admin.titulos.editar')
            ->with('isAdmin',Auth::user()->papel_id==9)
            ->with('registro',$titulo)
            ->with('cartorios',$cartorios)
            ->with('endossos',$endossos)
            ->with('especies',$especies);
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
        try {

            DB::transaction(function() use ($id){

                $devedorId = Input::get('devedor');
                if( !$devedorId  ){
                    $devedor = new Devedor;
                    $devedor->tipo_doc = Input::get('tipo-doc');
                    $devedor->documento = Input::get('documento');
                    $devedor->nome = Input::get('nome');
                    $devedor->cep = Input::get('cep');
                    $devedor->cidade_id = Cidade::where('ibge','=',Input::get('cidadeIBGE'))->first()->id;
                    $devedor->endereco = Input::get('logradouro');
                    $devedor->numero = Input::get('numero');
                    $devedor->bairro = Input::get('bairro');
                    $devedor->save();

                    $devedorId = $devedor->id;
                }

                $titulo = Titulo::find($id);
                $titulo->user_id = Auth::user()->id;

                // if( Auth::user()->papel_id==1 ){
                //     $titulo->cartorio_id = Input::get('cartorio');
                // }else{
                //     $titulo->cartorio_id = Auth::user()->cartorio_id;
                // }
                
                $titulo->devedor_id = $devedorId;
                // $titulo->remessa_id = null;
                $titulo->protocolo = Input::get('protocolo');
                $titulo->numero_titulo = Input::get('numero-titulo');
                $titulo->nosso_numero = Input::get('nossonumero');
                $titulo->especie_id = Input::get('especie');

                //1-Cartorio, 2-Devedor
                $titulo->praca_protesto_id = Input::get('praca');
                //1- Manual | 2- À vista
                $titulo->tipo_vencimento_id = Input::get('tipo-vencimento');
                // $titulo->aceite = Input::get('aceite');
                $titulo->fim_falimentar = Input::get('fimfalimentar');
                $titulo->endosso_id = Input::get('endosso');

                // Dados tratados para serem salvos no banco              
                $titulo->emissao = Titulo::dataDB(Input::get('emissao'));
                $titulo->vencimento = Titulo::dataDB(Input::get('vencimento'));
                
                $titulo->valor = str_replace('R$ ','',Input::get('valor'));
                $titulo->valor = str_replace(',','.', $titulo->valor);

                $titulo->custas = str_replace('R$ ','',Input::get('custas'));
                $titulo->custas = str_replace(',','.', $titulo->custas);

                $titulo->saldo = str_replace('R$ ','',Input::get('saldo'));
                $titulo->saldo = str_replace(',','.', $titulo->saldo);

                // Data de vencimento é 1 dia após a publicação
                // -- Só Vale dia util para a publicação
                // -- A publicação é um dia depois do cadastro
                $titulo->vencimento = $this->calculaDataPublicacao(date('Y-m-d',time()+ 86400));
                $titulo->save();

            });

            $tituloId = Titulo::where('protocolo','=',Input::get('protocolo'))
                ->where('numero_titulo','=',Input::get('numero-titulo'))
                ->first()->id;

            return redirect('admin/titulos/'.$tituloId.'/edit')->with('sucesso',true);

        } catch (Exception $e) {
            return redirect('admin/titulos/create')
                ->with('error',false)
                ->withInput();
        }
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$titulo = Titulo::find($id);
		File::delete(public_path().$titulo->imagem);
		$titulo->delete();
		return redirect('admin/titulos');
	}

    public function getDevedor($documento='')
    {
        $devedor = Devedor::where('documento','=',$documento)
            ->join('cidades','cidades.id','=','devedores.cidade_id')
            ->select('devedores.nome','devedores.bairro','devedores.cep','devedores.endereco',
                'devedores.id','devedores.numero','cidades.ibge','cidades.nome as cidade')
            ->orderBy('id','desc')
            ->first();

        return response()->json($devedor);
    }

    private function search($titulo)
    {
        $protocolo = Input::get('protocolo');
        $remessa = Input::get('remessa');
        $cartorio = Input::get('cartorio');
        $documento = Input::get('documento');
        $devedor = Input::get('devedor');
        $emissao = Input::get('emissao');
        $saldo = Input::get('saldo');

        if( $protocolo )
        {
            $protocolo = '%'.str_replace(' ','%',$protocolo).'%';   
            $titulo = $titulo->where('protocolo','like',$protocolo);
        }

        if( $cartorio )
        {
            $titulo = $titulo->where('cartorios.id','=',$cartorio);
        }

        if( $documento )
        {
            $titulo = $titulo->where('documento','=',$documento);
        }

        if( $devedor )
        {
            $devedor = '%'.str_replace(' ','%',$devedor).'%';
            $titulo = $titulo->where('devedores.nome','like',$devedor);
        }

        if( $emissao )
        {
            $titulo = $titulo->where('emissao','=',Titulo::dataDB($emissao));
        }

        if( $remessa )
        {
            $titulo = $titulo->where('remessa_id','=',$remessa);
        }

        if( $saldo )
        {
            $titulo = $titulo->where('saldo','=',str_replace(',','.', $saldo));
        }

        return $titulo;
    }

    private function fillOld($registro)
    {
        $registro->tipo_doc = Input::old('tipo-doc');
        $registro->devedor_id = Input::old('devedor');
        $registro->documento = Input::old('documento');
        $registro->nome = Input::old('nome');
        $registro->cep = Input::old('cep');
        $registro->ibge = Input::old('ibge');
        $registro->cidade = Input::old('cidade');
        $registro->endereco = Input::old('logradouro');
        $registro->numero = Input::old('numero');
        $registro->bairro = Input::old('bairro');
        $registro->protocolo = Input::old('protocolo');
        $registro->numero_titulo = Input::old('numero_titulo');
        $registro->emissao = Input::old('emissao');
        $registro->vencimento = Input::old('vencimento');
        $registro->especie_id = Input::old('especie');
        $registro->valor = Input::old('valor');
        $registro->custas = Input::old('custas');
        $registro->saldo = Input::old('saldo');
        $registro->endosso_id = Input::old('endosso');
        $registro->tipo_vencimento_id = Input::old('tipo-vencimento');
        $registro->praca_id = Input::old('praca');
        // $registro->aceite = Input::old('aceite');
        $registro->fim_falimentar = Input::old('fimfalimentar');

        return $registro;
    }

    private function calculaDataPublicacao($dataAtual){
        $timestamp = strtotime($dataAtual);

        // Calcula qual o dia da semana de $dataAtual
        // O resultado será um valor numérico:
        // 1 -> Segunda ... 7 -> Domingo
        $dia = date('N', $timestamp);

        // Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
        if ($dia >= 6) {
            $timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
        } else {
            // Não é sábado nem domingo, mantém a data de entrada
            $timestamp_final = $timestamp;
        }

        $dataFinal = date('Y-m-d', $timestamp_final);

        // Verifica se a data é feriado
        $dataFeriado = Feriado::where('data','=',$dataFinal)->select('data')->first();

        if ($dataFeriado != null){
            calculaDataPublicacao($dataFeriado);
        }

        return $dataFinal;
    }
}