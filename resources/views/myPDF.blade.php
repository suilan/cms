<!DOCTYPE html>
<html>
    <head>
        <title>Cartorios de Protesto - MA</title>
        <style>
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
                font-family: Arial;
            }
            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #007ac9;
                color: white;
                line-height: 1.5cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #007ac9;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }
            .center_title{
                text-align: center;
                color: #FFFFFF;
                width: 83%;
                float: right;
                font-size: 12px
            }
            .center_title p{
                margin: 2px
            }
            .logo_left{
                width: 17%;
                float: left;
            }
            p{
                line-height: normal;
                margin: 5px
            },
            .documento-pesquisado{
                color: #FFFFFF;
            }
            .bandeira{
                width: 150px;
            }
            td{
                vertical-align: baseline;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="logo_left">
                <img src="{{ asset('ieptbma/img/logo.png') }}" 
                style="height: 150px; margin-left: 16px" />
            </div>
            <div class="center_title">
                <p>Instituto de Estudo de Protesto de Títulos do Brasil | <strong>Seção Maranhão</strong></p>
                <p style="color: white">Pesquisa retroativa a 5 anos</p>
                <p>CNPJ pesquisado: <span class="documento-pesquisado">$dados->documento_pesquisado</span></p>
                <p>Data da Pesquisa: <?php echo date("d/m/Y");?></p> 
            </div>
        </header>

        <footer>
            <p>Av. Daniel de La Touche, 978 - Cohama </p>
            <p>Centro Empresarial Shopping da Ilha, Torre 1, 12º Andar, Sala 1211 </p>
            <p>CEP: 65074-115, São Luís/MA</p>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div>
                @foreach ($dados->dados as $k => $estado)
                    <div style="margin-top: 70px">
                        <table border="0">
                            <tbody>
                                <tr>
                                    <td><img class="bandeira" src="{{ asset('images/bandeiras/'.$estado->uf.'.png') }}" /></td>
                                    <td><strong style="font-size: 25px;margin-top: 38px;margin-left: 20px;">{{ $estado->uf }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table border="0">
                        <tbody>
                            <tr>
                                @foreach ($estado->cartorios as $e => $cartorio)
                                        <td>
                                            @foreach ($cartorio as $c => $dados)
                                                @if( ($c + 1) % 2 != 0)
                                                    <div style="max-width: 350px; margin-top: 5px; border:thin solid #0285d0; border-radius:thin 5px;padding: 5px">
                                                        <div>
                                                            <strong>Cartório: </strong> {{ mb_strtoupper($dados->descricao,'UTF-8') }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Endereço: </strong> {{ strtoupper($dados->endereco) }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Qtd Protestos: </strong> {{ $dados->num_protestos }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Data atualização: </strong> {{ $dados->data_atualizacao }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($cartorio as $c => $dados)
                                                @if( ($c + 1) % 2 == 0)
                                                    <div style="max-width: 350px; margin-top: 5px; border:thin solid #0285d0; border-radius:thin 5px;padding: 5px">
                                                        <div>
                                                            <strong>Cartório: </strong> {{ mb_strtoupper($dados->descricao,'UTF-8') }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Endereço: </strong> {{ strtoupper($dados->endereco) }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Qtd Protestos: </strong> {{ $dados->num_protestos }}
                                                        </div>
                                                        <div style="margin-top: 5px">
                                                            <strong>Data atualização: </strong> {{ $dados->data_atualizacao }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
        </main>
    </body>
</html>