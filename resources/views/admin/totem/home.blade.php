@extends('admin.template.main')
@section('scripts')
    <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase.js"></script>
    <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDEnS6sDup06V-ywv1YpDbdA349n_wxvH4",
        authDomain: "ieptb-ma-68143.firebaseapp.com",
        databaseURL: "https://ieptb-ma-68143.firebaseio.com",
        projectId: "ieptb-ma-68143",
        storageBucket: "ieptb-ma-68143.appspot.com",
        messagingSenderId: "1004675538290"
    };
    firebase.initializeApp(config);
    </script>

    <script>
        var database = firebase.database();

        function carregarQtdTotalTotens(){
            var totemJson = database.ref('localidade');
            var contadorTotal = 0;

            totemJson.on('value', function(snap){
                snap.forEach(function(childSnap){
                    contadorTotal = contadorTotal + 1;
                });
                $('#contadorTotens').text(contadorTotal);
                contadorTotal = 0;
            });
        }

        function carregarQtdTotalBuscas(){
            var totemJson = database.ref('localidade');
            var contadorTotal = 0;

            totemJson.on('value', function(snap){
                snap.forEach(function(childSnap){
                    contadorTotal = contadorTotal + childSnap.val().contador;
                });
                $('#contadorBuscaTotal').text(contadorTotal);
                contadorTotal = 0;
            });
        }

        function carregarQtdTotalEnvioEmail(){
            var totemJson = database.ref('localidade');
            var contadorTotal = 0;

            totemJson.on('value', function(snap){
                snap.forEach(function(childSnap){
                    contadorTotal = contadorTotal + childSnap.val().contadorEmail;
                });
                $('#contadorEnvioEmailTotal').text(contadorTotal);
                contadorTotal = 0;
            });
        }

        function carregarDados(){
            var totemJson = database.ref('localidade');
            var contadorTotal = 0;
            var status = "Ativo";
            var color = "green";

            totemJson.on('child_added', function(snap){
                
                if (snap.val().status === 1) {
                    status = "Ativo";
                    color = "green";
                } else {
                    status = "Inativo";
                    color = "red";
                }

                $('#conteudoTotem').append(
                    "<tr id=" + snap.key + ">" +
                        '<td>' + snap.val().nomeLocalidade + '</td>' +
                        '<td>' + snap.val().contador + '</td>' + 
                        '<td>' + snap.val().contadorEmail + '</td>' + 
                        '<td>' + "<span class='badge bg-" + color + "'>" + status + '</span>' + '</td>' + 
                        '<td>' + "<a class='btn' href='#' title='status'>" + "<i style='font-size: 15px' class='fa fa-trash'>" + "</i>" + "</a>" + '</td>' +
                    '<tr>'
                );
            });

            totemJson.on('child_changed', function(snap){
                
                if (snap.val().status === 1) {
                    status = "Ativo";
                    color = "green";
                } else {
                    status = "Inativo";
                    color = "red";
                }

                $("#" + snap.key).replaceWith(
                    "<tr id=" + snap.key + ">" +
                        '<td>' + snap.val().nomeLocalidade + '</td>' +
                        '<td>' + snap.val().contador + '</td>' + 
                        '<td>' + snap.val().contadorEmail + '</td>' + 
                        '<td>' + "<span class='badge bg-" + color + "'>" + status + '</span>' + '</td>' + 
                        '<td>' + "<a class='btn' href='#' title='status'>" + "<i style='font-size: 15px' class='fa fa-trash'>" + "</i>" + "</a>" + '</td>' +
                    '<tr>'
                );
            });
        }

        carregarQtdTotalTotens();
        carregarQtdTotalBuscas();
        carregarQtdTotalEnvioEmail();
        carregarDados();
    </script>
@endsection


@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="contadorTotens">...<sup style="font-size: 20px"></sup></h3>

                <p>Totens Instalados</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-phone-portrait"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3 id="contadorBuscaTotal">...<sup style="font-size: 20px"></sup></h3>

                <p>Consultas Realizadas</p>
            </div>
            <div class="icon">
                <i class="ion ion-search"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                    <h3 id="contadorEnvioEmailTotal">...<sup style="font-size: 20px"></sup></h3>

                <p>E-mails enviados</p>
            </div>
            <div class="icon">
                <i class="ion ion-email"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <a href="#" class="btn btn-primary pull-right">Novo Totem</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="table">
                <tbody id="conteudoTotem">
                    <tr>
                        <th>Localidade</th>
                        <th>Qtd de buscas</th>
                        <th>Qtd E-mails enviados</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix" style="text-align: center">
            
        </div>
    </div>
    <!-- /.box -->
</div>
@endsection