<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Gerenciamento Integrado de Débitos - SGID</title>
</head>

<body>
    <h2>Olá, <strong>{{ $user['name'] }}</strong></h2>
    <br />
    Segue abaixo o Token que de ser inserido no sistema para que a recuperação de senha seja efetivada com sucesso.
    <br /> <br />
    {{ $user['remember_token'] }}
    <br /><br />
    Acesse o sistema para recuperar a senha: <a href="{{ url('admin/recuperasenha') }}">Acesse o Sistema</a>
</body>

</html>