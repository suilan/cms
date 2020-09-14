<style type="text/css">
	.bt-enviar {
	  float: left;
	  display: block;
	  height: 35px;
	  padding: 0 50px;
	  text-align: center;
	  line-height: 35px;
	  border: none;
	  -webkit-border-radius: 30px;
	  -moz-border-radius: 30px;
	  -o-border-radius: 30px;
	  border-radius: 30px;
	  text-transform: uppercase;
	  font-family: Gotham-Bold;
	  color: #fff;
	  font-size: 12px;
	  text-decoration: none;
	  cursor: pointer;
	  background: #00b4db;
	}
	#form-inscricao input, select{
	  display: block;
	  width: 100%;
	  height: 52px;
	  -moz-box-sizing: border-box;
	  -webkit-box-sizing: border-box;
	  -webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  -o-box-sizing: border-box;
	  box-sizing: border-box;
	  padding: 0 20px;
	  border: 2px solid #d2d2d2;
	  -webkit-border-radius: 6px;
	  -moz-border-radius: 6px;
	  -o-border-radius: 6px;
	  border-radius: 6px;
	  font-size: 16px;
	  font-family: Gotham-Book;
	}
	#form-inscricao label{
		display: block;
	    margin: 0 0 20px;
	    overflow: hidden;
	}
	#form-inscricao span{
		display: block;
	    margin: 0 0 0 10px;
	    font-size: 16px;
	    font-family: Gotham-Book;
	}
	/* The alert message box */
	.alert {
	    padding: 20px;
	    background-color: #00b4db;
	    color: white;
	    margin-bottom: 15px;

	}
	.alertError {
	    padding: 20px;
	    background-color: #FF0000;
	    color: white;
	    margin-bottom: 15px;

	}
	.facilidades{
		display: none;
	}
	.float{
		position:fixed;
		bottom:40px;
		right:40px;
		background-color:#005088;
		color:#FFF;
		border-radius:50px;
		text-align:center;
		box-shadow: 2px 2px 3px #999;
		padding: 30px;
		text-decoration: none;
		font-family: Gotham-Bold;
	}

	.my-float{
		margin-top:22px;
	}

	div.mensagem {
    	text-align: justify;
		line-height: 1.5;,

	}
</style>

<link rel="stylesheet" href="{{ asset('ieptbma/css/jquery.fancybox.css')}}" type="text/css" media="screen" />

@extends('ieptbma::template.main')

@section('scripts')
	<script type="text/javascript" src="{{ asset('ieptbma/js/jquery.fancybox.js')}}"></script>
@endsection

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li><a href="{{url('eventos')}}">Eventos</a></li>
        <li>{{$evento->titulo}}</li>
    </ul>
</div>

@if(isset($status) != null && $status != "")
    <div class="alert alert-success" style="background:#04B404" >
        <p><b>{{ $status }}</b></p>
		{{-- <p><b>{{ $pgStatus01 }}</b></p>
		<p><b>{{ $pgStatus02 }}</p>  --}}
    </div>
@endif
@if(isset($statusError) != null && $statusError != "")
    <div class="alertError">
      {{ $statusError }}
   </div>
@endif

