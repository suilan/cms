<?php namespace App;

use Fpdf;

class AnuenciaPDF extends Fpdf {

	public function Header()
	{
	}

	public function content($request, $imagePath)
	{
		// Seleciona fonte Arial bold 15
		$this::SetFont('Arial','B',10);
		if ($imagePath != null){
			$this::Image($imagePath,50,10,100,-150);
			$this::Ln(47);
		} else {
			$this::Ln(17);
		}

		$this::Cell(180,3,utf8_decode('ANUÊNCIA PARA CANCELAMENTO DE PROTESTO'),0,1,'C');

		// Quebra de linha
		$this::Ln(10);
		
		// Devedor
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,'Credor','',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,'CNPJ','',0,'');
		$this::ln(4);        
		$this::SetFont('Arial','',9);
		$this::Cell(70.5,5, strtoupper(utf8_decode($request->credor)),'',0,'');
		$this::SetFont('Arial','',9);
		$this::Cell(70,5, strtoupper(utf8_decode($request->cnpj)),'',0,'');

		$this::ln(11);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Endereço'),'',0,'');
		$this::ln(4);
		$this::SetFont('Arial','',9);
		$this::Cell(70.5,5, strtoupper(utf8_decode($request->logradouro.', '.$request->numero.' - '.$request->bairro.' - '.$request->cidade.'/'.$request->uf)),'',0,'');

		$this::ln(14);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Por seu(s) representante(s) legal(ais) abaixo assinado(s) e qualificado(s), declara ter recebido o pagamento do título adiante'),'',0,'');
		$this::ln(5);
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('descrito, dando plena e geral quitação do mesmo, autorizando o cancelamento de seu protesto:'),'',0,'');

		$this::ln(14);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,'Devedor','',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,'CPF/CNPJ','',0,'');
		$this::ln(4);        
		$this::SetFont('Arial','',9);
		$this::Cell(70.5,5, strtoupper(utf8_decode($request->devedor)),'',0,'');
		$this::SetFont('Arial','',9);
		$this::Cell(70,5, strtoupper(utf8_decode($request->documento)),'',0,'');

		$this::ln(11);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Nº do Título'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Espécie do Título'),'',0,'');
		$this::ln(4);        
		$this::SetFont('Arial','',9);
		$this::Cell(70.5,5, strtoupper(utf8_decode($request->num_titulo)),'',0,'');
		$this::SetFont('Arial','',9);
		$this::Cell(70,5, strtoupper(utf8_decode($request->especie)),'',0,'');
		
		$this::ln(11);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Valor do Título'),'',0,'');
		$this::ln(4);
		$this::SetFont('Arial','',9);
		$this::Cell(70,5, strtoupper('R$ '.utf8_decode($request->valor.' ('.$request->valor_extenso.')')),'',0,'');

		$this::ln(11);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Data de emissão do Título'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Data de vencimento do Título'),'',0,'');
		$this::ln(4);        
		$this::SetFont('Arial','',9);
		$this::Cell(70.5,5, strtoupper(utf8_decode($request->emissao_titulo)),'',0,'');
		$this::SetFont('Arial','',9);
		$this::Cell(70,5, strtoupper(utf8_decode($request->vencimento_titulo)),'',0,'');

		$this::ln(20);

		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		$this::SetFont('Arial','B',8);
		$this::MultiCell(186,4,utf8_decode($request->cidade).', '.utf8_decode(strftime('%d de %B de %Y', strtotime('today'))),0,'C');

		$this::ln(10);

		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Representante(s) Legal(ais)'),'',0,'');

		$this::ln(10);

		$this::SetFont('Arial','B',9);
		$this::Cell(80,3,utf8_decode('Nome:'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Nome:'),'',0,'');

		$this::ln(6);

		$this::SetFont('Arial','B',9);
		$this::Cell(80,3,utf8_decode('CPF.:'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('CPF.:'),'',0,'');

		$this::ln(6);

		$this::SetFont('Arial','B',9);
		$this::Cell(80,3,utf8_decode('Cargo:'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(70,3,utf8_decode('Cargo:'),'',0,'');

		$this::ln(12);

		$this::SetFont('Arial','B',9);
		$this::Cell(80,3,utf8_decode('___________________________________________'),'',0,'');
		$this::SetFont('Arial','B',9);
		$this::Cell(80,3,utf8_decode('___________________________________________'),'',0,'');
		
		$this::ln(4);

		$this::SetFont('Arial','',9);
		$this::Cell(80,3,utf8_decode('ASSINATURA COM RECONHECIMENTO DE FIRMA'),'',0,'');
		$this::SetFont('Arial','',9);
		$this::Cell(80,3,utf8_decode('ASSINATURA COM RECONHECIMENTO DE FIRMA'),'',0,'');
	}

	public function Footer()
	{

		// $this::ln(17);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('Observações:'),'',0,'');

		// $this::ln(6);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('1.Deve ser impressa em papel timbrado da empresa ou conter o carimbo do CNPJ.;'),'',0,'');

		// $this::ln(6);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('2.É obrigatório o reconhecimento de firma da assinatura do(s) representante(s) legal(ais) da empresa credora (Art.  26 § 1º da Lei'),'',0,'');

		// $this::ln(6);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('9.492 de 10/09/1997 e Capítulo XV, ítem 94 das Normas de Serviços da Corregedoria Geral da Justiça do Estado de São Paulo'),'',0,'');

		// $this::ln(6);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('- Prov. 27/2013) ;'),'',0,'');

		// $this::ln(6);

		// $this::SetFont('Arial','',9);
		// $this::Cell(80,3,utf8_decode('3.Se assinada por procurador(es), deverá juntar original ou cópia autenticada da procuração.'),'',0,'');
	}
}
