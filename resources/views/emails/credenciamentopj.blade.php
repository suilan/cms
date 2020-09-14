<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Gerenciamento Integrado de Débitos - SGID</title>
</head>

<body>
    <h2>Olá, <strong>{{ $dados["usuario"] }}</strong></h2>
    <br />
    O credencimento de Pessoal Jurídica para o documento {{ $dados["documento"] }}, foi realizado com sucesso. A partir de agora, você está apto para emitir segunda via dos boletos referente a títulos que ainda não foram protestados.
    <br /><br />
    Acesse o link abaixo para acessar a sua área restrita.
    <br />
    <a href="{{url('admin/login')}}">Acessar Área Restrita.</a>
</body>

</html>