<div id="g-about" class="row">
	<div class="col-md-6">
		<h2 class="titulo">{{$evento->titulo}}</h2>

		@if( $evento->imagem_arquivo != "" )
			<p><img class="foto" width="100%" src="{{asset($evento->imagem_arquivo)}}" ></p>
		@elseif ( $evento->imagem_url != "" )
			<p><img class="foto" width="100%" src="{{$evento->imagem_url}}" ></p>
		@else
			<p><img class="foto" width="100%" src="http://placehold.it/860x480" ></p>
		@endif

		@if(($evento->id == 10 ) || $evento->id == 12 || $evento->id == 13|| ($evento->id == 14 ) || $evento->id == 15 || $evento->id == 16)

			{{-- @if($evento->id == 10)
				<h2 class="titulo">Inscrições</h2>
				<a data-fancybox="gallery" style="margin" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide01.jpg')}}">Lista de Palestrantes</a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide02.jpg')}}"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide03.jpg')}}"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide04.jpg')}}"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide05.jpg')}}"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{url('images/slide06.jpg')}}"></a>
				<br /><br />
			@endif --}}

			{{-- @if($evento->id == 12)
				<h2 class="titulo" style="margin-top:50px">Palestrantes</h2>
				<p>Clique aqui para conferir os Palestrantes</p>
				<a data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img1.jpeg">Lista de Palestrantes</a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img2.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img3.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img4.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img5.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img6.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img7.jpeg"></a>
				<a style="display: none" data-fancybox="gallery" class="bt-enviar grouped_elements" rel="group1" href="{{ URL::asset('/') }}ieptbma/img/img8.jpeg"></a>
				<br /><br />
			@endif --}}

			<h2 class="titulo">SOBRE O EVENTO</h2>
			<p>{!! str_replace('<p>&nbsp;</p>','',$evento->conteudo)!!}</p><br />

			<div class="col-md-6 inscricoes">
				@if($evento->id == 12  || $evento->id == 13 )
					<div class="col-md-6 inscricoes">
						<h2 class="titulo">Inscrições</h2>
						<p style="color: #FF0000">INSCRIÇÕES ENCERRADAS!</p>
						<p style="color: #FF0000">Desejamos a todos os inscritos um excelente evento!</p>
						<p style="color: #FF0000">Muito obrigado!</p>
					</div>
				@elseif($evento->id == 12 )
					<div class="col-md-6 inscricoes">
						<h2 class="titulo">Inscrições</h2>
						<p style="color: #FF0000">INSCRIÇÕES ENCERRADAS!</p>
						<p style="color: #FF0000">Desejamos a todos os inscritos um excelente evento!</p>
						<p style="color: #FF0000">Muito obrigado!</p>
					</div>
				@endif

				{{-- <h2 class="titulo">Finalize sua inscrição</h2>
				<button style="margin-left: 10px;" id="clique_enviar_pagamento" class="bt-enviar">Enviar Pagamento</button>
				<button style="margin-left: 10px;" id="clique_enviar_estudante" class="bt-enviar">Enviar Comprovante Estudante</button>	 --}}
			</div>
			<div class="remodal" data-remodal-id="modal">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1 class="logo"></h1>

				<p class="titulo">
					<form method="post" action="{{url('eventos')}}" id="form-inscricao" class="form-horizontal" role="form" enctype="multipart/form-data">
						<input type="hidden" id="cainput_token" name="_token" value="{{ csrf_token() }}">
						<label for="nome" class="nome">
							<span class="text">Nome<strong style="color: red">*</strong>:</span>
							<input type="text" name="nome" required="true" />
							<input type="hidden" name="slug" value="{{$evento->slug}}">
						</label>
						<label for="nome" class="nome">
							<div class="inscricao_form_left" style="float: left;">
								<span class="text">CPF<strong style="color: red">*</strong>:</span>
								<input type="text" name="cpf" class ="cpf" id="cpf" required="true" style="width: 289px" />
							</div>

							<div class="inscricao_form_right" style="float: right;">
								<span class="text">RG:</span>
								<input type="text" name="rg" style="width: 289px"/>
							</div>
						</label>
						<label for="nome" class="nome">
							<span class="text">E-mail<strong style="color: red">*</strong>:</span>
							<input required="true" type="email" name="email"/>
						</label>
						<label for="nome" class="nome">
							<div class="inscricao_form_left" style="float: left;">
								<span class="text">Telefone Fixo:</span>
								<input type="text" id="telefone" name="telefone" style="width: 289px" />
							</div>
							<div class="inscricao_form_right" style="float: right;">
								<span class="text">Celular<strong style="color: red">*</strong>:</span>
								<input type="text" id="celular" name="celular" required="true" style="width: 289px"/>
							</div>
						</label>
						<label for="nome" class="nome">
							<div class="inscricao_form_left" style="float: left;">
								<span class="text">Estado<strong style="color: red">*</strong>:</span>
								<select name="estado" id="estados" style="width: 289px" required="true" class="select_estado">
									<option value="">--Selecione seu Estado--</option>
									@foreach( $estados as $k=>$r )
										<option value="{{$r->id}}">{{$r->nome}}</option>
									@endforeach
								</select>
							</div>
							<div class="inscricao_form_left" style="float: right;">
								<span class="text">Cidade<strong style="color: red">*</strong>:</span>
								<select name="cidade" id="cidades" style="width: 289px" required="true" class="select_cidade">
									<option value="">--Selecione sua cidade--</option>
									@foreach( $cidades as $k=>$r )
										<option value="{{$r->id}}" class="estado_{{$r->estado_id}}">{{$r->nome}}</option>
									@endforeach
								</select>
							</div>
						</label>
						<label for="endereco" class="nome">
							<span class="text">Empresa/Instituição:</span>
							<input type="text" name="empresa"/>
						</label>
						<label for="endereco" class="nome">
							<span class="text">Endereço<strong style="color: red">*</strong>:</span>
							<input type="text" name="endereco" required="true" />
						</label>
						<label for="nome" class="nome">
							<span class="text">Tipo da inscrição<strong style="color: red">*</strong>:</span>
						<select name="inscricao" id="divInscricao" required="true">
								<option value="">--Selecione o tipo--</option>
								<option value="1">Notário / Registrador: Gratuito</option>
								<option value="2">Funcionário de Cartório: Gratuito</option>
								<option value="3">Profissionais do Direito: Gratuito</option>
								<option value="4">Estudante: Gratuito</option>
								<option value="6">Outros: Gratuito</option>
							</select>
						</label>

						 {{-- <label for="nome" class="nome">
							<div  style="text-align: -webkit-center;" id="divComprovanteEstudante">
								<div class="mensagem" >
									<span class="text" >Após o preenchimento do formulário, será necessário o envio do comprovante de transferência bancária correspondente ao pagamento de sua inscrição. Para isso, basta clicar no botão <b>ENVIAR PAGAMENTO</b>, que está localizado na parte inferior da página do evento, basta informar seu <b>CPF</b> e anexar a imagem do <b>comprovante de transferência.</b></span></ br>
									<br />
									<span class="text" >Você Estudate deve anexar também o comprovante de estudande, que se encontra na parte inferior da página do evento.</span></ br>									
									<br />
									<span class="text" >Imediatamente após a identificação do crédito correspondente ao pagamento da inscrição, você receberá um e-mail* com a informação que "<b>sua inscrição foi confirmada com sucesso</b>". </span></ br>
									<br />
									<span class="text" ><b>*</b> Caso não encontre o e-mail de confirmação na Caixa de Entrada, favor verificar caixa de spam.</span>
								</div>
							</div>
						</label>
						<label for="nome" class="nome">
							<div  style="text-align: -webkit-center;" id="divComprovantePagamento">
								<div class="mensagem" >
									<span class="text" >Após o preenchimento do formulário, será necessário o envio do comprovante de transferência bancária correspondente ao pagamento de sua inscrição. Para isso, basta clicar no botão <b>ENVIAR PAGAMENTO</b>, que está localizado na parte inferior da página do evento, basta informar seu <b>CPF</b> e anexar a imagem do <b>comprovante de transferência.</b></span></ br>									
									<br />
									<span class="text" >Imediatamente após a identificação do crédito correspondente ao pagamento da inscrição, você receberá um e-mail* com a informação que "<b>sua inscrição foi confirmada com sucesso</b>". </span></ br>
									<br />
									<span class="text" ><b>*</b> Caso não encontre o e-mail de confirmação na Caixa de Entrada, favor verificar caixa de spam.</span>
								</div>
							</div>
						</label>  --}}

						 <label for="nome" class="nome" style="text-align: -webkit-center; margin-top: 30px">
							<button id="clique_evento" class="bt-enviar" style="float: none;background:  #3ADF00;">Inscrever</button>
						</label> 

					</form>
				</p>
			</div>

			<div class="remodal" data-remodal-id="modal2" style="text-align: -webkit-center;">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1 class="logo" style="margin: 0"></h1>
				<span style="font-size: 20px; font-family: Gotham-Book"><strong>COMPROVANTE DE PAGAMENTO</strong></span>
				<br /><br />
				<p class="titulo">
					<form action="{{url('eventos/'.$evento->slug)}}" id="form-inscricao" class="form-horizontal comprovante" role="form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="_method" value="PUT">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<label for="nome" class="nome">
							<div class="inscricao_form_left">
								<span class="text">CPF<strong style="color: red">*</strong>:</span>
								<input type="text" name="cpf" id="cpf" class="cpf" required="true" />
							</div>
						</label>
						<label for="nome" class="nome" >
							<div class="inscricao_form_left" style="text-align: -webkit-center;" >
								<span class="text">Comprovante de pagamento:</span>
								<input type="file" id="comprovante" name="comprovante"/>
							</div>
						</label>
						<label for="nome" class="nome" style="text-align: -webkit-center; margin-top: 30px">
							<button id="clique_comprovante" class="bt-enviar" style="float: none;background:  #3ADF00;">Enviar</button>
						</label>
					</form>
				</p>
			</div>


			<div class="remodal" data-remodal-id="modal3" style="text-align: -webkit-center;">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1 class="logo" style="margin: 0"></h1>
				<span style="font-size: 20px; font-family: Gotham-Book"><strong>COMPROVANTE DE ESTUDANTE</strong></span>
				<br /><br />
				<p class="titulo">
					<form action="{{url('eventos/'.$evento->slug)}}" id="form-inscricao" class="form-horizontal comprovante" role="form" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="_method" value="PUT">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<label for="nome" class="nome">
							<div class="inscricao_form_left">
								<span class="text">CPF<strong style="color: red">*</strong>:</span>
								<input type="text" name="cpf" id="cpf" class="cpf" required="true" />
							</div>
						</label>
						<label for="nome" class="nome" >
							<div class="inscricao_form_left" style="text-align: -webkit-center;" >
								<span class="text">Comprovante de estudante:</span>
								<input type="file" id="comprovante" id="comprovanteEstudante" name="comprovante_estudante"/>
							</div>
						</label>
						<label for="nome" class="nome" style="text-align: -webkit-center; margin-top: 30px">
							<button id="clique_comprovante" class="bt-enviar" style="float: none;background:  #3ADF00;">Enviar</button>
						</label>
					</form>
				</p>
			</div>

			<div class="remodal" data-remodal-id="modalPalestrantes" style="width: 1650px;height: 900px">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1 class="logo" style="margin: 0"></h1>
				<p class="titulo">
					<div class="container" style="width: 650px;height: 550px">

					</div>
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner">
							<div class="item active">
								<img src="{{url('/images/slide01.jpg')}}" style="width:100%;">
							</div>

							<div class="item">
								<img src="{{url('/images/slide02.jpg')}}"  style="width:100%;">
							</div>

							<div class="item">
								<img src="{{url('/images/slide03.jpg')}}"  style="width:100%;">
							</div>
							<div class="item">
								<img src="{{url('/images/slide04.jpg')}}"  style="width:100%;">
							</div>
							<div class="item">
								<img src="{{url('/images/slide05.jpg')}}"  style="width:100%;">
							</div>
							<div class="item">
								<img src="{{url('/images/slide06.jpg')}}"  style="width:100%;">
							</div>
							</div>

							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Anterior</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Próximo</span>
							</a>
						</div>
					</div>
				</p>
			</div>
	</div>
