@extends('admin.template.main')
@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
				<h2 class="titulo" style="margin-top: 0;">Formulário para associação ao IEPTB-MA</h2>
			</div>

			@if(substr_count(Request::url(), 'edit'))
		    <form action="{{url('admin/cartorios/'.$cartorio->id)}}"  method="post" id="formCartorio">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="put">
			@else
		    <form action="{{url('admin/cartorios')}}"  method="post" id="formCartorio">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				@endif
				<div class="box-body">
            		@include('admin.template.alerts')

					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" >Informações</a></li>
							<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tabelião</a></li>
							<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Substituto</a></li>
							<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Responsável</a></li>
							<li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Contato</a></li>
							<li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Atribuições</a></li>
							<li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false">Info. Adicionais</a></li>
							<li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false">Dados Bancários</a></li>
						</ul>
						<div class="tab-content" style="padding-left:30px;">
							<div class="tab-pane active" id="tab_1" >
								@include('admin.cartorios.criar-info')
							</div>
							<div class="tab-pane" id="tab_2">
								@include('admin.cartorios.criar-tabeliao')
							</div>
							<div class="tab-pane" id="tab_3">
								@include('admin.cartorios.criar-substituto')
							</div>
							<div class="tab-pane" id="tab_4">
								@include('admin.cartorios.criar-responsavel')
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_5">
								@include('admin.cartorios.criar-contatos')
							</div>
							<div class="tab-pane" id="tab_6">
								<div class="row">
									<div class="col-xs-12">
										<div style="margin-left:14px;" class="checkbox">
											<label>
												@if( $oficiounico )
												<input  type="checkbox" name="" id="MarcarTodos" checked>
												@else
												<input  type="checkbox" name="" id="MarcarTodos" >
												@endif
												Ofício único (Todas as opções abaixo)
											</label>
										</div>
										<div class="clear-fix" style="border-bottom:1px solid #D2DED6;"></div>
										@foreach($tipoAtribuicoes as $key => $value)
										<div style="margin-left:14px;" class="checkbox">
											<label>
												<input type="checkbox" name="atribuicoes[{{$value->id}}]" value="{{$value->id}}" class="marcar" {{$value->marcado?'checked':''}} >
												{{$value->nome}}
												<br />
											</label>
										</div>
										@endforeach
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<a href="#" class="btn btn-voltar">Voltar</a>
										<button type="button" class="btn btn-primary pull-right btn-form-atribuicoes">Continuar</button>
									</div>
								</div>
							</div>
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_7">
								@include('admin.cartorios.criar-adicionais')
							</div>
							<div class="tab-pane" id="tab_8">
								@include('admin.cartorios.criar-bancarios')
								<div class="row">
									<div class="col-xs-12">
										<a href="#" class="btn btn-voltar">Voltar</a>

										@if(Request::segment(4)!='edit')
										<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Salvar</button>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					@if(Request::segment(4)=='edit')
					<div class="pull-right button-salvar">
						<button type="submit" class="btn btn-primary "><i class="fa fa-floppy-o"></i> Salvar</button>
					</div>
					@endif
					<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$(".telefone").inputmask("(99) 9999-9999");
	$(".celular").inputmask("(99) 99999-9999");
});

$(document).on('click', '.changeType' ,function(){
	$(this).closest('.contact-input').find('.type-text').text($(this).text());
	$(this).closest('.contact-input').find('.type-input').val($(this).data('type-value'));

	if( $(this).data('type-value')==3 ){
		$(".contact-input input.form-control").inputmask("remove");
	}
	else{
		$(".contact-input input.form-control").inputmask({ mask:"(99) 99999-9999"});
	}

});

$(document).on('click', '.btn-remove-contact' ,function(){
	$(this).closest('.contact-input').remove();
	$('#btn-add-contact').show();
});

$('.contact-list').on('blur','input.form-control',function() {
	console.log('blur')
	var inputType = $(this).siblings('.type-input').val();
	// console.log(this.value)
	// console.log(inputType)
	if( this.value.indexOf('_')>-1 && inputType!=3 ){
		$(this).inputmask("(99) 9999-9999");
	}
});

$('#btn-add-contact').click(function(event){

	var $contatos = $('.contact-input'),
	$inputText = $('.contact-input:first input.form-control'),
	$inputType = $('.contact-input:first input.type-input'),
	re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
	index = $contatos.length + 4;// 4 - Email, Tel 1, Tel 2, Celular

	// Checa se o proximo a ser incluido é o último
	if (index == 8){
		$('#btn-add-contact').hide();
	}

	if( $inputText.val()==''){
		$inputText.focus();
		return false;
	}

	if($inputType.val()=='' ){
		$inputType.focus();
		return false;
	}
	if( $inputType.val()==3 && !re.test($inputText.val()) ){
		$inputText.focus();
		return false;
	}

	$('.contact-list').prepend(''+
	'<div style="margin-bottom:8px;" class="input-group contact-input">'+
	'<span class="input-group-btn">'+
	'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="type-text">Tipo</span> <span class="caret"></span></button>'+
	'<ul class="dropdown-menu" role="menu">'+
	<?php foreach ($tipoContatos as $key => $value): ?>
	'<li><a class="changeType" href="javascript:;" data-type-value="{{$value->id}}">{{$value->nome}}</a></li>'+
	<?php endforeach?>
	'</ul>'+
	'</span>'+
	'<input type="text" name="contact['+index+'][number]" class="form-control"/>'+
	'<input type="hidden" name="contact['+index+'][type]" class="type-input" value="" />'+
	'</div>'
);
$(".contact-input:first input.form-control").inputmask("(99) 99999-9999");

$contatos.first().append('<span class="input-group-btn">'+
'<button class="btn btn-danger btn-remove-contact" type="button"><span class="glyphicon glyphicon-remove"></span></button>'+
'</span>');

});
</script>

