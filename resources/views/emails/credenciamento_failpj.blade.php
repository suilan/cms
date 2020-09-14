<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Gerenciamento Integrado de Débitos - SGID</title>
</head>

<body>
    <h2>Olá, <strong>{{ $dados["usuario"] }}</strong></h2>
    <br />
    Infelizmente o credencimento para o documento {{ $dados["documento"] }}, foi recusado. Segue abaixo o motivo da recusa:
    <br /> <br />
        {{ $dados["motivo"] }}
    <br /> <br />
    Acesse o link abaixo para acessar a sua área restrita.
    <br />
    <a href="{{url('admin/login')}}">Acessar Área Restrita.</a>
</body>

</html>