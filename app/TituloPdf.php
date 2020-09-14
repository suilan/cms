<?php namespace App;

use Fpdf;

class TituloPdf extends Fpdf {

	public $ficha = "TÍTULO";

	public function Header()
	{
		// Seleciona fonte Arial bold 15
		$this::SetFont('Arial','B',10);
		$this::Image(asset('admin/img/logo.png'),70,10,-300);
		$this::Ln(40);

		$this::Ln(7);

		$this::SetFont('Arial','B',10);
		$this::Cell(180,3,utf8_decode('FICHA DE '.$this->ficha),0,1,'C');

		// Quebra de linha
		$this::Ln(6);
	}

	public function content($titulo, $cartorio)
	{
		// Devedor
		$this::SetFont('Arial','B',6);
		$this::Cell(130,3,'Sacado/'.utf8_decode('Endereço'),'L',0,'L');
		$this::Cell(25,3,'Data '.utf8_decode('Emissão'),'L',0,'L');
		$this::Cell(25,3,'Vencimento ','L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(80,5, strtoupper(utf8_decode($titulo->devedor_nome)),'L',0,'L');
		$this::Cell(50,5, 'CPF/CNPJ:'.utf8_decode($titulo->documento),0,0,'L');
		$this::Cell(25,5, $titulo->emissao,'L B',0,'L');
		$this::Cell(25,5, $titulo->vencimento,'L B',1,'L');

		$this::Cell(130,5, strtoupper(utf8_decode($titulo->endereco.','.$titulo->numero.' - '.$titulo->bairro)),'L',0,'L');
		$this::SetFont('Arial','B',6);
		$this::Cell(25,5, utf8_decode('Nosso Número'),'L',0,'L');
		$this::Cell(25,5, utf8_decode('Edital'),'L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(80,5, strtoupper(utf8_decode($titulo->cidade.' - '.$titulo->uf)),'L B',0,'L');
		$this::Cell(50,5, 'CEP:'.$titulo->cep,'B',0,'L');
		$this::Cell(25,5, $titulo->nosso_numero,'L B',0,'L');
		$this::Cell(25,5, $titulo->edital,'L B',1,'L');

		$this::ln();

		// Favorecido
		$this::SetFont('Arial','B',6);
		$this::Cell(130,3,'Cedente/Favorecido','L',0,'L');
		$this::Cell(22,3,utf8_decode('Espécie'),'L',0,'L');
		$this::Cell(25,3,utf8_decode('Número do Título'),'L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(130,5, strtoupper(utf8_decode($titulo->cedente)),'L B',0,'L');
		$this::Cell(22,5, strtoupper(utf8_decode($titulo->especie_nome)),'L B',0,'L');
		$this::Cell(28,5, utf8_decode($titulo->numero_titulo),'L B',1,'L');
		$this::ln(1);

		$this::SetFont('Arial','B',6);
		$this::Cell(130,3,utf8_decode('Praça'),'L',0,'L');
		$this::Cell(50,3,'Protocolo','L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(130,5, utf8_decode(strtoupper($cartorio->cidade_nome)),'L B',0,'L');
		$this::Cell(50,5, utf8_decode($titulo->protocolo),'L B',1,'L');
		$this::ln(1);

		$this::SetFont('Arial','B',6);
		$this::Cell(30,3,utf8_decode('Código do Cedente'),'L',0,'L');
		$this::Cell(70,3,'Endosso','L',0,'L');
		$this::Cell(30,3,'Remessa','L',0,'L');
		$this::Cell(50,3,utf8_decode('Valor do Título'),'L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(30,5,'','L B',0,'L');
		$this::Cell(70,5,strtoupper(utf8_decode($titulo->endosso_nome)),'L B',0,'L');
		$this::Cell(30,5,$titulo->remessa_id,'L B',0,'L');
		// $this::Cell(35,5,utf8_decode($cartorio->cidade_nome).' - '.$cartorio->uf,'L B',0,'L');
		$this::Cell(50,5,utf8_decode('R$ '.$titulo->valor),'L B',1,'L');
		$this::ln(1);

		$this::SetFont('Arial','B',6);
		$this::Cell(130,3,'Sacador/'.utf8_decode('Endereço'),'L',1,'L');

		$this::SetFont('Arial','',9);
		$this::Cell(130,5, strtoupper(utf8_decode($cartorio->nome)),'L',0,'L');
		$this::Cell(50,5, 'CNPJ:'.utf8_decode($cartorio->cnpj),'',1,'L');
		$this::Cell(180,5, strtoupper(utf8_decode($cartorio->endereco).', '.$cartorio->numero),'L',1,'L');
		$this::Cell(130,5, strtoupper(utf8_decode($cartorio->cidade_nome).' - '.$cartorio->uf),'L B',0,'L');
		$this::Cell(50,5, 'CEP:'.$cartorio->cep,'B',1,'L');

		$this::ln(20);
	}

	public function Footer()
	{
		$this->SetY(-15);

		// Seleciona fonte Arial bold 15
		$this::SetFont('Arial','',8);
		$this::MultiCell(186,4,utf8_decode('Av. Daniel de La Touche, 978 - Cohama - Centro Empresarial Shopping da Ilha, Torre 1, 12° andar, Sala 1211 - São Luís/Maranhão - Brasil - CEP: 65.074-115'),0,'C');

		$this->Cell(190,3,$this->PageNo(),0,1,'R');
	}
}
