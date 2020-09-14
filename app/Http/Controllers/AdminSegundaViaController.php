<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;
use Form;
use File;
use Storage;

use DateTime;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;

use App\ArquivoBoleto;
use App\ArquivoBoletoDet;
use App\RemessaBoleto;
use App\Representante;

use Illuminate\Support\Facades\Request;

class AdminSegundaViaController extends Controller {

	public function __construct()
	{
		view()->share('page_title','Intimação Eletônica de Protesto');
		view()->share('page_description','Detalhamento das Intimações Eletônicas de Protesto');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		$validaCredenCNPJ = Input::get('campo');

		$filtroStatusImpressao = Input::get('statusImpressao');
		$filtroVencimento = Input::get('statusVencimento');

		$registros = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
						->select('arquivo_remessa_boleto_dets.id as id','nome_apresentante','protocolo',DB::raw('date_format(STR_TO_DATE(data_apontamento,"%d%m%Y"),"%d/%m/%Y") as data_emissao_titulo'),DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),'valor_total_boleto','valor_custas_emolumento','valor_principal_titulo','impresso',DB::raw('date_format(dataprimimpressao,"%d/%m/%Y %H:%i:%S") as dataprimimpressao'));
		
		if( Input::get('pesquisar') ){
			$pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';

			$registros = $registros->orWhere(function($query) use ($pesquisar){
					$query->orWhere('documento_sacado','like',$pesquisar)
						  ->orWhere('protocolo','like',$pesquisar)
						  ->orWhere(DB::raw('replace(replace(replace(documento_sacado,".",""),"-",""),"/","")'),'like',$pesquisar);
				});
		}
		if($filtroStatusImpressao && $filtroStatusImpressao != 9){
			if ($filtroStatusImpressao == 4) {
				$filtroStatusImpressao = 0;
			}

			$registros = $registros->where('impresso', $filtroStatusImpressao);
		}
		if($filtroVencimento && $filtroVencimento != 9){
			if ($filtroVencimento == 1) {
				$registros = $registros->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'<',Carbon::now()->setTimezone('America/Fortaleza')->toDateString());
			} else {
				$registros = $registros->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'>=',Carbon::now()->setTimezone('America/Fortaleza')->toDateString());
			}
		}

		if($user->papel_id!=2) {
			$registros = $registros->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'>=',Carbon::now()->setTimezone('America/Fortaleza')->toDateString());
		}
		if($validaCredenCNPJ != "credenpj" && $user->papel_id!=2) {
			$registros = $registros->where('arquivo_remessa_boleto_dets.documento_sacado','=', $user->cpf);
		}

		// If is a super user, can see all remessas
        //       Otherwise, show only his titles
		
		if ($user->papel_id == 8 && $user->creden == null) {
			return view('admin.segundavia.home')
			->with('creden','Caro usuário, nossa equipe está trabalhando em ritmo acelerado para providenciar seu credenciamento. Assim que finalizarmos, mandaremos um e-mail de confirmação. Obrigado.')
			->with('registros',null);
		}
		
		$registros = $registros->orderBy(DB::raw('STR_TO_DATE(data_apontamento,"%d%m%Y")'),'desc')
                           	   ->paginate(10);

		// for paginate purpose, set the path that will apear on the links
		$registros->setPath('segundavia');

		$qtdTitulos = RemessaBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id');
		if(Input::get('pesquisar')){
			$qtdTitulos = $qtdTitulos->where('arquivo_remessa_boleto_dets.documento_sacado','like','%'.str_replace(' ','%',Input::get('pesquisar')).'%');
		}
		if($user->papel_id == 8){
			$qtdTitulos = $qtdTitulos->where(DB::raw('trim(documento_sacado)'), $user->cpf);
		}
		$qtdTitulos = $qtdTitulos->count();

		$qtdTitulosAVencer = RemessaBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
							 ->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'>=',Carbon::now()->setTimezone('America/Fortaleza')->toDateString());
		if(Input::get('pesquisar')){
			$qtdTitulosAVencer = $qtdTitulosAVencer->where('arquivo_remessa_boleto_dets.documento_sacado','like','%'.str_replace(' ','%',Input::get('pesquisar')).'%');
		}									 
		if($user->papel_id == 8){
			$qtdTitulosAVencer = $qtdTitulosAVencer->where(DB::raw('trim(documento_sacado)'), $user->cpf);
		}							 
		$qtdTitulosAVencer = $qtdTitulosAVencer->count();

		$qtdTitulosImpressos = ArquivoBoletoDet::where('impresso','<>',0);
		if(Input::get('pesquisar')){
			$qtdTitulosImpressos = $qtdTitulosImpressos->where('arquivo_remessa_boleto_dets.documento_sacado','like','%'.str_replace(' ','%',Input::get('pesquisar')).'%');
		}
		if($user->papel_id == 8){
			$qtdTitulosImpressos = $qtdTitulosImpressos->where(DB::raw('trim(documento_sacado)'), $user->cpf);
		}							 
		$qtdTitulosImpressos = $qtdTitulosImpressos->count();
		
		return view('admin.segundavia.home')
			->with('registros',$registros)
			->with('creden',$validaCredenCNPJ)
			->with('errproc',false)
			->with('user', $user)
			->with('qtdTitulos', $qtdTitulos)
			->with('qtdTitulosAVencer',$qtdTitulosAVencer)
			->with('qtdTitulosImpressos', $qtdTitulosImpressos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$arquivo = Input::file('remessa');
		$extensao = $arquivo->getClientOriginalExtension();
		$fileName = $arquivo->getClientOriginalName();

		//Verifica se arquivo já foi processado
		$boletoProcessado = ArquivoBoleto::where('nome_arquivo', $fileName)->first();
		if($boletoProcessado){
			return redirect('admin/remessaboleto')->with('errproc',true);
		}

		$path = $arquivo->move(public_path('arquivos/remessas'), $fileName);
		$file = fopen(public_path('arquivos/remessas/').$fileName, "r");

		$arquivoBoleto = new ArquivoBoleto;
		$arquivoBoletoDet = new ArquivoBoletoDet;
		while (($detalhe = fgets($file)) !== false) {
			$identRegistro = substr($detalhe, 0, 1);

			if ($identRegistro == 0) { // Header
				$arquivoBoleto = new ArquivoBoleto;

				$arquivoBoleto->nome_arquivo                   = $fileName;
				$arquivoBoleto->data_remessa                   = $this->dateStrTimeBanco(substr($detalhe,   1,   8));
				$arquivoBoleto->nome_cartorio                  = utf8_decode(substr($detalhe,  9, 100));
				$arquivoBoleto->cnpj_cartorio                  = substr($detalhe, 109,  14);
				$arquivoBoleto->endereco_cartorio              = utf8_decode(substr($detalhe, 123, 150));
				$arquivoBoleto->telefone_cartorio              = substr($detalhe, 273,  20);
				$arquivoBoleto->banco_conveniado_cobranca      = substr($detalhe, 293,   3);
				$arquivoBoleto->nome_banco_conveniado          = substr($detalhe, 296, 700);
				$arquivoBoleto->quantidade_titulo_remessa      = substr($detalhe, 996,   4);

				$arquivoBoleto->save();
			}elseif ($identRegistro == 1) { // Detalhe
				$arquivoBoletoDet = new ArquivoBoletoDet;

				// verifica se protocolo da existe

				$arquivoBoletoDet->id_arquivo_boleto           = $arquivoBoleto->id;
				$arquivoBoletoDet->nome_apresentante           = utf8_decode(substr($detalhe,   1,  50));
				$arquivoBoletoDet->codigo_barra_boleto         = substr($detalhe,  52,  50);
				$arquivoBoletoDet->linha_digitavel_boleto      = substr($detalhe, 101,  55);
				$arquivoBoletoDet->nosso_numero_boleto         = substr($detalhe, 156,  20);
				$arquivoBoletoDet->agencia_codigo_cedente      = substr($detalhe, 176,  20);
				$arquivoBoletoDet->nome_cedente                = utf8_decode(substr($detalhe, 196,  50));
				$arquivoBoletoDet->nome_sacado                 = utf8_decode(substr($detalhe, 246, 150));
				$arquivoBoletoDet->documento_sacado            = substr($detalhe, 396,  20);
				$arquivoBoletoDet->endereco_sacado             = utf8_decode(substr($detalhe, 416, 200));
				$arquivoBoletoDet->nome_sacador                = utf8_decode(substr($detalhe, 616, 150));
				$arquivoBoletoDet->vencimento_boleto           = substr($detalhe, 766,   8);
				$arquivoBoletoDet->carteira_boleto             = substr($detalhe, 774,   3);
				$arquivoBoletoDet->aceite_boleto               = substr($detalhe, 777,   1);
				$arquivoBoletoDet->especie_pagamento_boleto    = substr($detalhe, 778,  10);
				$arquivoBoletoDet->numero_documento_boleto     = substr($detalhe, 788,  20);
				$arquivoBoletoDet->valor_principal_titulo      = substr($detalhe, 808,  14)/100; // Numerico tem q dividir por 100
				$arquivoBoletoDet->valor_custas_emolumento     = substr($detalhe, 822,  14)/100; // Numerico tem q dividir por 100
				$arquivoBoletoDet->valor_total_boleto          = substr($detalhe, 836,  14)/100; // Numerico tem q dividir por 100
				$arquivoBoletoDet->numero_ar                   = substr($detalhe, 850,  20);
				$arquivoBoletoDet->data_apontamento            = substr($detalhe, 870,   8);
				$arquivoBoletoDet->protocolo                   = substr($detalhe, 878,  10);
				$arquivoBoletoDet->especie_titulo              = substr($detalhe, 888,   3);
				$arquivoBoletoDet->numero_titulo               = substr($detalhe, 891,  20);
				$arquivoBoletoDet->data_emissao_titulo         = $this->dateTimeBanco(substr($detalhe, 911,  10));
				$arquivoBoletoDet->data_vencimento_titulo      = substr($detalhe, 921,  10);
				$arquivoBoletoDet->nosso_numero_titulo         = substr($detalhe, 931,  20);
				$arquivoBoletoDet->livro_apontamento           = substr($detalhe, 951,  10);
				$arquivoBoletoDet->folha_apontamento           = substr($detalhe, 961,   3);
				$arquivoBoletoDet->ordem_apontamento           = substr($detalhe, 964,  10);
				$arquivoBoletoDet->sequencial_registro_arquivo = substr($detalhe, 996,  4);
				$arquivoBoletoDet->impresso = 0;

				$arquivoBoletoDet->save();				
			}elseif ($identRegistro == 9) { // Footer
				$arquivoBoleto = ArquivoBoleto::find($arquivoBoleto->id);
				$arquivoBoleto->data_movimento                 = substr($detalhe,   1,   8);
				$arquivoBoleto->quantidade_remessa             = substr($detalhe,   9,   4);
				$arquivoBoleto->cartorio_id = Auth::user()->cartorio_id;

				$arquivoBoleto->save();
			}
		}

		fclose($file);
		return redirect('admin/remessaboleto')->with('sucesso',true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$registro = ArquivoBoletoDet::where('id', $id)
		->where('impresso', 0)
		->first();

		// Atualiza a primeira vez que for impresso
		if($registro){
			$registro->impresso = 1;
			$registro->dataprimimpressao = Carbon::now();
			$registro->save();
		}

        $boleto = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
			->select('arquivo_remessa_boleto_dets.id as id',
						
						'nome_apresentante',
						'nome_sacado',
						'nome_sacador',
						'nome_cedente',
						'documento_sacado',
						DB::raw('date_format(STR_TO_DATE(data_apontamento, "%d%m%Y"),"%d/%m/%Y") as data_apontamento'),
						'protocolo',

						'especie_titulo',
						'numero_titulo',
						'valor_principal_titulo',
						DB::raw('date_format(data_emissao_titulo,"%d/%m/%Y") as data_emissao_titulo'),

						DB::raw('ifnull(date_format(STR_TO_DATE(data_vencimento_titulo, "%d%m%Y"),"%d/%m/%Y"),'."'A VISTA'".') as data_vencimento_titulo'),
						'nosso_numero_titulo',

						'valor_custas_emolumento',
						'valor_total_boleto',
						'livro_apontamento',
						'folha_apontamento',
						'ordem_apontamento',
						'nosso_numero_boleto',
						'linha_digitavel_boleto',
						DB::raw('date_format(data_remessa,"%d/%m/%Y") as data_remessa'),
						'aceite_boleto',
						'carteira_boleto',
						'especie_pagamento_boleto',
						DB::raw('date_format(STR_TO_DATE(vencimento_boleto, "%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),
						'agencia_codigo_cedente',

						'endereco_sacado',
						'codigo_barra_boleto'
						)
			->where('arquivo_remessa_boleto_dets.id','=',$id)->first();
		
		$representante = Representante::where('user_id','=',Auth::user()->id)
						 ->where('cnpj','=', trim($boleto->documento_sacado))
						 ->count();

		$user = Auth::user();
		if ($user->papel_id!=2 && trim($boleto->documento_sacado) != $user->cpf) { // Caso o usuário queira visualizar dados de outra pessoa
			if ($representante = 0) {
				return redirect('admin/segundavia');
			}
		}

		return view('admin.segundavia.visualizar')
		->with('boleto',$boleto);
	}

	public function segundaviapublica($id)
	{	
		$registro = ArquivoBoletoDet::where('protocolo', '=', $id)
		->where('impresso', 0)
		->first();

		if($registro){
			$registro->impresso = 1;
			$registro->dataprimimpressao = Carbon::now();
			$registro->save();
		}

        $boleto = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
			->select('arquivo_remessa_boleto_dets.id as id',
						
						'nome_apresentante',
						'nome_sacado',
						'nome_sacador',
						'nome_cedente',
						'documento_sacado',
						DB::raw('date_format(STR_TO_DATE(data_apontamento, "%d%m%Y"),"%d/%m/%Y") as data_apontamento'),
						'protocolo',

						'especie_titulo',
						'numero_titulo',
						'valor_principal_titulo',
						DB::raw('date_format(data_emissao_titulo,"%d/%m/%Y") as data_emissao_titulo'),

						DB::raw('ifnull(date_format(STR_TO_DATE(data_vencimento_titulo, "%d%m%Y"),"%d/%m/%Y"),'."'A VISTA'".') as data_vencimento_titulo'),
						'nosso_numero_titulo',

						'valor_custas_emolumento',
						'valor_total_boleto',
						'livro_apontamento',
						'folha_apontamento',
						'ordem_apontamento',
						'nosso_numero_boleto',
						'linha_digitavel_boleto',
						DB::raw('date_format(data_remessa,"%d/%m/%Y") as data_remessa'),
						'aceite_boleto',
						'carteira_boleto',
						'especie_pagamento_boleto',
						DB::raw('date_format(STR_TO_DATE(vencimento_boleto, "%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),
						'agencia_codigo_cedente',

						'endereco_sacado',
						'codigo_barra_boleto'
						)
			->where('arquivo_remessa_boleto_dets.protocolo','=',$id)->first();

		if ($boleto) {
			return view('admin.segundavia.visualizar')
			->with('boleto',$boleto);
		} else {
			return view('/')
			->with('message1',"Protocolo não encontrado. Por favor, verifique.");
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

	}

	public function downloadPDF($id='')
	{
		$boleto = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
			->select('arquivo_remessa_boleto_dets.id as id',
				     
				     'nome_apresentante',
				     'nome_sacado',
				     'nome_sacador',
				     'nome_cedente',
				     'documento_sacado',
				     DB::raw('date_format(STR_TO_DATE(data_apontamento, "%d%m%Y"),"%d/%m/%Y") as data_apontamento'),
				     'protocolo',

				     'especie_titulo',
				     'numero_titulo',
				     'valor_principal_titulo',
				     DB::raw('date_format(data_emissao_titulo,"%d/%m/%Y") as data_emissao_titulo'),

				     DB::raw('date_format(STR_TO_DATE(data_vencimento_titulo, "%d%m%Y"),"%d/%m/%Y") as data_vencimento_titulo'),
				     'nosso_numero_titulo',

				     'valor_custas_emolumento',
				     'valor_total_boleto',
				     'livro_apontamento',
				     'folha_apontamento',
				     'ordem_apontamento',

				     'linha_digitavel_boleto',
				     DB::raw('date_format(data_remessa,"%d/%m/%Y") as data_remessa'),
				     'aceite_boleto',
				     'carteira_boleto',
				     'especie_pagamento_boleto',
				     DB::raw('date_format(STR_TO_DATE(vencimento_boleto, "%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),
				     'agencia_codigo_cedente',

				     'endereco_sacado',
				     'codigo_barra_boleto'
				     )
			->where('arquivo_remessa_boleto_dets.id','=',$id)->first();

		$user = Auth::user();
		if (trim($boleto->documento_sacado) != $user->cpf) { // Caso o usuário queira visualizar dados de outra pessoa
			return redirect('admin/segundavia');
		}

		$pdf = PDF::loadView('admin.segundavia.visualizar', compact('boleto'));

		return $pdf->stream('boleto.pdf', array("Attachment"=>0));
	}

	private function dateTimeBanco( $data )
	{
		$dia = substr($data, 0,2);
		$mes = substr($data, 3,2);
		$ano = substr($data, 6,4);
		
		return $ano.'-'.$mes.'-'.$dia;
	}

	private function dateStrTimeBanco( $data )
	{
		$dia = substr($data, 0,2);
		$mes = substr($data, 2,2);
		$ano = substr($data, 4,4);
		
		return $ano.'-'.$mes.'-'.$dia;
	}

	private function dateTimeBr($data)
	{
		$dia = substr($data, 0,4);
		$mes = substr($data, 5,2);
		$ano = substr($data, 8,2);
		
		return $dia.'/'.$mes.'/'.$ano;
	}
}
