<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin </title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{asset('admin/bootstrap/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('admin/css/AdminLTE.min.css')}}">
	<!-- iCheck -->
	@if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
		<link rel="stylesheet" href="{{asset('admin/css/yellow.css')}}">
	@else
		<link rel="stylesheet" href="{{asset('admin/css/blue.css')}}">
	@endif
	<link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon.png') }}" />
	<style type="text/css">
	/*.login-box{width:auto;max-width:none;min-width: 0;}*/
	.login-page .login-logo h1,.login-page .login-logo p{ color: #FFFFFF;}
	
	@if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
		body.login-page {
			background: #b37100; /* Old browsers */
			background: -moz-radial-gradient(center, ellipse cover, #b37100 0%, #3d2702 100%); /* FF3.6-15 */
			background: -webkit-radial-gradient(center, ellipse cover, #b37100 0%,#3d2702 100%); /* Chrome10-25,Safari5.1-6 */
			background: radial-gradient(ellipse at center, #b37100 0%,#3d2702 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b37100', endColorstr='#3d2702',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		}
	@else
		body.login-page {
			background: #007dc5; /* Old browsers */
			background: -moz-radial-gradient(center, ellipse cover, #007dc5 0%, #005088 100%); /* FF3.6-15 */
			background: -webkit-radial-gradient(center, ellipse cover, #007dc5 0%,#005088 100%); /* Chrome10-25,Safari5.1-6 */
			background: radial-gradient(ellipse at center, #007dc5 0%,#005088 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#007dc5', endColorstr='#005088',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		}
	@endif
	</style>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition login-page">
	<div class="row">
		<div class="col-md-8 col-xs-12" class="tela-login">
			<div class="login-logo">
				<a href="{{url('')}}" >	
					@if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
						<img src="{{asset('segundotabelionato/img/logo.png')}}" width="400px">
					@else
						<img src="{{asset('admin/img/logo-footer.png')}}" width="400px">
					@endif
				</a>
				<h1>Bem-vindo ao PCD - Plataforma de Cartórios Digitais</h1>
				<p>A Plataforma de Cartórios Digitais, oferece a você cartorário, um ambiente para disponibilizar Notícias, Itens para Download, Formulário de contato, Redes Sociais, Eventos, Sobre o Cartório, Localizaçaão Geográfica e um painel para consulta de editais de protesto para a sociedade</p>
			</div>
		</div>
		<div class="login-box col-md-4 col-xs-12">
			<div class="login-box-body">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Opa!</strong> Ocorreram alguns problemas ao tentar validar o usuário.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
				@if (session('warning'))
					<div class="alert alert-warning">
						{{ session('warning') }}
					</div>
				@endif
				<h4 class="login-box-msg">Faça o Login na sua conta</h4>

				<form action="{{ url('admin/login') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="CPF ou E-mail" name="email" id="email" value="{{ old('email') }}">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="Password" name="password" id="password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="checkbox icheck">
								<label>
									<div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
										<input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
										<ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
									</div> Lembrar de mim
								</label>
							</div>
						</div>
						<!-- /.col -->
					    <div class="col-xs-6 esqueceu_senha">
					      <a href="{{url('admin/senha')}}">Esqueceu a senha?</a>
					    </div>
					<!-- /.col -->
					</div>
					<div class="row">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat btn-logar">Logar</button>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-sm-12 possui-conta">
							<span class="text ng-scope">Não possui uma conta?</span>
							<a class="link ng-scope md-default-theme" href="#">Crie uma conta</a>
						</div>
					</div> -->
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->
	</div>

	<!-- jQuery 2.2.0 -->
	<script src="{{ asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="{{url('admin/bootstrap/js/bootstrap.min.js')}}"></script>
	<!-- iCheck -->
	<script src="{{ asset('admin/plugins/iCheck/icheck.min.js') }}"></script>
	<script>
	  $(function () {
	    $('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%' // optional
	    });
	  });
	</script>
</body>
</html>