</div>
	@include('ieptbma::template._scripts')
	<script type="text/javascript">
	window.REMODAL_GLOBALS = {
	NAMESPACE: 'remodal',
	DEFAULTS: {
	  hashTracking: true,
	  closeOnConfirm: true,
	  closeOnCancel: true,
	  closeOnEscape: true,
	  closeOnOutsideClick: false,
	  Default: true,
	  modifier: ''
	}
	};
	</script>
	<script type="text/javascript">
	    $(document).ready(function(){

	    	$("a.grouped_elements").fancybox({
    			loop: true,
    			buttons : [
			        'slideShow',
			        'fullScreen',
			        'thumbs',
			        'download',
			        //'share',
			        'close'
			    ],
	    	});
	        $("#clique_evento").click(function(){
	            var inst = $('[data-remodal-id=modal]').remodal();
	            inst.open();
			});

			$("#btn_float_isncr").click(function(){
	            var inst = $('[data-remodal-id=modal]').remodal();
	            inst.open();
	        });

	        $("#clique_enviar_pagamento").click(function(){
	            var inst = $('[data-remodal-id=modal2]').remodal();
	            inst.open();
	        });

			$("#clique_enviar_estudante").click(function(){
	            var inst = $('[data-remodal-id=modal3]').remodal();
	            inst.open();
	        });

	        $("#modalPalestrantes").click(function(){
	            var inst = $('[data-remodal-id=modalPalestrantes]').remodal();
	            inst.open();
	        });

	        $('.comprovante').on('submit', function(e){
                e.preventDefault();

                var inst = $('[data-remodal-id=modal2]').remodal();
                inst.close();

                this.submit();
			});

			$('.select_estado').change(function(event){
				$(".select_cidade option").each(function(index,element){
					if(element.className === 'estado_'+event.target.value){
						element.style.display="block";
					}
					else{
						element.style.display = "none";
					}
				});
            });

			$('#divInscricao').change(function(event){
				var valor = $(this).val();
				// console.log(valor);
				if (valor === "3") {
					$("#divComprovanteEstudante").css('display','block');
		 			$("#divComprovantePagamento").css('display','none');
				} else {
					$("#divComprovanteEstudante").css('display','none');
		 			$("#divComprovantePagamento").css('display','block');
				}
			});

	        $(".cpf").inputmask("999.999.999-99");
	        $("#cpf_comprovante").inputmask("999.999.999-99");
	        $("#telefone").inputmask("(99) 9999-9999");
	        $("#celular").inputmask("(99) 99999-9999");
	    });

	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$("#divComprovanteEstudante").hide();
		$("#divComprovantePagamento").hide();

		// function genderSelectHandler(select){
		// 	console.log(select.value);
		// 	if(select.value === 3){
		// 		$("#divComprovanteEstudante").show();
		// 		$("#divComprovantePagamento").hide();
		// 	}else if(select.value !== 3){
		// 		$("#divComprovanteEstudante").hide();
		// 		$("#divComprovantePagamento").show();
		// 	}

		// }
	</script>
@else
	@if($evento->id == 10 || $evento->id == 13 || $evento->id == 14 || $evento->id == 15)
		<div class="col-md-6 inscricoes">
			<h2 class="titulo">Inscrições</h2>
			<p style="color: #FF0000">INSCRIÇÕES ENCERRADAS!</p>
			<p style="color: #FF0000">Desejamos a todos os inscritos um excelente evento!</p>
			<p style="color: #FF0000">Muito obrigado!</p>
		</div>
	@endif
@endif
@if($evento->id == 16)
	<a href="#" id="btn_float_isncr" style="background-color:#00b4db" class="float">
		<span>INSCREVA-SE</span>
	</a> 
@endif
@stop
