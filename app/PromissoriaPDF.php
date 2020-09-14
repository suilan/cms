<?php namespace App;

use Fpdf;
use DateTime;

class PromissoriaPDF extends Fpdf {

	public function Header()
	{
		$this::Ln(7);

		$this::SetFont('Arial','B',12);
		$this::Cell(180,3,utf8_decode('NOTA PROMISSÓRIA'),0,1,'C');

		// Quebra de linha
		$this::Ln(16);
	}

	public function content($request)
	{	
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');

		$dataVencimento = $request->vencimento_titulo;
		$data = null;
		$dataSomada = null;
		$valorParcela = array();
		
		$valorParcela = $this->arrendondarParcelas(str_replace(",",".",str_replace(".","",$request->valor_prom)), $request->num_parcelas);

		for($i = 0; $i < $request->num_parcelas; $i++){

			$date = $this->dataDB($dataVencimento);

			if($i > 0){
				$dias = $i * 30;
				$data = strftime("%d de %B de %Y", strtotime("+".$dias."days",strtotime( $date )));
				$dataSomada = strftime("%d/%m/%Y", strtotime("+".$dias."days",strtotime( $date )));
				$this::AddPage();
			} else {
				$data = strftime("%d de %B de %Y", strtotime( $date ));
				$dataSomada = strftime("%d/%m/%Y", strtotime( $date ));
			}

			$this::SetFont('Arial','B',12);
			$this::MultiCell(186,4,'Vencimento em '.utf8_decode($data),0,'R');

			$this::ln(4); 

			$this::SetFont('Arial','B',12);
			$this::MultiCell(186,4,'R$ ( '.number_format($valorParcela[$i], 2, ',', '.').' )',0,'R');	
			
			$this::ln(8); 

			$this::SetFont('Arial','',12);
			$this::MultiCell(186,8,utf8_decode($this->dataExtenso($dataSomada)." pagaremos por esta única via de NOTA PROMISSÓRIA a ". strtoupper($request->credor)
			. " inscrito(a) no ".strtoupper($request->documento_credor_prom)." sob nº ". $request->cnpj_prom. ", ou a sua ordem, a quantia de (".strtoupper($this->valorPorExtenso('R$ '.$valorParcela[$i],true,false))
			.")  em moeda corrente deste país."),0,'J');

			$this::ln(8);
			$this::MultiCell(186,4,utf8_decode('Pagável em '.$request->cidade_prom.' - '.$request->uf_prom),0,'L');

			$this::ln(8);
			$this::MultiCell(186,4,utf8_decode($request->cidade_prom.', '.$data),0,'R');

			$this::ln(8);
			
			$this::SetFont('Arial','B',12);
			$this::Cell(20,3,'Emitente:','',0,'');
			$this::SetFont('Arial','',9);
			$this::Cell(70,3.5,strtoupper(utf8_decode($request->devedor)),'',0,'');
			
			$this::ln(6);

			$this::SetFont('Arial','B',12);
			$this::Cell(22,3,utf8_decode('Endereço:'),'',0,'');
			$this::SetFont('Arial','',9);
			$this::Cell(70,3.5,strtoupper(utf8_decode($request->logradouro_prom. ', '. $request->numero.' - '.$request->bairro_prom)),'',0,'');
			
			$this::ln(6);

			$this::SetFont('Arial','B',12);
			$this::Cell(24,3,utf8_decode('Cidade/UF:'),'',0,'');
			$this::SetFont('Arial','',9);
			$this::Cell(70,3.5,strtoupper(utf8_decode($request->cidade_prom. ' - '. $request->uf_prom)),'',0,'');
			
			$this::ln(6);

			$this::SetFont('Arial','B',12);
			$this::Cell(12,3,strtoupper(utf8_decode($request->documento)).':','',0,'');
			$this::SetFont('Arial','',12);
			$this::Cell(70,3.5,strtoupper(utf8_decode($request->documento_prom)),'',0,'');
			
			$this::ln(28);

			$this::SetFont('Arial','',12);
			$this::MultiCell(186,4,'____________________________________',0,'R');
			$this::ln(2);
			$this::SetFont('Arial','',8);
			$this::MultiCell(170,4,strtoupper(utf8_decode($request->devedor)),0,'R');

			$this::ln(18);
			if($request->avalista1){
				$this::SetFont('Arial','B',9);
				$this::Cell(80,4,utf8_decode('___________________________________________'),'',0,'');
			}
			
			if($request->avalista2){
				$this::SetFont('Arial','B',9);
				$this::Cell(80,4,utf8_decode('___________________________________________'),'',0,'');
			}

			$this::ln(6);
			
			if($request->avalista1){
				$this::SetFont('Arial','',9);
				$this::Cell(110,3,utf8_decode('                                    Avalista'),'',0,'');
			}

			if($request->avalista2){
				$this::SetFont('Arial','',9);
				$this::Cell(115,3,utf8_decode('Avalista'),'',0,'');
			}

			$this::ln(8);

			if($request->avalista1){
				$this::SetFont('Arial','',9);
				$this::Cell(10,3,utf8_decode('Nome:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(70,3,strtoupper(utf8_decode($request->avalista1)),'',0,'');
			}
			
			if($request->avalista2){
				$this::SetFont('Arial','',9);
				$this::Cell(10,3,utf8_decode('Nome:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(80,3,strtoupper(utf8_decode($request->avalista2)),'',0,'');
			}

			$this::ln(6);

			if($request->avalista1){
				$this::SetFont('Arial','',9);
				$this::Cell(15,3,utf8_decode('Endereço:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(65,3,strtoupper(utf8_decode($request->logradouro_avalista1. ', '. $request->numero_avalista1.' - '.$request->bairro_avalista1)),'',0,'');
			}
			
			if($request->avalista2){
				$this::SetFont('Arial','',9);
				$this::Cell(15,3,utf8_decode('Endereço:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(80,3,strtoupper(utf8_decode($request->logradouro_avalista2. ', '. $request->numero_avalista2.' - '.$request->bairro_avalista2)),'',0,'');
			}

			$this::ln(6);

			if($request->avalista1){
				$this::SetFont('Arial','',9);
				$this::Cell(17,3,utf8_decode('Cidade/UF:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(63,3,strtoupper(utf8_decode($request->cidade_avalista1. ' - '. $request->uf_avalista1)),'',0,'');
			}
			
			if($request->avalista2){
				$this::SetFont('Arial','',9);
				$this::Cell(17,3,utf8_decode('Cidade/UF:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(80,3,strtoupper(utf8_decode($request->cidade_avalista2. ' - '. $request->uf_avalista2)),'',0,'');
			}

			$this::ln(6);

			if($request->avalista1){
				$this::SetFont('Arial','',9);
				$this::Cell(17,3,utf8_decode('CPF/CNPJ:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(63,3,strtoupper(utf8_decode($request->cnpj_avalista1)),'',0,'');
			}
			
			if($request->avalista2){
				$this::SetFont('Arial','',9);
				$this::Cell(17,3,utf8_decode('CPF/CNPJ:'),'',0,'');
				$this::SetFont('Arial','',9);
				$this::Cell(80,3,strtoupper(utf8_decode($request->cnpj_avalista2)),'',0,'');
			}

		}
	}

	public function Footer(){

	}

	public static function dataDB($data)
	{
		if( $data )
		{
			$aux = explode('/',$data);
        	return $aux[2].'-'.$aux[1].'-'.$aux[0];
		}
		else return "";
	}

	public function dataExtenso($data){
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');

		$date = $this->dataDB($data);

		if( $data ){
			$aux = explode('/',$data);

			// Tratando a data
			$dia = "Aos ". $this->convert_number_to_words($aux[0]). " dias ";
			// Tratando a mês
			$mes = "do mês de ". strftime("%B", strtotime( $date )) . " ";
			// Tratando a ano
			$ano = "do ano de ". $this->convert_number_to_words($aux[2]);

        	return $dia.$mes.$ano;
		}
		else return "";
	}


	public function convert_number_to_words($number) {

		$hyphen      = '-';
		$conjunction = ' e ';
		$separator   = ', ';
		$negative    = 'menos ';
		$decimal     = ' ponto ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'um',
			2                   => 'dois',
			3                   => 'três',
			4                   => 'quatro',
			5                   => 'cinco',
			6                   => 'seis',
			7                   => 'sete',
			8                   => 'oito',
			9                   => 'nove',
			10                  => 'dez',
			11                  => 'onze',
			12                  => 'doze',
			13                  => 'treze',
			14                  => 'quatorze',
			15                  => 'quinze',
			16                  => 'dezesseis',
			17                  => 'dezessete',
			18                  => 'dezoito',
			19                  => 'dezenove',
			20                  => 'vinte',
			30                  => 'trinta',
			40                  => 'quarenta',
			50                  => 'cinquenta',
			60                  => 'sessenta',
			70                  => 'setenta',
			80                  => 'oitenta',
			90                  => 'noventa',
			100                 => 'cento',
			200                 => 'duzentos',
			300                 => 'trezentos',
			400                 => 'quatrocentos',
			500                 => 'quinhentos',
			600                 => 'seiscentos',
			700                 => 'setecentos',
			800                 => 'oitocentos',
			900                 => 'novecentos',
			1000                => 'mil',
			1000000             => array('milhão', 'milhões'),
			1000000000          => array('bilhão', 'bilhões'),
			1000000000000       => array('trilhão', 'trilhões'),
			1000000000000000    => array('quatrilhão', 'quatrilhões'),
			1000000000000000000 => array('quinquilhão', 'quinquilhões')
		);
	
		if (!is_numeric($number)) {
			return false;
		}
	
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}
	
		$string = $fraction = null;
	
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
	
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $conjunction . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = floor($number / 100)*100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				if ($baseUnit == 1000) {
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[1000];
				} elseif ($numBaseUnits == 1) {
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
				} else {
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
				}
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : ' ';
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}
	
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	
		return $string;
	}

	public function arrendondarParcelas ($valor, $nParcelas) {
		$parcelas = array();
		$valorArredondado = floor( $valor / $nParcelas);
	 
		for($i=$nParcelas; $i>=2; $i--){
			$parcelas[] = $valorArredondado;
		}
		
		$parcelas[] = $valor - ( $valorArredondado * ( $nParcelas - 1 ) );

		return $parcelas;
	 }

	 public function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
 
        $valor = self::removerFormatacaoNumero( $valor );
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
            
            
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? " " : " ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : “zero”.($bolExibirMoeda ? " reais e zero centavos" : "" ));
 
	}
	
	public static function removerFormatacaoNumero( $strNumero )
    {
 
        $strNumero = trim( str_replace( "R$", null, $strNumero ) );
 
        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }
 
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
 
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;
 
        return $resultado;
 
    }
}