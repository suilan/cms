<?php namespace App;

require('../vendor/php-excel-reader/spreadsheet-reader/src/PHPExcelReader/SpreadsheetReader.php');

use PHPExcelReader\SpreadsheetReader;
use Illuminate\Support\MessageBag;
use App\Cidade;
use App\Endosso;
use App\Especie;
use DB;
use Session;

class TituloXls {

	private $reader =null;

	public function __construct($file='')
	{
		$this->reader = new SpreadsheetReader($file);
	}

	public function dump()
	{
		echo $this->reader->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel');
	}

	public function save( $userId, $cartorioId, $remessaId )
	{
		// 18 columns
		$cidades = Cidade::where('uf','=','MA')->lists('id');
		$endossos = Endosso::where('status','=','1')->lists('id');
		$especies = Especie::where('status','=','1')->lists('id');
		$qtdRows = $this->reader->rowcount();
		for ($row=2; $row <= $qtdRows ; $row++) { 

			$tipoDoc = $this->reader->val($row,1);
			if( !$tipoDoc ) break;
			
			$devedor = new Devedor;
			$devedor->tipo_doc = $tipoDoc;// 1-CPF | 2-CNPJ
			$devedor->documento = $this->reader->val($row,2); // Mascaras
			$devedor->nome = $this->reader->val($row,3);
			$devedor->cep = $this->reader->val($row,4);// Mascara

			$cidadeID = $this->reader->val($row,5);
			if( !in_array($cidadeID, $cidades) )
			{
				$messageBag = new MessageBag;
				$messageBag->add('Linha '.$row, 'Cidade não encontrada em nossa base.');
				Session::flash('errors',$messageBag);
				break;
			}
			$devedor->cidade_id = $cidadeID; //Id da cidade no banco
			$devedor->endereco = $this->reader->val($row,6);
			$devedor->numero = $this->reader->val($row,7);
			$devedor->bairro = $this->reader->val($row,8);
			$devedor->save();

			$titulo = new Titulo;
			$titulo->user_id = $userId;
			$titulo->cartorio_id = $cartorioId;
			$titulo->remessa_id = $remessaId;
			$titulo->devedor_id = $devedor->id;
			$titulo->protocolo = $this->reader->val($row,9);
			$titulo->numero_titulo = $this->reader->val($row,10);

			$emissao = $this->reader->val($row,11);
			$titulo->emissao = $this->dataDB($emissao);// Formato dia/mes/ano
			$titulo->tipo_vencimento_id = $this->reader->val($row,12); //1-Manual | 2- À Vista

			$vencimento = $this->reader->val($row,13);
			$titulo->vencimento = $this->dataDB($vencimento);
			$titulo->valor = str_replace(',','.',$this->reader->val($row,14));
			$titulo->saldo = str_replace(',','.',$this->reader->val($row,15));

			// Endosso
			$endossoID = $this->reader->val($row,16);
			if( !in_array($endossoID, $endossos) )
			{
				$messageBag = new MessageBag;
				$messageBag->add('Linha '.$row, 'Linha '.$row.': Endosso não encontrado em nossa base.');
				Session::flash('errors',$messageBag);
				break;
			}
			$titulo->endosso_id = $endossoID;

			// Especie
			$especieID = $this->reader->val($row,17);
			if( !in_array($especieID, $especies) )
			{
				$messageBag = new MessageBag;
				$messageBag->add('Linha '.$row, 'Linha '.$row.': spécie de título não encontrado em nossa base.');
				Session::flash('errors',$messageBag);
				break;
			}
			$titulo->especie_id = $especieID;
			$titulo->fim_falimentar = $this->reader->val($row,18);// 1-Sim | 0-Não
			$titulo->save();
		}
	}

	private static function dataBr($data)
	{
		if( $data )
		{
			$aux = explode('-',$data);
        	return $aux[2].'/'.$aux[1].'/'.$aux[0];
		}
		else return "";
	}

	private static function dataDB($data)
	{
		if( $data )
		{
			$aux = explode('/',$data);
        	return $aux[2].'-'.$aux[1].'-'.$aux[0];
		}
		else return "";
	}

}
