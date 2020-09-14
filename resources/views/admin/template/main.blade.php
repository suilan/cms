<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
@include('admin.template.head')

@if (substr_count(Request::url(), 'ieptbma') > 0)
    <body class="skin-blue">
@else
    <body class="skin-yellow">
@endif

<div class="wrapper">

    <!-- Header -->
    @include('admin.template.header')

    <!-- Sidebar -->
    @include('admin.template.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="display:initial;">
                <a class="btn btn-default" href="{{url(Request::segment(1).'/'.Request::segment(2))}}" title="Listagem de {{$page_title}}"><i class="fa fa-th-list"></i></a>&nbsp;{{ $page_title or "" }}
                <small>{{ $page_description or null }}</small>
                
<!--                 @if( Request::segment(2)=="remessas")
                <a href="{{url('admin/titulos/create')}}" class="btn btn-primary pull-right">Nova Remessa</a>
                @endif -->
            </h1>

            @if(substr_count(Request::url(), 'admin/eventos')>0 || substr_count(Request::url(), 'admin/cartorios')>0 || substr_count(Request::url(), 'admin/noticias')>0 || substr_count(Request::url(), 'admin/carousel')>0 || substr_count(Request::url(), 'admin/downloads')>0 || substr_count(Request::url(), 'admin/segundavia')>0 || substr_count(Request::url(), 'admin/usuarios')>0 || substr_count(Request::url(), 'admin/representante')>0 || substr_count(Request::url(), 'admin/credenciamentorepresentante')>0 || substr_count(Request::url(), 'admin/credenciamentoboleto')>0)
              <form  style="display:initial;" action="{{url('admin/'.Request::segment(2).'')}}">
              <div class="col-sm-6 input-group input-group-sm pull-right">
                    @if(substr_count(Request::url(), 'admin/eventosinscritos') > 0)
                        <select style="width: 30%; margin-right: 10px" class="form-control" name="inscricao" id="divInscricao">
                            <option value="0">--Tipo de inscrição--</option>
                            <option value="1">Não associados: <strong>R$ 100,00</strong></option>
                            <option value="2">Cartórios: <strong>R$ 75,00</strong></option>
                            <option value="3">Estudantes: <strong>R$ 50,00</strong></option>
                            <option value="5">Cortesia: R$ 0,00</option>
                        </select>

                        <select style="width: 30%; margin-right: 10px" class="form-control" name="status" id="divInscricao">
                            <option value="0">--Status--</option>
                            <option value="1">Inscrição Confirmada</option>
                            <option value="2">Comprovante enviado</option>
                            <option value="3">Aguardando Comprovante</option>
                        </select>
                    @endif
                    <input 
                    
                    @if(substr_count(Request::url(), 'admin/eventosinscritos') > 0)
                        style="width: 36%"
                    @endif

                    type="text" class="form-control" name="pesquisar" style="margin:0;" value="{{Input::get('pesquisar')}}">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary btn-flat">Buscar</button>
                    </span>
                </div>
              </form>

            @endif
            <!-- You can dynamically generate breadcrumbs here -->
            <!-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')

            {{-- Modal para aceite dos novos termos de uso do sistema do 2 cartorio --}}
            <!-- Modal -->
            <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Termos e Condições</h4>
                        </div>
                        <div class="modal-body">
                            <p style="text-align: justify; font-size: 11px">Caro usuário, aqui você encontrará o Termo de Adesão e Condições para uso do sistema de intimação eletrônica do 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA, contendo informações importantes sobre os seus direitos e obrigações que podem lhe ser úteis. Por favor, leia todas as informações com atenção.</p>
                            <p style="text-align: center; font-size: 11px"><strong>TERMO DE ADESÃO E CONDIÇÕES GERAIS</strong></p>
                            <p style="text-align: left; font-size: 11px">
                                <strong>1) INTRODUÇÃO</strong>
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                1.1  Este Termo de Adesão e Condições são aplicáveis a todos os serviços eletrônicos oferecidos aos clientes no site 2ProtetoSLZ.com.br, do 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                1.2	 Ao realizar o credenciamento no site 2ProtetoSLZ.com.br o Usuário aceitará de forma implícita todos os Termos e condições aqui dispostos. O 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA se reserva no direito de modificar o presente Termo a qualquer momento, respeitando sempre a legislação vigente.
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                1.3	 Esse Termo constitui o acordo entre o 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA e o Usuário.
                            </p>

                            <p style="text-align: left; font-size: 11px">
                                <strong>2) ESPECIFICAÇÃO</strong>
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                2.1	 Usuário: Pessoa Jurídica (abrangendo matriz e eventuais filiais) ou Física, maior e capaz, que tenha realizado o credenciamento no site 2ProtetoSLZ.com.br para ter acesso os serviços eletrônicos oferecidos pelo 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                2.2	 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA: Razão Social: 2 TABELIONATO DE PROTESTOS DE TÍTULOS, CNPJ: 18.360.302/0001-36, com endereço na Av. dos Holandeses, 1, Quadra 36, Loja 19, Shopping do Automóvel, Bairro CALHAU, CEP: 65.071-380, Telefone: (98) 3303-6415.
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                2.3  Preço: De acordo com a tabela vigente disposta na Lei Estadual Nº 9.109 de 29 de dezembro de 2009, que dispõe sobre custas e emolumentos e dá outras providências.
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                2.4  Serviços
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 40px;">
                                2.4.1  Intimação Eletrônica de Protesto, conforme disposto no artigo 3º, § 4º do Provimento nº 87/2019 do CNJ c/c art. 14, §1.º, da Lei 9.492, de 10 de setembro de 1997, onde o usuário em epígrafe ACEITA ser intimado exclusivamente de forma eletrônica, por meio do e-mail e/ou telefone celular (via WhatsApp e/ou SMS), informados no ato do credenciamento no site 2ProtetoSLZ.com.br, salvo impossibilidade técnica;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 40px;">
                                2.4.2  Emissão de boletos bancário para pagamento de títulos apresentados a protestos, acrescidos de suas respectivas custas e emolumentos devidos ao 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 40px;">
                                2.4.3  Apresentação eletrônica de títulos a protesto, conforme disposto no artigo 2º do Provimento nº 87/2019 do CNJ c/c art. 8º da Lei 9.492, de 10 de setembro de 1997;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 40px;">
                                2.4.4  Atendimento eletrônico aos usuários via e-mail, chat, WhatsApp etc.
                            </p>

                            <p style="text-align: left; font-size: 11px">
                                <strong>3) OPERACIONALIZAÇÃO</strong>
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.1	 Ao realizar o credenciamento, o Usuário deverá aceitar o TERMO DE ADESÃO E CONDIÇÕES GERAIS, por meio do clique no botão <span style="text-decoration: underline;">“Estou ciente e CONCORDO com os termos e condições acima e declaro, para todos os fins, que as informações prestadas neste formulário foram por mim conferidas e são expressão da verdade”</span> , com isso, adere e concorda em se submeter integralmente a estes termos e condições.
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.2	 Ao firmar o presente Termo, o Usuário em epígrafe ASSUME e ACEITA ser intimado exclusivamente de forma eletrônica, por meio do e-mail e/ou telefone celular (via WhatsApp e/ou SMS), informados no ato do credenciamento no site 2ProtetoSLZ.com.br, salvo impossibilidade técnica;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.3	 Caberá ao Usuário verificar regularmente todo e qualquer e-mail ou mensagem de WhatsApp/SMS emitida pelo 2º TABELIONATO DE PROTESTO DE LETRAS E OUTROS TÍTULOS DE CRÉDITOS DE SÃO LUÍS/MA, inclusive na sua caixa de “Spam”, quando for o caso;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.4	 O Usuário será notificado eletronicamente (e-mail, WhatsApp e/ou SMS) da existência de uma nova intimação, lhe competindo acessar o site 2ProtestoSLZ.com.br, realizar o acesso informando seu usuário e senha, para ter acesso a intimação de protesto, acompanhada do respectivo boleto de pagamento das custas e emolumentos devidos;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.5	 Será considerado <strong>INTIMADO</strong> o Usuário que, recebendo a notificação eletrônica (via e-mail, WhatsApp e/ou SMS) da existência de um novo aviso de protesto, não acessar o site 2ProtestoSLZ.com.br e realizar o download da intimação, acompanhada do respectivo boleto para pagamento, que permanecerá disponível até a data do seu vencimento. ;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                3.6	 Para o caso de não pagamento do valor constante na intimação até a data do vencimento do boleto bancário, o título será <strong>protestado</strong>, de acordo o art. 12, Lei 9.492 de 10 de setembro de 1997;
                            </p>

                            <p style="text-align: left; font-size: 11px">
                                <strong>4) CONDIÇÕES GERAIS</strong>
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                4.1	 O acesso ao sistema é individual, sigiloso e intransferível. Dessa forma, o Usuário se compromete a manter o sigilo de seu login e senha;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                4.2	 O usuário declara, sob as penas da lei, que as informações fornecidas neste cadastro são verdadeiras, comprometendo-se a atualizá-las sempre que necessário;
                            </p>
                            <p style="text-align: justify; font-size: 11px; margin-left: 20px;">
                                4.3	 O Usuário declara, ainda, que concorda integralmente com todas as disposições contidas neste Termo.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{url('admin/usuarios/1/aceite')}}" style="float: left; margin-left: 5px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-primary">Aceito</button>
                            </form>
                            <form method="POST" action="{{url('admin/usuarios/2/aceite')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-default">Não Aceito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('admin.template.modals')
    @include('admin.template.footer')

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
{{--  <script src="{{ asset('default/js/jquery-3.2.0.min.js') }}"></script>  --}}
<script src="{{ asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/bootstrap/js/laravel.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/daterangepicker/moment.min.js')}}"></script>
<!-- <script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> -->
<script src="{{ asset('admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('admin/plugins/input-mask/jquery.inputmask.numeric.extensions.js') }}"></script>
<script src="{{ asset('admin/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<script type="text/javascript" >

    $(document).ready(function() {

        function limpa_formulário_cep(grupo) {
          // Limpa valores do formulário de cep.
          $(".endereco."+grupo).val("");
          $(".bairro."+grupo).val("");
          $(".cidade."+grupo).val("");
        }

        $('.btn.descartar').click(function (event) {
            event.preventDefault();

            var resp = confirm('Tem certeza que deseja descartar todas as informações preenchidas?');
            if(resp) history.go(-1);
        });

        @if(substr_count(Request::url(), 'segundotabelionato') > 0 || substr_count(Request::url(), '2protestoslz') > 0)
            @if(Auth::user()->adesao_at == null && Auth::user()->papel_id == 8)
                $('#myModal').modal('show');
            @endif
        @endif

        //Quando o campo cep perde o foco.
        $(".cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, ''),
            grupo = $(this).data('grupo');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $(".endereco."+grupo).val("...")
                    $(".bairro."+grupo).val("...")
                    $(".cidade."+grupo).val("...")

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $(".endereco."+grupo).val(dados.logradouro);
                            $(".bairro."+grupo).val(dados.bairro);
                            $(".cidade."+grupo).val(dados.localidade);
                            $(".ibge."+grupo).val(dados.ibge);

                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep(grupo);
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep(grupo);
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep(grupo);
            }
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#cnpj").inputmask({mask:"99.999.999/9999-99"});
        $(".cpf-mask").inputmask("999.999.999-99");
        $(".cep").inputmask("99.999-999");
        $("#empreFornTel").inputmask("(99) 99999-9999");
        $("#responsavelTelefone").inputmask("(99) 9999-9999");
        $("#responsavelCelular1").inputmask("(99) 99999-9999");
        $("#responsavelCelular2").inputmask("(99) 99999-9999");
        $("#telefone").inputmask("(99) 9999-9999");
        $("#celular1").inputmask("(99) 99999-9999");
        $("#celular2").inputmask("(99) 99999-9999");
        $(".tel").inputmask("(99) 99999-9999");
        $("#dtNasc").inputmask("99/99/9999");

        if( $('.callout:not(.fixed),.alert-info').length>0 ){
            $('.callout:not(.fixed),.alert-info').delay(5000).fadeOut('slow');
        }
    });
</script>

<script>
  $(function () {
    $('#cartorios').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $("#datepickerInicio").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datepickerFim").inputmask("mm/dd/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Timepicker
    $(".timepicker").timepicker({
      showInputs: true
    });
  });
</script>
<script>
  $(function() {
    $( "#datepickerInicio" ).datepicker({
        autoclose: true
    });
  });
</script>
<script>
  $(function() {
      $( "#datepickerFim" ).datepicker({
          autoclose: true
      });
  });

  $('.treeview li.active').closest('.treeview').addClass('active');

</script>

@yield('scripts')

</body>
</html>
