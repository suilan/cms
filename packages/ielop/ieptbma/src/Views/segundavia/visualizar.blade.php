<?php require_once('../vendor/geradorcodbarra/lib/boletosPHP.php'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>2 Via do Boleto</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body { margin: 0; font-size: 60%; font-family: Helvetica, Arial, "sans-serif"; text-align: -webkit-center}
        p,pre { margin: 0; }
        small { font-size: 85%; font-family: Times, "Times New Roman", "serif"; }
        td { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
        .serif { font-family: Times, "Times New Roman", "serif"; }
        .sans { font-family: Helvetica, Arial, "sans-serif"; }
        .ph { padding-left: 6px; padding-right: 6px; }
        .pv { padding-top: 6px; padding-bottom: 6px; }
        .tr { text-align: right; }
        .tl { text-align: left; }
        .fr { float: right; }
        .big { font-size: 120%; }
        .bigprazo { font-size: 119%; }
        .bigger { font-size: 150%; }
        .biggest { font-size: 200%; }
        .bottom { border-bottom: 1px solid #000; }
        .left { border-left: 1px solid #000; }
        .right { border-right: 1px solid #000; }
        .border1 { border: 1px solid #000; }
        .border2 { border: 2px solid #000; }
        .border3 { border: 3px solid #000; }
        .bg { position: relative; overflow: hidden;}
        .bg:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            border-top: 50px solid #bfbfbf;
            border-bottom: 50px solid #bfbfbf;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .center { text-align: center; }
    </style>
</head>

<body bgcolor="#ffffff">
    <table border="0" cellpadding="0" cellspacing="0" width="666">
        <tr>
            <td width="292" height="180" valign="top">
                <br>
                <div style="width: 100px; overflow: hidden;">
                    <?php 
                        $barras = new boletosPHP();
                        $barras->setBarras($boleto->protocolo);
                        $barras ->desenhaBarras();
                    ?>
                </div>
                <p style="letter-spacing: 4px; text-align: center; margin-left: 4px; width: 10px;">
                    {{$boleto->protocolo}}
                </p> 
                <br><br>
                Data Apto: {{ $boleto->data_apontamento }} <br> <br>
                Vencimento Boleto: {{ $boleto->vencimento_boleto }} <br><br>
                Emitido em {{ date('d/m/Y') }} <br><br>
                Sacado: {{ $boleto->nome_sacado }}
            </td>
            <td width="480" height="180"></td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="666">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" width="666">
                    <tr>                                     
                        <td width="52.2" height="51.6"><img src="{{ asset('admin/img/logo-federal.png') }}" />
                        </td>
                        <td width="523.8" height="51.6">
                            <p><strong class="big">2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS</strong></p>
                            <p>
                                Av. dos Holandeses, 1, Quadra 36, Loja 19, Shopping do Automóvel, Bairro: Calhau, CEP: 65071-380 - São Luís-MA <br />
                                Fone/Fax: (98) 3303-6413
                            </p>
                        </td>
                        <td width="110" height="86" valign="top" class="ph pv">
                           <p class="tr">
                            <small>Emitido em {{ date('d/m/Y') }} <br /> Protocolo</small><br>
                            <div style="width: 100px; height: 25px; overflow: hidden;">
                                <?php 
                                   $barras = new boletosPHP();
                                   $barras->setBarras($boleto->protocolo);
                                   $barras ->desenhaBarras();
                                 ?>
                             </div>
                             <p style="letter-spacing: 4px; text-align: center; margin-left: 4px;">
                                 {{$boleto->protocolo}}
                             </p>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th width="666" height="22.8" class="bg border2 center serif" style="padding-top: 5px;"><strong class="biggest">AVISO PARA PROTESTO - INTIMAÇÃO</strong></th>
        </tr>
        <tr>
            <td width="666" height="34.8" class="">O OFICIAL DE PROTESTO DO 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DESTA CIDADE DE SÃO LUÍS-MA, INTIMA O SACADOR/DEVEDOR, NO PRAZO DE 03 (TRÊS) DIAS ÚTEIS, CONFORME A LEI N 9492 DE 10/09/97, PAGAR OU DECLARAR O(S) MOTIVO(S) PORQUE NÃO FAZ, O TÍTULO DE SUA RESPONSABILIDADE COM AS CARACTERÍSTICAS ABAIXO SOB PENA DE PROTESTO.</td>
        </tr>
        <tr>
            <td width="666" height="181.2">
                <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="666">
                    <tr>
                        <td width="441.6" height="181.2">
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="441.6">
                                <tr>
                                    <td width="441.6" height="70.8">
                                        <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="441.6" class="border2">
                                            <tr>
                                                <td width="314.4" height="23.4" colspan="2" class="ph right bottom">
                                                    <small>Sacado</small><br>
                                                    {{ $boleto->nome_sacado }}
                                                </td>
                                                <td width="127.2" height="23.4" class="ph bottom">
                                                    <small>CNPJ/CPF</small><br>
                                                    {{ $boleto->documento_sacado }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="314.4" height="23.4" colspan="2" class="ph right bottom">
                                                    <small>Apresentante</small><br>
                                                    {{ $boleto->nome_apresentante }}
                                                </td>
                                                <td width="127.2" height="23.4" class="ph bottom">
                                                    <small>Data do Apontamento</small><br>
                                                    {{ $boleto->data_apontamento }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="164.4" height="24" class="ph right bottom">
                                                    <small>Sacador</small><br>
                                                    {{ $boleto->nome_sacador }}
                                                </td>
                                                <td width="150" height="24" class="ph right bottom">
                                                    <small>Cedente</small><br>
                                                    {{ $boleto->nome_cedente }}
                                                </td>
                                                <td width="127.2" height="24" class="ph bottom">
                                                    <small>PROTOCOLO Nº</small><br>
                                                    {{ $boleto->protocolo }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="441.6" height="2"></td>
                                </tr>
                                <tr>
                                    <td width="441.6" height="109.8">
                                        <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="441.6" class="border2">
                                            <tr>
                                                <td height="16.8" colspan="5" class="center bottom serif"><strong class="bigger">CARACTERÍSTICAS DO TÍTULO</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="67.2" height="25.2" class="ph bottom right">
                                                    <small>Espécie</small><br>
                                                    {{ $boleto->especie_titulo }}
                                                </td>
                                                <td width="169.8" height="25.2" class="ph bottom right">
                                                    <small>Número</small><br>
                                                    {{ $boleto->numero_titulo }}
                                                </td>
                                                <td width="70.2" height="25.2" class="ph bottom right">
                                                    <small>Valor</small><br>
                                                    <span class="fr">R$ {{ $boleto->valor_principal_titulo }}</span>
                                                </td>
                                                <td width="67.8" height="25.2" class="ph bottom right">
                                                    <small>Emissão</small><br>
                                                    {{ $boleto->data_emissao_titulo }}
                                                </td>
                                                <td width="66.6" height="25.2" class="ph bottom">
                                                    <small>Vencimento</small><br>
                                                    {{ $boleto->data_vencimento_titulo }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" rowspan="2" class="ph pr">
                                                    1) O pagamento devido poderá ser feito em qualquer agência bancária ou em Cartório, das 09:00 as 16:30 horas; O PAGAMENTO COM VALOR A MENOR OU APÓS O VENCIMENTO NÃO EVITA O PROTESTO.<br>
                                                    2) Pagamento em Cartório, de quantia superior a R$ 300,00 só será recebida por meio de cheque administrativo.
                                                </td>
                                                <td height="22.2" colspan="2" class="ph bottom left">
                                                    <small>Nosso Número</small><br>
                                                    {{ $boleto->nosso_numero_titulo }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="45.6" colspan="2" class="center"><img src="{{ asset('admin/img/via2.png') }}" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="14.4" height="181.2"></td>
                        <td width="210" height="181.2">
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="210" class="border2">
                                <tr>
                                    <th height="26.4" colspan="3" class="bg center serif bottom"><strong class="bigger">VALORES A PAGAR</strong></th>
                                </tr>
                                <tr>
                                    <td height="28.2" colspan="3" class="bottom ph">
                                        <small>Valor do Título</small><br>
                                        <span class="fr big">R$ {{ $boleto->valor_principal_titulo }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="29.4" colspan="3" class="bottom ph">
                                        <small>Custas e Emolumentos</small><br>
                                        <span class="fr big">R$ {{ $boleto->valor_custas_emolumento }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="32.4" colspan="3" class="ph">
                                        <small>TOTAL A PAGAR</small><br>
                                        <span class="fr big"><strong>R$ {{ $boleto->valor_total_boleto }}</strong></span>
                                    </td>
                                </tr>
                            </table>
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="210">
                                <tr>
                                    <td width="210" height="1.2"></td>
                                </tr>
                            </table>
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="210" class="border2">
                                <tr>
                                    <th height="25.2" colspan="3" class="bg center serif bottom"><strong class="bigger">APONTAMENTO</strong></th>
                                </tr>
                                <tr>
                                    <td width="61.2" height="38.4" class="ph">
                                        <small>Livro</small><br>
                                        <span class="fr big">{{ $boleto->livro_apontamento }}</span>
                                    </td>
                                    <td width="62.4" height="38.4" class="left right ph">
                                        <small>Folha</small><br>
                                        <span class="fr big">{{ $boleto->folha_apontamento }}</span>
                                    </td>
                                    <td width="86.4" height="38.4" class="ph">
                                        <small>Ordem</small><br>
                                        <span class="fr big">{{ $boleto->ordem_apontamento }}</span>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="6"></td>
        </tr>
        <tr>
            <td width="666" height="36">
                <table border="0" cellpadding="0" cellspacing="0" width="666" style="border: 1px solid #666;">
                    <tr>
                        <td width="150" height="36" class="ph center bg" style="border-right: 1px solid #666;">
                            <small class="sans"><strong class="bigger">PRAZO PARA PAGAMENTO:</strong></small><br>
                            <span class="bigprazo"><strong>{{ $boleto->vencimento_boleto}}</strong></span>
                        </td>
                        <td width="516" height="36" class="bg">&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="666" height="16.2"><img width="666" src="{{ asset('admin/img/tesoura.png') }}" />
            </td>
        </tr>
        <tr>
            <td width="666" height="281.4" class="border2">

                <table border="0" cellpadding="0" cellspacing="0" width="666">
                    <tr>
                        <td height="36" colspan="3">
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="666">
                                <tr>
                                    <td width="252" height="36" class="ph bottom right"><img src="{{ asset('admin/img/logo-itau.png') }}" /></td>
                                    <td width="56.4" height="36" class="ph bottom right center"><span class="bigger serif">341-7</span></td>
                                    <td width="357.6" height="36" class="ph bottom center"><span class="serif" style="font-size:120%"><strong>{{ $boleto->linha_digitavel_boleto }}</strong></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="187.8" colspan="2">
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="466.2">
                                <tr>
                                    <td width="466.2" height="22.8" class="ph right bottom">
                                        <small>Local de pagamento</small><br>
                                        QUALQUER AGÊNCIA BANCÁRIA ATÉ O VENCIMENTO
                                    </td>
                                </tr>
                                <tr>
                                    <td width="466.2" height="21" class="ph right bottom">
                                        <small>Beneficiário/CNPJ</small><br>
                                        2 TABELIONATO DE PROTESTOS DE TÍTULOS
                                        <span class="tr fr">18.360.302/0001-38</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="466.2" height="21">
                                        <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="466.2">
                                            <tr>
                                                <td width="116" height="21" class="ph right bottom">
                                                	<small>Data do documento</small><br>
                                                	{{ $boleto->data_remessa }}
                                                </td>
                                                <td width="105" height="21" class="ph right bottom">
                                                	<small>Número do documento</small><br>
                                                	{{ $boleto->numero_titulo }}
                                                </td>
                                                <td width="80.2" height="21" class="ph right bottom">
													<small>Espécie Documento</small><br>
	                                               {{ $boleto->especie_titulo }}
                                                </td>
                                                <td width="53" height="21" class="ph right bottom">
                                                	<small>Aceite</small><br>
                                                	{{ $boleto->aceite_boleto }}
                                                </td>
                                                <td width="112" height="21" class="ph right bottom">
                                                	<small>Data Processamento</small><br>
                                                	&nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="466.2" height="20.4">
                                        <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="466.2">
                                            <tr>
                                                <td width="105.6" height="21" class="ph right bottom">
                                                	<small>Uso do banco</small><br>
                                                	&nbsp;
                                                </td>
                                                <td width="61.8" height="21" class="ph right bottom">
                                                	<small>Carteira</small><br>
                                                	{{ $boleto->carteira_boleto }}
                                                </td>
                                                <td width="92.4" height="21" class="ph right bottom">
                                                	<small>Espécie</small><br>
                                                	{{ $boleto->especie_pagamento_boleto }}
                                                </td>
                                                <td width="105.6" height="21" class="ph right bottom">
                                                	<small>Quantidade</small><br>
                                                	&nbsp;
                                                </td>
                                                <td width="100.8" height="21" class="ph right bottom">
                                                	<small>Valor</small><br>
                                                	&nbsp;
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="466.2" height="102" valign="top" class="ph pv bottom right">
                                    <small>Instruções de responsabilidade do beneficiário. Qualquer dúvida sobre este boleto, contate o beneficiário.</small>
                                    <strong>
                                    	<pre>
SR.CAIXA:
        1) NÃO RECEBER APÓS O VENCIMENTO;
        2) NÃO RECEBER VALOR A MENOR DO QUE O CONSTANTE NO BOLETO;
	3) O PAGAMENTO APÓS O VENCIMENTO NÃO EVITA O PROTESTO;
	4) ALTERAR DADOS DO BOLETO CONSTITUI CRIME (ART. 298 DO CPB)
	5) NÃO RECEBER PAGAMENTO COM CHEQUE;
                                   		</pre>
                                    </strong>
                                    </td>
                                </tr>
                            </table>


                        </td>
                        <td width="199.8" height="187.8">
                            <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="199.8">
                                <tr>
                                    <td width="199.8" height="22.8" class="bg ph bottom">
                                    	<small>Vencimento</small><br>
                                    	<span class="tr fr serif big"><strong>{{ $boleto->vencimento_boleto }}</strong></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="21" class="ph bottom">
                                    <small>Agência / Código do Beneficiário</small><br>
                                    <span class="tr fr">{{ $boleto->agencia_codigo_cedente }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="21" class="ph bottom">
                                    	<small>Nosso Número</small><br>
                                    	<span class="tr fr">{{ $boleto->nosso_numero_boleto }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="20.4" class="bg ph bottom">
                                    	<small>(=) Valor do Documento</small><br>
                                    	<span class="tr fr"><strong>R$ {{ $boleto->valor_total_boleto }}</strong></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="19.2" class="bottom ph">
                                    	<small>(-) Descontos / Abatimento</small><br>
                                        <span class="tr fr">&nbsp;</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="20.4" class="bottom ph">
                                    	<small>(-) Outras Deduções</small><br>
                                        <span class="tr fr">&nbsp;</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="19.8" class="bottom ph">
                                    	<small>(+) Mora/ Multa</small><br>
                                        <span class="tr fr">&nbsp;</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="20.4" class="ph bottom">
                                    	<small>(+) Outros Acréscimos</small><br>
										<span class="tr fr">&nbsp;</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="199.8" height="22.8" class="ph bg bottom">
                                    	<small>(=) Valor Cobrado</small><br>
                                    	<span class="tr fr"><strong>R$ {{ $boleto->valor_total_boleto }}</strong></span>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td width="289.2" height="57.6" valign="top" class="ph pv">
                        	<small>Pagador</small><br>
							<span>
								{{ $boleto->nome_sacado }} <br>
								{{ $boleto->endereco_sacado }} <br>
								<small>Sacador / Avalista:</small> {{ $boleto->nome_sacador }}
							</span>
                        </td>
                        <td width="177" valign="top" class="ph pv">
                        	<small>CNPJ / CPF</small><br>
							{{ $boleto->documento_sacado }}
                        </td>
                        <td width="199.8" height="57.6" valign="top" class="ph pv" style="position:relative;">
                        <p>2º VIA</p>
                        <small style="position:absolute; bottom:5px;">Código de Baixa</small>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td width="666" height="56.4">
                <table border="0" cellpadding="0" cellspacing="0" width="666">
                    <tr>
                        <td width="44" height="16.4" style="padding-left: 65px">
                            {{ $boleto->linha_digitavel_boleto }}
                        </td>
                    </tr>
                </table>
                <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="666">
                    <tr>
                        <td width="522" height="56.4">
                            <?php 
                               $barras = new boletosPHP();
                               $barras->setIpte($boleto->linha_digitavel_boleto);
                               $barras ->desenhaBarras();
                             ?>
                             <!-- <img src="{{ URL::asset('/').$boleto->id}}.gif " alt="barcode"> -->
                        </td>
                        <td width="144" height="56.4" valign="top"><small>Autenticação Mecânica / Ficha de Compensação</small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
