<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "IEPTB MA" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- LINK FOR FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon.png') }}" />
    <style>
    body {padding: 50px;}
    .header {width:100%;text-align:center;padding:20px 0;}
    h1,h2 {font-size:14px;text-align:center;}
    .container{text-align:justify;}
    .bar {width:100%;border-top:1px solid #000;display:block;}
    .head-info{text-align:center;width:100%;}
    td{border:1px solid #000;padding:10px;width: 30%}
    td.head{width:20%;text-align:right;font-weight:bold;}
    table{width:100%;border-collapse:collapse;text-transform:uppercase;}
    </style>
</head>
<body>
    <div class="header" >
        <img src="{{asset('admin/img/logo.png')}}" width="30%" />
        <h1>FORMULÁRIO PARA ASSOCIAÇÃO AO IEPTB-MA – CADASTRO</h1>
    </div>
    <div class="container">
        <p>
            SOLICITO minha ASSOCIAÇÃO/REGULARIZAÇÃO junto ao IEPTB-MA, ciente dos
            direitos e obrigações estabelecidos no estatuto da associação registrado
            no livro A1, fls. 157/163 – microfilme 24249 1/7 do Cartório Cantuária
            de Azevedo – São Luís/MA.
        </p>
        <span class="bar">&nbsp;</span>
        <h2 class="head-info">INFORMAÇÕES DA SERVENTIA</h2>
        <table>
            <tbody>
                <tr>
                    <td class="head">MUNICÍPIO:</td>
                    <td colspan="3">{{$cartorio->cidade}}</td>
                </tr>
                <tr>
                    <td class="head">NOME DA SERVENTIA:</td>
                    <td colspan="3">{{$cartorio->nome}}</td>
                </tr>
                <tr>
                    <td class="head">CNPJ:</td>
                    <td colspan="3">{{$cartorio->cnpj}}</td>
                </tr>
                <tr>
                    <td class="head">ENDEREÇO:</td>
                    <td style="width:45%;">{{$cartorio->endereco}} {{$cartorio->complemento?("-".$cartorio->complemento):""}}</td>
                    <td class="head">NÚMERO:</td>
                    <td>{{$cartorio->numero}}</td>
                </tr>
                <tr>
                    <td  class="head">BAIRRO:</td>
                    <td>{{$cartorio->bairro}}</td>
                    <td class="head">CEP:</td>
                    <td>{{$cartorio->cep}}</td>
                </tr>
                <tr>
                    <td class="head">SITE:</td>
                    <td colspan="3">{{$cartorio->site}}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                @for( $i=0;$i<$contatos->count();$i=$i+2 )
                <tr>
                    <td class="head">{{strtoupper($contatos[$i]->tipo)}}:</td>
                    @if($contatos[$i]->tipo=="E-mail")
                    <td colspan=3>{{$contatos[$i]->contato}}</td>
                    <em style="display:none;" alt="{{$i=$i-1}}"></em>
                    @else
                    <td>{{$contatos[$i]->contato}}</td>
                    @if(isset($contatos[$i+1]))
                    @if( $contatos[$i+1]->tipo=="E-mail" )
                    <td colspan="2"></td>
                    @else
                    <td class="head">{{strtoupper($contatos[$i+1]->tipo)}}:</td>
                    <td>{{$contatos[$i+1]->contato}}</td>
                    @endif
                    @else
                    <td colspan="2"></td>
                    @endif
                    @endif
                </tr>
                @endfor
            </tbody>
        </table>
        <h2 class="head-info">ATRIBUIÇÕES DA SERVENTIA</h2>
        <table>
            <tbody>
                @for($i=0; $i<$atribuicoes->count();$i=$i+2)
                <tr>
                    <td style="border:0;width:15%;">
                        ({{$atribuicoes[$i]->marcado?"✔":" "}}) {{$atribuicoes[$i]->nome}}
                    </td>
                    @if( isset($atribuicoes[$i+1]) )
                    <td style="border:0;">
                        ({{$atribuicoes[$i+1]->marcado?"✔":" "}}) {{$atribuicoes[$i+1]->nome}}
                    </td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endfor
            </tbody>
        </table>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        
        <h2 class="head-info">INFORMAÇÕES DOS RESPONSÁVEIS</h2>
        <table>
            <tbody>
                <tr>
                    <td class="head">TITULAR:</td>
                    <td colspan="3">{{$tabeliao->nome}}</td>
                </tr>
                <tr>
                    <td class="head">CPF:</td>
                    <td>{{$tabeliao->cpf}}</td>
                    <td class="head">RG:</td>
                    <td>{{$tabeliao->rg}}</td>
                </tr>
                <tr>
                    <td class="head">TEL. FIXO:</td>
                    <td>{{$tabeliao->tel}}</td>
                    <td class="head">CELULAR:</td>
                    <td>{{$tabeliao->cel1}}{{$tabeliao->cel2?(" / ".$tabeliao->cel2):""}}</td>
                </tr>
                <tr>
                    <td class="head">E-MAIL:</td>
                    <td colspan="3">{{$tabeliao->email}}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table>
            <tbody>
                <tr>
                    <td class="head">SUBSTITUTO:</td>
                    <td colspan="3">{{$substituto->nome}}</td>
                </tr>
                <tr>
                    <td class="head">CPF:</td>
                    <td>{{$substituto->cpf}}</td>
                    <td class="head">RG:</td>
                    <td>{{$substituto->rg}}</td>
                </tr>
                <tr>
                    <td class="head">TEL. FIXO:</td>
                    <td>{{$substituto->tel}}</td>
                    <td class="head">CELULAR:</td>
                    <td>{{$substituto->cel1}}{{$substituto->cel2?(" / ".$substituto->cel2):""}}</td>
                </tr>
                <tr>
                    <td class="head">E-MAIL:</td>
                    <td colspan="3">{{$substituto->email}}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table>
            <tbody>
                <tr>
                    <td class="head">RESPONSÁVEL:</td>
                    <td colspan="3">{{$responsavel->nome}}</td>
                </tr>
                <tr>
                    <td class="head">CPF:</td>
                    <td>{{$responsavel->cpf}}</td>
                    <td class="head">RG:</td>
                    <td>{{$responsavel->rg}}</td>
                </tr>
                <tr>
                    <td class="head">TEL. FIXO:</td>
                    <td>{{$responsavel->tel}}</td>
                    <td class="head">CELULAR:</td>
                    <td>{{$responsavel->cel1}}{{$responsavel->cel2?(" / ".$responsavel->cel2):""}}</td>
                </tr>
                <tr>
                    <td class="head">E-MAIL:</td>
                    <td colspan="3">{{$responsavel->email}}</td>
                </tr>
            </tbody>
        </table>
        
        <h2 class="head-info">INFORMAÇÕES ADICIONAIS</h2>
        <br>
        <span style="display:block;">O PROTESTO É INFORMATIZADO? ({{$cartorio->informatizado?"✔":" "}}) Sim  ({{$cartorio->informatizado?" ":"✔"}}) Não</span>
        <br/>
        <div class="adicionais" style="{{$cartorio->informatizado?"":"display:none;"}}">
            <span style="display:block;"><strong>NOME DA EMPRESA:</strong> {{$cartorio->empresainfo}}</span>
            <span style="display:block;margin-top: 20px;margin-bottom: 20px;"><strong>RESPONSÁVEL:</strong> {{$cartorio->responsavelinfo}}</span>
            <span style="display:block;"><strong>TELEFONE:</strong> {{$cartorio->contatoinfo}}</span>
            <h2 class="head-info">ATRIBUIÇÕES INFORMATIZADAS</h2>
            <table>
                <tbody>
                    @for($i=0; $i<$atribuicoes->count();$i=$i+2)
                    <tr>
                        <td style="border:0;width:15%;">
                            ({{$atribuicoes[$i]->informatizado?"✔":" "}}) {{$atribuicoes[$i]->nome}}
                        </td>
                        @if( isset($atribuicoes[$i+1]) )
                        <td style="border:0;">
                            ({{$atribuicoes[$i+1]->informatizado?"✔":" "}}) {{$atribuicoes[$i+1]->nome}}
                        </td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <h1>DADOS BANCÁRIOS PARA PAGAMENTOS DE EMOLUMENTOS:</h1>
        <table>
            <tbody>
                <tr>
                    <td class="head">FAVORECIDO:</td>
                    <td colspan="3">{{$banco->favorecido}}</td>
                </tr>
                <tr>
                    <td class="head">CPF/CNPJ:</td>
                    <td colspan="3">{{$banco->cpf_cnpj}}</td>
                </tr>
                <tr>
                    <td class="head">BANCO:</td>
                    <td>{{$banco->banco}}</td>
                    <td class="head">AGÊNCIA:</td>
                    <td>{{$banco->agencia}}</td>
                </tr>
                <tr>
                    <td class="head">C.CORRENTE:</td>
                    <td>{{$banco->conta_corrente}}</td>
                    <td class="head">C.POUPANÇA:</td>
                    <td>{{$banco->conta_poupanca}}</td>
                </tr>
            </tbody>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <span style="display:block;text-align:center;">_____________________/_______, ______ de ________________ de 2017</span>
        <br/>
        <br/>
        <br/>
        <br/>
        <span style="display:block;text-align:center;">______________________________________________________________</span>
        <span style="display:block;text-align:center;">CPF / ASSINATURA DO TABELIÃO(Ã)</span>
    </div>
    <br/>
    <br/>
    <br/>
    <span style="display:block;text-align:center;">Av. Daniel de La Touche, 978 - Cohama - Centro Empresarial Shopping da Ilha, Torre 1, 12º Andar, Sala 1211 CEP: 65074-115, São Luís/MA</span>
    <span style="display:block;text-align:center;">Telefones: (98) 3304-8117/(98) 3304-8119 | CNPJ: 19.920.825/0001-52</span>
    <span style="display:block;text-align:center;">E-mail: contato@ieptbma.com.br</span>
    <script>window.print();</script>
</body>
</html>
