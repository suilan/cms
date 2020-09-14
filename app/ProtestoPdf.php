<?php 
namespace App;
use Fpdf;

class ProtestoPdf extends Fpdf {

	public $ficha = "Consulta Pública de Protestos";
	public $header = 0;

	public function Header()
	{
		// Seleciona fonte Arial bold 15
		$this->SetFont('Arial','B',10);
		$this->Image(asset('site/images/logo.png'),70,10,-300);

		$this->SetTextColor(255,0,0);
		$this->Ln(25);
		$this->Cell(0,3, utf8_decode('Os dados fornecidos têm caráter exclusivamente informativo, sem validade de certidão.'),0,1,'C');	
		$this->Cell(0,3, utf8_decode('O prazo para exclusão do registro de protesto da base é de 5 dias após o cancelamento do protesto no cartório.'),0,1,'C');	
		$this->SetTextColor(0,0,0);
		$this->Ln(25);

		if( $this->header ){
			// angle,x,y
			$this->Rotate(45,25,230);
			$this->SetFont('Arial','B',50);
			$this->SetTextColor(211,211,211);
			$this->Text(25,230,utf8_decode('Não possui valor de certidão.'));
			$this->Rotate(0);
			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);
		}
		// $this->Cell(150,5,utf8_decode('Institutito de Protestos - Maranhão'),0,1,'L');
		// Quebra de linha
		$this->Ln(10);
	}

	public function content($cartorios,$qtdProtestos,$doc)
	{

		// Header with results and search date 
		$this->SetFont('Arial','B',10);
		$this->Cell(130,3, $doc." - ".$qtdProtestos." Resultado(s)" ,0,0,'L');	
		$this->Cell(25,3,'Data da Consulta: '.date('d/m/Y'),0,1,'L');	
	    $this->Ln(2);

		// Show protestos by state
		foreach ( $cartorios as $estado => $c ) 
		{
		    // Header
		    if( $this->GetY()>260 ) $this->Ln(9);
		    $this->SetFont('Arial','B',10);
		    $this->Cell(180,7,strtoupper(utf8_decode($estado)),1);
		    $this->Ln();

		    $this->Cell(90,5,utf8_decode('Cartório'),1);
		    $this->Cell(20,5,'Telefone',1);
		    $this->Cell(30,5,'Cidade',1);
		    $this->Cell(30,5,utf8_decode('Dt. Atualização'),1);
		    $this->Cell(10,5,'Qtd.',1);
		    $this->Ln(5);


		    // Data
		    foreach($c as $row)
		    {
		    	$lineHeight = 7;
				$this->SetFont('Arial','',7);

				// break cartorio name to fit the line 
				$nome = strtoupper(utf8_decode($row['nome']));
				if( strlen($nome)>55 ) {
					$currentY = $this->GetY();
					$this->Cell(90,4,substr($nome, 0,55),'L R');
					$this->Ln();
					$this->Cell(90,4,substr($nome,55),'L B R');
					$this->SetY($currentY);
					$this->SetX(100);
					$lineHeight=8;
				}
				else{
					$this->Cell(90,$lineHeight,$nome,1);
				}
				$this->Cell(20,$lineHeight,is_string($row['telefone'])?$row['telefone']:'',1,'','C');

				// break cidade to fit the line
				$cidade = strtoupper(utf8_decode($row['cidade']));
				if( strlen($cidade)>15 ) {
					$currentY = $this->GetY();
					$currentX = $this->GetX();
					$this->Cell(30,4,substr($cidade, 0,15),'L R');
					$this->Ln();
					$this->SetX($currentX);
					$this->Cell(30,4,substr($cidade,15),'L B R');
					$this->SetY($currentY);
					$this->SetX($currentX+30);
					$lineHeight=8;
				}
				else{
					$this->Cell(30,$lineHeight,$cidade,1);
				}
				// $this->Cell(30,$lineHeight,,1);
				$this->Cell(30,$lineHeight,date("d/m/Y", strtotime($row['dt_atualizacao'])),1,'','C');
				$this->Cell(10,$lineHeight,$row['protestos'],1,'','C');
				$this->Ln();
		    }

		    $this->Ln(4);
		}

	}

	public function Footer()
	{
		// Seleciona fonte Arial bold 15
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(180,3,utf8_decode('Av. Daniel de La Touche, 978 - Cohama - Centro Empresarial Shopping da Ilha, Torre 1, 12° andar, Sala 1211'),0,1,'C');	
		$this->Ln(1);
		$this->Cell(180,3,utf8_decode('São Luís/Maranhão - Brasil - CEP: 65.074-115'),0,1,'C');	
		$this->Cell(190,3,$this->PageNo(),0,1,'R');	
	}
}