<script type="text/javascript">
$("#optSim").click(function() {
	$("#fornecedor:hidden").show('slow');
});
$("#optNao").click(function(){
	$('#fornecedor').hide('slow');
});

$("#responsavelRG").keydown(function (e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	// Allow: Ctrl+A
	(e.keyCode == 65 && e.ctrlKey === true) ||
	// Allow: Ctrl+C
	(e.keyCode == 67 && e.ctrlKey === true) ||
	// Allow: Ctrl+X
	(e.keyCode == 88 && e.ctrlKey === true) ||
	// Allow: home, end, left, right
	(e.keyCode >= 35 && e.keyCode <= 39)) {
		// let it happen, don't do anything
		return;
	}
	// Ensure that it is a number and stop the keypress
	if ((!e.shiftKey && (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});

</script>

<script type="text/javascript">
$(document).on('click', '.ident' ,function(event){
	event.preventDefault();
	$(this).closest('.ident-input').find('.type-text-ident').text($(this).text());
	$(this).closest('.ident-input').find('.type-input').val($(this).data('type-value'));

	if ($(".type-text-ident").text().trim() == 'CPF'){
		$("#identificacao").inputmask("999.999.999-99");
	} else{
		$("#identificacao").inputmask("99.999.999/9999-99");
	}
});

// Form Contatos
$(".contact-input").each( function(){
	var inputType = $(this).find('.type-input').val(),
	inputValue = $(this).find('input.form-control');

	switch (parseInt(inputType)) {
		case 1: // telefone
			inputValue.inputmask("(99) 9999-9999");
		break;
		case 2: // celular
			inputValue.inputmask("(99) 99999-9999");
		break;
		case 4: // comercial
			inputValue.inputmask("(99) 99999-9999");
		break;
		case 5: // recado
			inputValue.inputmask("(99) 99999-9999");
		break;
	}
});
</script>
<script type="text/javascript" src="{{asset('admin/js/cartorio-validacao.js')}}"></script>
<script type="text/javascript">
//Quando o campo cep perde o foco.
$("#responsavelCEP").blur(function() {

	//Nova variável "cep" somente com dígitos.
	var cep = $(this).val().replace(/\D/g, '');

	//Verifica se campo cep possui valor informado.
	if (cep != "") {

		//Expressão regular para validar o CEP.
		var validacep = /^[0-9]{8}$/;

		//Valida o formato do CEP.
		if(validacep.test(cep)) {

			//Preenche os campos com "..." enquanto consulta webservice.
			$("#responsavelEndereco").val("...")
			$("#responsavelBairro").val("...")
			$("#responsavelCidade").val("...")

			//Consulta o webservice viacep.com.br/
			$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

				if (!("erro" in dados)) {
					//Atualiza os campos com os valores da consulta.
					$("#responsavelEndereco").val(dados.logradouro);
					$("#responsavelBairro").val(dados.bairro);
					$("#responsavelCidade").val(dados.localidade);
					$("#responsavelCidadeIBGE").val(dados.ibge);
				} //end if.
				else {
					//CEP pesquisado não foi encontrado.
					limpa_formulário_cep();
					alert("CEP não encontrado.");
				}
			});
		} //end if.
		else {
			//cep é inválido.
			limpa_formulário_cep();
			alert("Formato de CEP inválido.");
		}
	} //end if.
	else {
		//cep sem valor, limpa formulário.
		limpa_formulário_cep();
	}
});

// Marcação das atribuições
function marcardesmarcar(bool){
	$('.marcar').each(function(){
			$(this).prop("checked", bool);
	});

	bool = bool?"block":"none";
	$('.atrib-info').each(function() {
		this.style.display=bool;
	});

}

// marcar todos
$("#MarcarTodos").click(function(){
	if ($(this).prop( "checked")){
		marcardesmarcar(true);
	}else{
		marcardesmarcar(false);
	}
});

$('.marcar').click(function(){
	if($('#MarcarTodos').prop("checked")){
		$("#MarcarTodos").prop("checked",false);
	}

	// Show or hide attributes in tab_7 - info adicionais
	if( this.checked ){
		$('.atrib-info')[this.value-1].style.display = "block";
		// console.log($('.atrib-info')[this.value-1]);
	}
	else{
		// $('.atrib-info')[this.value-1].hide();
		$('.atrib-info')[this.value-1].style.display = "none";
	}
});

</script>
@endsection
