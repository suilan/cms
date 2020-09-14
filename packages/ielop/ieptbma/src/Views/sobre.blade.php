@extends('ieptbma::template.main')

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>Sobre</li>
    </ul>
</div>
<h2 class="titulo">Conheça a IEPTB-MA</h2>
<div id="g-about" class="row">
	<div class="col-md-6">
		<h3 class="page-module-title">História</h3>
		<br>
		<p align="justify">Fundado em 12 de maio de 2004, o Instituto de Estudos de Protesto de Títulos do Brasil - Seção Maranhão (IEPTB/MA), é uma entidade civil sem fins lucrativos de âmbito Estadual e prazo indeterminado. Sediada no Município de São Luís/MA, o IEPTB oferece suporte às serventias da especialidade protesto e aos seus usuários, parceiros e associados.</p>
		<p align="justify">O IEPTB/MA tem como finalidade congregar os tabeliães de protesto e seus substitutos, promovendo a defesa e a união da classe, bem como estudar e pesquisar os procedimentos e normas jurídicas referentes ao protesto de títulos de créditos e outros documentos de dívidas. Com isso, o Instituto pretende fomentar, estimular e aperfeiçoar a utilização do PROTESTO EXTRAJUDICIAL como ferramenta eficaz na recuperação de créditos para seus usuários, transformando-se em uma referência incontestável no combate à inadimplência em todo o Estado do Maranhão.</p>
		<p align="justify">Dessa forma, o IEPTB/MA tem como objetivo principal oferecer mecanismos de proteção ao mercado para combater os elevados índices de inadimplência existentes, colocando à disposição das empresas, entidades públicas e pessoas físicas, os serviços dos Cartórios de Protesto do Estado do Maranhão de forma clara, simples e eficaz. Com o Provimento da Corregedoria Geral de Justiça do Maranhão n.º 026/2014 de 18/12/2014, publicado em 22/12/2014, que regulamenta a Central de Serviços Eletrônicos Compartilhados dos Tabeliães de Protesto de Título do Estado do Maranhão, o IEPTB/MA tem pretensão de coligar todos os Cartórios de Protesto do Estado do Maranhão ainda em 2015, permitindo assim a apresentação eletrônica de 100% dos títulos para protesto no Estado do Maranhão.</p>
		<p align="justify">Por esses motivos, o IEPTB-MA busca a cada dia uma melhoria contínua dos Serviços de Protesto no Estado do Maranhão. Focando em um atendimento eficiente e eficaz aos usuários, em busca de uma nova concepção de Serviços de Cartórios de Protesto, que influi em agilidade e qualidade no atendimento e, acima de tudo, respeito aos seus usuários.</p>
	</div>
	<div class="col-md-6">
		<h2 class="titulo">Diretoria</h2>
		<div class="yt-tabs" >
			<ul class="nav-tabs">
				<li><a href="#Executiva" class="active" onclick="showTabContent(event);">Diretoria Executiva</a></li>
				<!-- <li><a href="#Deliberativo" class="" onclick="showTabContent(event);">Deliberativo</a></li> -->
				<li><a href="#Fiscal" class="" onclick="showTabContent(event);">Conselho Fiscal</a></li>
				<li><a href="#Suplentes" class="" onclick="showTabContent(event);">Suplentes</a></li>
			</ul>
			<div class="tab-content">
				<div id="Executiva" class="active">
					<p><strong>PRESIDENTE: </strong>PAULO DE TARSO GUEDES CARVALHO - Tabelião do 2º Tabelionato de Protesto de São Luís/MA, com endereço profissional na Av. dos Holandeses, 01, Qd. 36, Shop. Automóveis, Bairro: Calhau, CEP: 65.071-380 - São Luís/MA;</p>
					<p><strong>VICE-PRESIDENTE: </strong>JOSÉ FECURY NETO, Substituto no 1º Tabelionato de Protesto de São Luís/MA, com endereço profissional na Rua do Passeio, 175, Bairro: Centro, CEP: 65.015-370 – São Luís/MA;</p>
					<p><strong>SECRETÁRIO GERAL:</strong> CHRISTIAN DINIZ CARVALHO - Substituto do 2º Tabelionato de Protesto de São Luís/MA, com endereço profissional na Av. dos Holandeses, 01, Qd. 36, Shop. Automóveis, Bairro: Calhau, CEP: 65.071-380 - São Luís/MA;</p>
					<p><strong>1º SECRETÁRIO: </strong>THIAGO AIRES ESTRELA - Tabelião da Serventia Extrajudicial do Ofício Único de Alto Alegre do Pindaré/MA, com endereço profissional na Rua São Vicente, Bairro: Centro, CEP: 65.398-000 - Alto Alegre do Pindaré/MA;</p>
					<p><strong>2º SECRETÁRIO: </strong>FELIPE MADRUGA TRUCCOLO, Tabelião e Registrador no 1º Ofício Extrajudicial de Paço do Lumiar/MA, com endereço profissional na Av. 13, 03, Quadra 158, Bairro: Maiobão, CEP: 65.137-000 – Paço do Lumiar/MA;</p>
					<p><strong>1º TESOUREIRO: </strong>FABIO SALOMÃO LEMOS - Tabelião e Registrador do 1º Ofício Extrajudicial de Barra do Corda/MA, com endereço profissional na Rua Irmã Helena, Bairro: Centro, CEP: 65.950-000 - Barra do Corda/MA;</p>
					<p><strong>2º TESOUREIRO: </strong>NADJA KARINA BUNA ASSUNÇÃO E SILVA, Tabeliã e Registradora no 3º Ofício Extrajudicial de Itapecuru-Mirim/MA, com endereço profissional na Rua Coelho Neto, nº 600, Bairro: Centro, CEP: 65.485-000 – Itapecuru-Mirim /MA;</p>
				</div>
				<!-- <div id="Deliberativo" class="">
					<p><strong>JOSÉ FECURY NETO</strong>, Substituto no 1º Tabelionato de Protesto de São Luís/MA, com endereço profissional na Rua do Passeio, 175, Bairro: Centro, CEP: 65.015-370 – São Luís/MA;</p>
					<p><strong>FABRÍCIO PETINELLI VIEIRA COUTINHO</strong>, Tabelião e Registrador do 3º Ofício Extrajudicial de Santa Inês/MA, com endereço profissional na Rua Nova, 226, Bairro: Centro, CEP: 65.300-000 – Santa Inês/MA;</p>
					<p><strong>PAULO MÁRCIO GUERRA BACELETE</strong>, Tabelião e Registrador na Serventia Extrajudicial do Ofício Único de Alcântara/MA, com endereço profissional na Rua do Sossego Alcântara, Bairro: Centro, CEP: 65.250-300 – Alcântara/MA;</p>
					<p><strong>DIOVANI ALENCAR SANTA BARBARA</strong>, Tabelião e Registrador na Serventia Extrajudicial do Ofício Único de São João dos Patos/MA, com endereço profissional no Parque Bandeira, S/N, Bairro: Centro, CEP: 65.665-000 – São João dos Patos/MA;</p>
					<p><strong>FELIPE MADRUGA TRUCCOLO</strong>, Tabelião e Registrador no 1º Ofício Extrajudicial de Paço do Lumiar/MA, com endereço profissional na Av. 13, 03, Quadra 158, Bairro: Maiobão, CEP: 65.137-000 – Paço do Lumiar/MA;</p>
					<p><strong>SILVIA HELENA SCHIMIDT</strong>, Tabeliã e Registradora na Serventia Extrajudicial do Ofício Único de Peritoró/MA, com endereço profissional na Rua do Meio, 46, Bairro: Centro, CEP: 65.418-000 – Peritoró/MA;</p>
					<p><strong>NADJA KARINA BUNA ASSUNÇÃO E SILVA</strong>, Tabeliã e Registradora no 3º Ofício Extrajudicial de Itapecuru-Mirim/MA, com endereço profissional na Rua Basílio Simão, 519, Bairro: Centro, CEP: 65.485-000 – Itapecuru-Mirim /MA;</p>
					<p></p>
				</div> -->
				<div id="Suplentes" class="">
					<p><strong>PRIMEIRO SUPLENTE</strong>: DIOVANI ALENCAR SANTA BARBARA, Tabelião e Registrador na Serventia Extrajudicial do Ofício Único de São João dos Patos/MA, com endereço profissional no Parque Bandeira, S/N, Bairro: Centro, CEP: 65.665-000 – São João dos Patos/MA;</p>
					<p><strong>SEGUNDA SUPLENTE</strong>: GRACIANA FERNANDES GOMES SOARES, Tabeliã e Registradora na Serventia Extrajudicial do 1º Ofício de Santa Luzia do Paruá/MA, com endereço profissional na Av. Prof. João Moraes de Sousa, 879, Bairro: Centro, CEP: 65.265-000 - Santa Luzia do Paruá/MA;</p>
					<p><strong>TERCEIRO SUPLENTE</strong>: PEDRO MARCELO SOUSA BALDEZ, Tabelião e Registrador na Serventia Extrajudicial do Ofício Único de Buriti/MA, com endereço profissional na Rua da Bandeira, s/n, Posto Elizabeth, Salas 03-05, CEP: 65515-000 - Buriti/MA;</p>
					<p><strong>QUARTO SUPLENTE:</strong> HAROLDO CORREA CAVALCANTI NETO, Tabelião e Registrador na Serventia Extrajudicial do Ofício Único de Araioses/MA, com endereço profissional na Av. Dr. Paulo Ramos, 211, Bairro: Conceição, Cep: 65570-000 - Araioses/MA;</p>
					<p><strong>QUINTO SUPLENTE:</strong> SILVIA HELENA SCHIMIDT, Tabeliã e Registradora na Serventia Extrajudicial do Ofício Único de Peritoró/MA, com endereço profissional na Rua do Meio, 46, Bairro: Centro, CEP: 65.418-000 – Peritoró/MA;</p>
					<p><strong>SEXTA SUPLENTE</strong>: MARIA ESTER RODRIGUES SAMPAIO, Tabeliã e Registradora no 1º Ofício Extrajudicial de Açailândia/MA, com endereço profissional na Rua Bom Jesus, 236 Açailândia Centro, Bairro: Centro, CEP: 65930-000– Açailândia/MA;</p>
					<p><strong>SÉTIMA SUPLENTE</strong>: GABRIELLA DIAS CAMINHA DE ANDRADE, Tabeliã e Registrador da Serventia Extrajudicial do Ofício Único de Igarapé Grande/MA, com endereço profissional na Av. João Carvalho, S/Nº Bairro: Centro, CEP: 65.720-000 –  Igarapé Grande/MA;</p>
					<p><strong>OITAVO SUPLENTE</strong>: GUSTAVO ANÍBAL MACEDO COELHO - Tabelião e Registrador da Serventia Extrajudicial do Ofício Único de Raposa/MA, com endereço profissional na Estrada da Raposa, Conj. Don Alonso, Qd 03, Sala: 01, Bairro: Pirâmide, CEP: 65138-000 - Raposa/MA;</p>
				</div>
				<div id="Fiscal" class="">
					<p><strong>PEDRO RENE TORRES LEITE</strong> - Tabelião e Registrador na Serventia Extrajudicial do 1º Ofício de São Bento/MA, com endereço profissional na Rua Governador Neuwton Belo, 107, Centro, CEP: 65235-000 - São Bento/MA;</p>
					<p><strong>MIRELLA BRITO ROSA</strong> - Tabeliã e Registradora na Serventia Extrajudicial do Ofício Único de Humberto de Campos/MA, com endereço profissional na Rua Newton Bello, 77, Bairro: Centro, CEP: 65.265-000 - Humberto de Campos/MA;</p>
					<p><strong>NATHÁLIA LARISSA LEITE DE MELO</strong> - Tabeliã e Registradora na Serventia Extrajudicial do Ofício Único de Palmeirândia/MA, com endereço profissional na Av. Marechal Eurico Gaspar Dutra, Bairro: Centro, CEP: 65238-000 - Palmeirândia/MA.</p>
				</div>
			</div>
			<script>
				var lastActiveContent=document.getElementsByClassName('nav-tabs')[0].children[0].children[0],
				lastActiveLink=document.getElementById('Executiva');

				function showTabContent(event) {
					event.preventDefault();
					if(event.target.className.indexOf('active')==-1){
						if(lastActiveLink){
							lastActiveLink.classList.remove('active');
							lastActiveContent.classList.remove('active');
						}
						lastActiveLink = event.target;
						lastActiveLink.className = lastActiveLink.className+ " active";
						lastActiveContent = document.getElementById(event.target.getAttribute('href').replace('#',''));
						lastActiveContent.classList.add('active');
					}
				}
			</script>
		</div>
	</div>
</div>
@stop