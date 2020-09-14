<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Jornal do Protesto MA</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('ieptbma/css/text_layer_builder.css')}}" />
        <link rel="icon" href="{{asset('ieptbma/img/favicon.png')}}">

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

        <style>
            .navbar-light .navbar-nav .nav-link:hover{
                color: #00b4db;
            }
            #navbar {
                background: rgb(255,255,255); /* Old browsers */
                background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
            }
            .navbar-light .navbar-nav .active>.nav-link {
                color: #00b4db;
            }
            .btn-primary{
                background-color: #0084b2;
            }
        </style>
    </head>

    <body>
    
    <div class="container col-lg-12" style="background-color: #0084b2; color: #FFFFFF">
        <div class="row text-center p-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span>Consulta Gratuita de Protesto: <a style="color: #FFFFFF" href="http://www.pesquisaprotesto.com.br/" target="_blank">www.pesquisaprotesto.com.br</a></span>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-light" id="navbar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExampleDefault">
            <ul class="navbar-nav">
                <a class="navbar-brand" href="{{url('jornaldoprotestoma')}}">JORNAL DO <strong style="color: #0084b2">PROTESTO MA</strong></a>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalPesquisaDocumento">CONSULTAR EDITAL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">EDITAIS EM PDF</a>
                </li>
                <li class="nav-item @if(Request::segment(1) === 'jornais') active @endif">
                    <a class="nav-link" href="{{url('jornais')}}">EDIÇÕES ANTERIORES</a>
                </li>
            </ul>
        </div>        
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="modalPesquisaDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Consulta de Editais</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{url('pesquisaedital')}}">
                    <div class="modal-body">                
                        <div class="form-group">
                            <label for="documento">Por favor, digite seu documento para busca</label>
                            <input type="text" required class="form-control" name="documento" id="documento" placeholder="Digite seu CPF ou CNPJ...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
