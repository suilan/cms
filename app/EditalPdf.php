<?php 
namespace App;

use Fpdf;
use App\Titulo;

class EditalPdf extends Fpdf {

	public $edital; 
    public $cartorio;

	public function Header()
	{
		// Seleciona fonte Arial bold 15
		$this->SetFont('Arial','B',13);
		$this->Cell(180,3,utf8_decode($this->cartorio->nome),0,1,'C');	
		$this->Ln(4);

		// Seleciona fonte Arial bold 15
		$this->SetFont('Arial','',8);
		$this->Cell(180,3,utf8_decode($this->cartorio->endereco.", ".$this->cartorio->bairro.", ".$this->cartorio->numero." - ".$this->cartorio->cidade_nome."/".$this->cartorio->uf),0,1,'C');	
		// $this->Cell(180,3,utf8_decode('Centro Empresarial Shopping da Ilha, Torre 1, 12° andar, Sala 1211'),0,1,'C');	
		$this->Ln(1);
		$this->Cell(180,3,utf8_decode('FONE: '.$this->cartorioContato[0]->contato),0,1,'C');	
		$this->Ln(7);

		$this->SetFont('Arial','B',12);
		$this->Cell(180,3,utf8_decode('EDITAL DE INTIMAÇÃO Nº '.$this->edital->id),0,1,'C');	
		$this->Ln(7);

		$this->SetFont('Arial','',10);
		$this->MultiCell(186,4,utf8_decode('FAÇO SABER, que se encontra em Cartório, para ser protestado, por falta de pagamento, o(s) seguinte(s) título(s)'),0,1);
		$this->Ln(8);
	}

	public function content($titulo, $background)
	{
		// Devedor
		$this->SetFont('Arial','',10);
		$this->MultiCell(186,4,utf8_decode('Nº Apto: '.$titulo->numero_titulo.' Sacado: '.strtoupper(trim($titulo->devedor_nome)).''.($titulo->tipo_doc==1?' CPF':' CNPJ').': '.$titulo->documento.' Espécie: '.$titulo->especie_nome.' Emissão: '.$titulo->emissao.' Venc.: '.$titulo->vencimento.' Valor: R$'.$titulo->valor.' Nº Título: '.$titulo->numero_titulo.' Apresentante: Cedente: Protocolo: '.$titulo->protocolo.' Limite para pagamento: '.$titulo->vencimento),0,'J',$background);

		$this->ln(4);
	}

	public function paragrafoFinal()
	{  
        $endereco = utf8_decode($this->cartorio->endereco.", ".$this->cartorio->bairro.", ".$this->cartorio->numero." - ".$this->cartorio->cidade_nome."/".$this->cartorio->uf);
        
		$this->SetFont('Arial','',10);
		$this->MultiCell(186,4,utf8_decode('Como não foi possível encontrar o responsável para ser intimado pessoalmente, em razão de o Aviso de Recebimento (arquivado nesta Serventia) ter retornado dos correios. INTIMU-O pelo presente edital para que no prazo de três dias, ou seja, até o dia'. $this->edital->emissao .'no horário das 8h até as 12h e das 14h até as 18h, COMPAREÇA neste Serviço de Registro de Protesto de Títulos, localizado na '.utf8_encode($endereco).', para PAGAR o que lhe é cobrado ou DAR AS RAZÕES pelas quais deixa de fazê-lo, sob pena de ter o título protestado pelo credor-apresentante, vinte e quatro horas depois de completada a presente intimação. E, para que chegue ao conhecimento de todos os interessados e de futuro ninguém possa alegar ignorância, expediu-se o presente edital que será afixado, por um dia, no lugar público de costume. Dado e passado nesta Cidade e Comorca de '.$this->cartorio->cidade_nome.', Estado do Maranhão, pelo '.$this->cartorio->nome.'. Eu, '.strtoupper(utf8_decode($this->cartorio->responsavel_nome)).' - Tabelião(ã), escrevi, subscrevi, conferi, selei o presente edital, dou fé e assino.'),0,'J');
		$this->Ln(3);
		$this->MultiCell(186,4,utf8_decode('O presente edital também se encontra publicado no jornal do Estado do Maranhão no dia 22/05/2017.'),0,'J');
		$this->Ln(3);
		$this->MultiCell(186,4,utf8_decode('O cartório não solicita deposito em conta corrente para quitação de protesto. Fique atento.'),0,'J');
		$this->Ln(7);
		
	}

	public function Footer()
	{
		$this->ln(7);

		$this->SetFont('Arial','',10);
		// $this->SetX(132);
		$this->Cell(180,3,utf8_decode($this->cartorio->cidade_nome."/".$this->cartorio->uf.', ').date('d/m/Y'),0,1,'C');	
		$this->ln(10);

		$this->SetFont('Arial','',10);
		// $this->SetX(16);
		$this->Cell(180,3,utf8_decode('_________________________________________'),0,1,'C');	
		$this->ln(1);

		// $this->SetFont('Arial','B',10);
		// $this->Cell(180,3,utf8_decode($this->cartorio->responsavel_nome),0,1,'R');
		$this->SetFont('Arial','B',10);
		$this->Cell(180,3,utf8_decode($this->cartorio->responsavel_nome),0,1,'C');

		$this->ln(2);
		$this->SetFont('Arial','',10);
		$this->Cell(180,3,utf8_decode('Tabelião(ã)'),0,1,'C');
	}
}
