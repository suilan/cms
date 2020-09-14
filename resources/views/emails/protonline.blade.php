<!DOCTYPE html>
<html>

<head>
    <title>Protesto Online - Contato</title>
</head>

<body>
    <h2>Protesto Online.</h2>
    <br />
    Abaixo segue um novo contato registrado no módulo de Proteste Online.
    <br /><br />
    <ul>
        <li><strong>Razão: </strong> {{ $dados->razao }}</li>
        <li><strong>CNPJ: </strong> {{ $dados->cnpj }}</li>
        <li><strong>Nome do Responsável: </strong> {{ $dados->nome }}</li>
        <li><strong>E-mail: </strong> {{ $dados->email }}</li>
        <li><strong>Telefone: </strong> {{ $dados->contato }}</li>
        <li><strong>WhatsApp: </strong> {{ $dados->whatsapp }}</li>
        <li><strong>Celular: </strong> {{ $dados->celular }}</li>
        <li><strong>Segmento: </strong> {{ $dados->segmento }}</li>
        <li><strong>Tipos de Protesto: </strong> {{ $dados->tipo_protesto }}</li>
        <li><strong>Quantidade de Títulos: </strong> {{ $dados->qtd_titulos }}</li>
        <li><strong>Mensagem: </strong> {{ $dados->mensagem }}</li>
    </ul>
</body>

</html>