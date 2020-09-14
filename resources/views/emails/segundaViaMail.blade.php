<!DOCTYPE html>
<html>

<head>
    <title>Intimação Eletrônica de Protesto - 2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos de São Luís</title>
</head>

<style>
    * {
        background:transparent !important;
        color:#000 !important;
        text-shadow:none !important;
        filter:none !important;
        -ms-filter:none !important;
        font-family: Arial, Helvetica, sans-serif;
    }
    body {
        line-height: 1.4em;
        font-family: Arial, Helvetica, sans-serif;
    }
    .espaco{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    @font-face {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>
    <h2 style="text-align: center; text-decoration: underline;">INTIMAÇÃO ELETRÔNICA DE PROTESTO</h2>
    <br />
    <h2><span style="font-weight: normal;">ATT.: </span> <strong>{{ strtoupper($dados->nome_sacado) }}</strong></h2>
    <br />
    <p>
        Informamos a existência de <strong>INTIMAÇÃO(ÕES) DE PROTESTO</strong> a vencer neste <strong>2º TABELIONATO DE PROTESTO DE SÃO LUÍS</strong>, referente ao documento do SACADO/DEVEDOR (CPF/CNPJ) sob número <strong>{{ $dados->documento_sacado }}</strong>, conforme disposto no art. 3º , § 4 do Provimento CNJ 87 c/c art. 1º do Provimento 97 do CNJ c/c art. 14, § 1º e 2º, da Lei n. 9.492/1997 
    </p>
    <br />
    <p>
        <strong>SACADOR:</strong> {{ strtoupper($dados->nome_sacador) }}
        <br />
        <strong>DEVEDOR:</strong> {{ strtoupper($dados->nome_sacado) }}
        <br />
        <strong>CPF/CNPJ:</strong>  {{ strtoupper($dados->documento_sacado) }}
        <br />
        <strong>PROTOCOLO:</strong>  {{ strtoupper($dados->protocolo) }}
        <br />
        <strong>ESPÉCIE/NÚMERO DO TÍTULO:</strong>  {{ strtoupper($dados->especie_titulo) }} / {{ strtoupper($dados->numero_titulo) }}
        <br />
        <strong>DT. VENCIMENTO:</strong>  {{ DateTime::createFromFormat('dmY',$dados->vencimento_boleto)->format('d/m/Y') }}
        <br />
        <strong>SALDO:</strong> {{ "R$ ".$dados->valor_total_boleto }}
    </p>
    <br />
    <p>
        Para ter acesso à íntegra desta <strong>Intimação Eletrônica de Protesto</strong> e ao respectivo boleto para pagamento deste título antes do protesto, acesse a área restrita, através do site do 2º Tabelionato de Protesto de São Luís, que estarão disponíveis <strong>até a data do vencimento da intimação</strong>.
    </p>
    <br />
    <p>
        ACESSE SUA CONTA ou CADASTRE-SE através do site: <a style="font-size: 25px;" href="https://2protestoslz.com.br/intimacao">https://2protestoslz.com.br/intimacao</a>
    </p>
    <br />
    <p>
        <strong><h3 style="margin-bottom: 0;">2º TABELIONATO DE PROTESTO DE SÃO LUÍS | CNPJ: 18.360.302/0001-36</h3></strong>
        <div class="espaco">
            <strong>ENDEREÇO: </strong> Av. dos Holandeses, 01, Qd 36, Shopping Automóveis, Loja 19, Bairro: Calhau, São Luis/MA, CEP: 65.071-380
        </div>
        <div class="espaco">
            <strong>TELEFONE: </strong> (98) 3303-6413
        </div>
        <div class="espaco">
            <strong>WHATSAPP:</strong> (98) 3303-6415
        </div>
        <br />
        <div class="espaco">
            <strong>SITE: </strong> https://2protestoslz.com.br
        </div>
        <strong>E-MAIL: </strong> <a href = "mailto: intimacao@2protestoslz.com.br">intimacao@2protestoslz.com.br</a>
    </p>
</body>

</html>