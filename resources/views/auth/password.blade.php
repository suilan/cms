
<!DOCTYPE html>
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
	<link rel="stylesheet" href="{{asset('admin/css/blue.css')}}">
	<link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon.png') }}" />
	<style type="text/css">
	.lockscreen-image{	width: 70px; height: 70px; padding:15px;}
	.lockscreen-image img{	width: 40px; height: 40px; border-radius: 0; }
	.lockscreen-credentials input{ margin:0; }

	.lockscreen h1,.lockscreen a,.help-block,.lockscreen-footer,.lockscreen .lockscreen-name{ color: #FFFFFF; font-weight: normal;}
	body.lockscreen {
		background: #007dc5; /* Old browsers */
		background: -moz-radial-gradient(center, ellipse cover, #007dc5 0%, #005088 100%); /* FF3.6-15 */
		background: -webkit-radial-gradient(center, ellipse cover, #007dc5 0%,#005088 100%); /* Chrome10-25,Safari5.1-6 */
		background: radial-gradient(ellipse at center, #007dc5 0%,#005088 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#007dc5', endColorstr='#005088',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

	}
	</style>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="http://ieptbma.com.br"><img src="{{asset('admin/img/logo-footer.png')}}" width="300px;"></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Digite seu e-mail:</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="{{asset('admin/img/favicon.png')}}" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
		<form method="post" action="{{ url('admin/recoverypassword') }}" class="lockscreen-credentials">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
      <div class="input-group">
        <input type="email" class="form-control" name="email" placeholder="E-mail">

        <div class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
  </div>
  <div class="text-center">
    <a href="{{url('admin/login')}}">Ou faça login com outro usuário</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2016 <b><a href="https://adminlte.io" class="">IEPTB-MA</a></b><br>
    Desenvolvido pela <a href="ielop.com">ielop</a>.
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3.1.1 -->
<script src="../../plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
