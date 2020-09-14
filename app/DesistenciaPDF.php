<?php namespace App;

use Fpdf;

class DesistenciaPDF extends Fpdf {

	public function Header()
	{
        $this::Ln(7);

		$this::SetFont('Arial','B',12);
		$this::Cell(180,3,utf8_decode('REQUERIMENTO PARA DESISTÊNCIA'),0,1,'C');

		// Quebra de linha
		$this::Ln(30);
	}

	public function content($request)
	{	
		$this::Cell(180,3,utf8_decode('Ao'),0,1,'L');
		
		$this::Ln(8);

		$this::Cell(180,3,utf8_decode('Tabelião(ã) de Protesto de Letras e Títulos'),0,1,'L');
		
		$this::Ln(8);

		$this::Cell(180,3,utf8_decode(strtoupper($request->cidade_desist). '-' . strtoupper($request->uf_desist)),0,1,'L');
		
		$this::Ln(8);
		
		$this::Cell(180,3,utf8_decode('Prezado Senhor(a):'),0,1,'L');
		
		$this::Ln(8);

		// Devedor
		$this::SetFont('Arial','',12);
        $this::MultiCell(186,8, 
		    strtoupper(utf8_decode($request->credor_desist)). ', ' .strtoupper(utf8_decode($request->credor_nac)). ', ' .strtoupper(utf8_decode($request->credor_civil)).
            ', ' .strtoupper(utf8_decode($request->credor_prof)). ', RG. ' .strtoupper(utf8_decode($request->rg)). ', CPF ' .strtoupper(utf8_decode($request->cred_cnpj_desist)).
            ', residente e domiciliado(a) nesta cidade, na ' .strtoupper(utf8_decode($request->logradouro_desist)). ', ' .strtoupper(utf8_decode($request->numero_desist)). ' - ' .strtoupper(utf8_decode($request->bairro_desist)). ' - '. strtoupper(utf8_decode($request->cidade_desist)). '/' . strtoupper(utf8_decode($request->uf_desist)). ' - CEP ' . strtoupper(utf8_decode($request->cep_desist)).
			utf8_decode(', vem requerer a retirada, sem protesto, do título abaixo descriminado, protocolado nesse Tabelionato sob o número ') .strtoupper(utf8_decode($request->num_protocolo)). ', em data de ' .strtoupper(utf8_decode($request->data_protocolo)). utf8_decode(', uma vez que não há mais interesse no protesto do mesmo.'),0,'J');
		
		$this::Ln(20);

		$this::Cell(180,3,utf8_decode('Espécie: '. $request->especie_desist),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('Número: '. $request->num_titulo_desist),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('Data da Emissão: '. $request->emissao_titulo_desist),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('Data do Vencimento: '. $request->vencimento_titulo_desist),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('Valor: '. $request->valor_desist . '  (' . $request->valor_extenso_desist . ')'),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('Devedor: '. strtoupper($request->devedor_desist)),0,1,'L');
		$this::Ln(6);
		$this::Cell(180,3,utf8_decode('CPF/CNPJ: '. $request->documento_desist_num),0,1,'L');
		
		$this::Ln(30);

		$this::Cell(180,3,utf8_decode('Por ser expressão da verdade, firmo a presente.'),0,1,'C');
		$this::Ln(6);

		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		$this::Cell(186,3,utf8_decode($request->cidade_desist).', '.utf8_decode(strftime('%d de %B de %Y', strtotime('today'))),0,1,'C');

		$this::Ln(15);

		$this::Cell(180,3,utf8_decode('___________________________________________________'),0,1,'C');
		
		$this::Ln(2);

		$this::SetFont('Arial','',8);
		$this::Cell(180,3,strtoupper(utf8_decode($request->credor_desist)),0,1,'C');
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
