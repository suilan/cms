@extends('ieptbma::template.main')

@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="{{url('')}}">Home</a></li>
        <li>Perguntas Frequentes</li>
    </ul>
</div>
<h2 class="titulo">Perguntas Frequentes</h2>
<div class="filtro">
    <input type="text" id="busca" placeholder="Busca por palavra-chave" />
    <i class="fa fa-search" aria-hidden="true"></i>
</div>
<ol>
    <li class="duvida">
        <h3 class="pergunta">Quais os efeitos e finalidades do protesto extrajudicial ?</h3>
        <div class="resposta">
            <p>Os chamados Títulos de Crédito sempre foram passíveis de protesto. Os mais comumente apresentados são:</p>
            <ul style="list-style-type:disc;">
                <li><strong>PROVA A INADIMPLÊNCIA DO DEVEDOR:</strong> constitui prova de que o devedor deixou de pagar no vencimento obrigação líquida, certa e exigível, considerando em mora, em atraso, o devedor, possibilitando as cobranças de juros e multas legais;</li>
                <li><strong>REQUISITO PARA AÇÃO DE EXECUÇÃO DE CONTRATO DE CÂMBIO</strong>: O contrato de câmbio, depois de protestado no cartório de protesto competente, constitui instrumento bastante para requerer a ação executiva.</li>
                <li><strong>CONSTITUIÇÃO DE PROVA</strong>: constitui elemento importante para caraterização da fraude contra credores, dessa forma, o protesto colabora na produção de prova em ação judicial;</li>
                <li><strong>ESTABELECE TERMO À MORA DO DEVEDOR</strong>: não havendo prazo assinado, a data do registro do protesto é o termo inicial, ou seja, a data inicial de incidência de juros, taxas e atualizações monetárias sobre o valor da obrigação contida no título ou documento de dívida;</li>
                <li><strong>PRESSUPOSTO PARA O DIREITO DE AÇÃO</strong>: confere interesse de agir ao portador de duplicata ou letra de cambio não aceita, para a propositura de ação de execução. A não aceitação ocorre quando o sacado não concorda com a dívida e se recusa a assumi-la;</li>
                <li><strong>AÇÃO CONTRA OS COOBRIGADOS</strong>: assegura o portador do direito de mover ação judicial contra os endossantes, avalistas e demais coobrigados. Ou seja, o portador adquire os direitos cambiários em relação aos devedores indiretos, desde que protestado no prazo legal.</li>
                <li><strong>INTERROMPE A PRESCRIÇÃO</strong>: o prazo prescricional para se mover a devida ação volta ao início, assim, o credor tem um tempo maior para entrar com ação de cobrança judicial sem que perca seu direito à pretensão de recebimento;</li>
                <li><span><strong>REQUISITO PARA FALÊNCIA</strong>: Sinaliza a insolvência, servindo como requisito para requerer falência do devedor, fixando o prazo e resguardando os direitos do credor, ou seja, para mover ação de falência contra o devedor é obrigatório o protesto extrajudicial da dívida;</span></li>
            </ul>
        </p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Quais documentos podem ser protestados?</h3>
        <div class="resposta">
            <p>Os chamados Títulos de Crédito sempre foram passíveis de protesto. Os mais comumente apresentados são:</p>
            <ul style="list-style-type:disc;">
                <li>Duplicata Mercantil;</li>
                <li>Duplicata de Serviços;</li>
                <li>Duplicata por Indicação;</li>
                <li>Cheque;</li>
                <li>Letra de Câmbio;</li>
                <li>Nota Promissória;</li>
                <li>Cédula de Crédito Bancário;</li>
                <li>Cédula de Crédito Comercial;</li>
                <li>Cédula de Crédito Industrial;</li>
                <li>Fatura de Conta de Serviços (própria para profissionais liberais).</li>
            </ul>
        </div>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Efeitos</h3>
        <p class="resposta">Na esfera judicial, o credor terá em seu poder a prova formal, revestida de veracidade e fé pública, de que o devedor está inadimplente ou descumpriu sua obrigação. Com essa prova, poderá requerer em juízo as medidas liminares, como busca e apreensão, arrestos, etc., terá mais chance de ser o vencedor das ações que promover, cuja discussão seja o título, etc. Já no âmbito extrajudicial, o protesto interessará a quem realiza empréstimos ou financiamentos, pois estas pessoas (físicas ou jurídicas) desejam saber a real capacidade da outra parte, no que tange ao cumprimento de suas obrigações. Assim, os interessados em geral, sobretudo os órgãos de proteção ao crédito (Associação Comercial, Serasa, etc.) solicitam dos tabelionatos de protesto as relações de pessoas que possuem protestos, lançando-os em seus bancos de dados. Com isso, tem-se maior segurança jurídica, pois, em um exemplo prático, uma empresa financeira só irá realizar um empréstimo se o contratante estiver com seu “nome limpo na praça”.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Custo</h3>
        <p class="resposta">No Estado do Maranhão, em regra, a apresentação de Títulos ou Documentos de Dívida é feita de forma GRATUITA para os Credores, ou seja, basta levar o Título ou Documento de Dívida ao Cartório de Protesto, que todas as despesas serão pagar pelo DEVEDOR, no momento em que este for cancelar o protesto. As Duplicatas Mercantis e Duplicatas de Serviços por Indicação apresentadas por Instituições Financeiras devem ser pagas pelo apresentante, logo após a lavratura do ato: pagamento, retirada ou cancelamento.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Apresentação</h3>
        <p class="resposta">Os títulos para protesto podem ser apresentados diretamente no cartório. No entanto, em Comarcas onde há mais de um Tabelionato, há a necessidade de um Serviço de Distribuição, onde os títulos são divididos quantitativamente (em relação ao número de títulos) e qualitativamente (em relação à faixa de valores em que estão inseridos). Para facilitar a apresentação, um acordo com a Febraban foi celebrado, autorizando que os títulos oriundos de bancos sejam enviados por meio magnético (disquete) ou por meio eletrônico de dados, devendo os Tabelionatos providenciar tão-somente a sua mera instrumentalização, conforme dispõe a Lei do Protesto (Lei 9.492/97), em seu artigo 8º, parágrafo único.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Pagamento</h3>
        <p class="resposta">O pagamento do título ocorre quando o devedor, sendo intimado, comparece ao Cartório, ainda dentro do prazo em curso (prazo de três dias em que o devedor tem para pagar o título em Cartório), para liquidá-lo. Para isso, o devedor paga a importância referente ao valor do título, acrescido dos respectivos emolumentos. Como consequência do pagamento, o protesto do título não é lavrado, e o nome do devedor não é inscrito nos temidos órgãos de proteção ao crédito.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Retirada Antes do Protesto ou Retirada Sem Protesto</h3>
        <p class="resposta">É um ato praticado exclusivamente pelo apresentante, antes do vencimento do prazo de 03 (três) dias em que o devedor tem para pagar o título em Cartório, que impede o protesto do título. É a desistência do protesto. Nesta hipótese, quem arcará com os respectivos emolumentos é o apresentante desistente.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Sustação Judicial</h3>
        <p class="resposta">Havendo qualquer ilegalidade ou irregularidade, por exemplo, intimação para pagamento de dívida que já foi paga, a parte interessada deve requerer ao Juiz Competente, que poderá determinar a Sustação do Protesto, impedindo a sua lavratura. </p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Falta de Aceite e Devolução</h3>
        <p class="resposta">Nesta hipótese, que ocorre O protesto por falta de aceite ou por falta de devolução só é efetuado quando o Título é apresentado para aceite ou devolução e há recusa por parte da pessoa indicada. Este tipo de protesto somente poderá ser efetuado após o decurso do prazo legal para o aceite ou para a devolução e sempre ANTES DO VENCIMENTO da obrigação.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Protesto</h3>
        <p class="resposta">É o ato que efetivamente torna público o não pagamento (falta de aceite ou devolução) de uma obrigação contida em um título ou outro documento de dívida. Após a apresentação do título ou outro documento de dívida o Tabelião verifica a sua regularidade formal e intima do devedor para pagar em três dias; após esse prazo, não havendo o pagamento o Tabelião lavra o protesto, que ficará registrado em livro do Tabelionato, por prazo indeterminado. Após a lavratura e registro o Tabelionato informa o protesto aos órgãos de restrição de crédito SPC, SERASA, Boa Vista etc.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Cancelamento</h3>
        <p class="resposta">O protesto só pode ser cancelado mediante a apresentação da Certidão do Instrumento de Protesto (documento enviado ao credor, que comprova a lavratura do protesto) ou mediante Carta de Anuência emitida pelo Credor (com firma reconhecida) informando o pagamento do título ao credor. Qualquer outra forma de cancelamento dependerá de determinação judicial.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Suspensão Judicial dos Efeitos do Protesto</h3>
        <p class="resposta">A Cautelar de Sustação de Protesto deve ser utilizada para Sustar o Protesto dentro dos três dias permitidos para o pagamento do título no Cartório, ou seja, após o protesto não há de se falar em Sustação do Protesto. Assim, após a lavratura do protesto, havendo alguma irregularidade ou ilegalidade, por exemplo, protesto de dívida que já foi paga, a parte interessada deverá requerer a Suspensão Judicial dos Efeitos do Protesto.</p>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Institutos e Terminologias do Serviço de Protesto</h3>
        <div class="resposta">
            <ul style="list-style-type:disc;">
                <li><strong>Apresentante</strong>: é a parte que procede no pedido de entrada no protesto. Geralmente é o credor, mas pode ocorrer que o apresentante seja apenas um mero cobrador do título, em virtude de endosso mandato. Cedente: é a parte que transmite o crédito ao apresentante (quando o endosso for translativo) ou lhe transfere simplesmente os poderes de cobrança (endosso mandato).</li>
                <li><strong>Responsável, Sacado ou Devedor</strong>: é a pessoa que deverá pagar o título. Emitente: é a pessoa que emite um título de crédito. Os emitentes de notas promissórias e cheques, por exemplo, são devedores desses títulos. Já os emitentes de duplicatas e letras de câmbio, por sua vez, são credores desses títulos.</li>
                <li><strong>Portado</strong>r: no que concerne ao protesto, portador é a pessoa que comparece ao balcão de atendimento para dar entrada nos títulos. Pode ou não ser a mesma pessoa que o apresentante.</li>
                <li><strong>Tríduo</strong>: compreende o prazo de 03 (três) dias em que o devedor tem para pagar o título em Cartório, após a sua protocolização. Vencido o tríduo, o título é protestado imediatamente. Contudo, se o devedor for intimado no último dia (vencimento), lhe será acrescido um dia a mais, uma vez que o devedor deve ser notificado, no mínimo, com 24 (vinte e quatro) horas de antecedência ao vencimento do tríduo.</li>
            </ul>
        </div>
    </li>
    <li class="duvida">
        <h3 class="pergunta">Tipos de Protesto ou Motivos do Protesto</h3>
        <div class="resposta">
            <ul style="list-style-type:disc;">
                <li><strong>Por Falta de Pagamento</strong>: é o mais comumente utilizado. Basta que o devedor não pague um determinado título até o dia do seu vencimento para que haja ensejo ao protesto por falta de pagamento.</li>
                <li><strong>Por Falta de Aceite</strong>: quando um título não está aceito, poderá ser protestado, a fim de que o devedor seja notificado a comparecer em Cartório para realizar o aceite. Contudo, esse protesto não gera nenhuma obrigação para o sacado, uma vez que, se o título não foi aceito, não se pode considerar como devedor o sacado não-aceitante, razão pela qual seu nome não poderá integrar o rol dos inadimplentes (Serasa, SPC, etc). Não haverá, portanto, publicidade, apenas a notificação do sacado não-aceitante pelo Tabelionato de Protesto.</li>
                <li><strong>Por Falta de Devolução</strong>: refere-se somente às duplicatas. A duplicata é um título causal, ou seja, só poderá ser sacada (ter origem) se houver uma razão antecedente – uma relação jurídica de compra e venda mercantil ou uma prestação de serviços. O sacador dá origem à duplicata e a envia para o sacado (devedor) aceitá-la. Se o sacado não devolver ao sacador a duplicata aceita no prazo de 10 (dez) dias, nos termos do artigo 7º da Lei 5.474/68 (Lei das Duplicatas), poderá o sacador protestá-la por falta de devolução. Entretanto, essa não é a única medida eficaz ao cumprimento da obrigação de pagar, uma vez que, ao invés de protestar por falta de devolução, o sacador poderá emitir uma triplicata (segunda via da duplicata) ou emitir uma outra duplicata instruída com a Nota Fiscal que lhe deu origem, juntamente com o comprovante de recebimento da mercadoria ou serviço prestado, ou ainda inserir uma declaração no verso do título, dizendo possuir prova da compra, venda e entrega da mercadoria, assumido responsabilidade pela sua apresentação onde e quando exigidos. Por isso, o motivo de protesto por falta de devolução não é muito invocado.</li>
                <li><strong>Para o Exercício do Direito de Regresso</strong>: o Direito de Regresso é conferido aos avalistas e aos endossantes, quando qualquer um deles efetuar a obrigação de pagar o título, que, por natureza, seria do devedor principal - há, portanto, o que se denomina sub-rogação pessoal. O avalista ou o endossante poderão protestar o título, a fim de serem ressarcidos pelo devedor principal em relação ao valor que pagaram, por serem apenas garantidores.</li>
                <li><strong>Para Fins de Falência do Devedor</strong>: é o protesto, por falta de pagamento, destinado a comprovar a insolvência do devedor para pedir, a posteriori, a sua falência. Portanto, só poderá ser protestado o devedor que for Pessoa Jurídica sujeita à falência, estando excluídas, destarte, as associações, cooperativas, sociedades anônimas (como Bancos, Seguradoras, etc.), pessoas jurídicas de direito público (União, Estados, Distrito Federal, Municípios e suas respectivas autarquias e fundações), etc. Para que um título possa ser protestado para fins falimentares, é necessária a apresentação de um requerimento especial, de preferência com a firma do signatário devidamente reconhecida, contendo os dados do apresentante e do devedor, sendo expressamente consignado o motivo do protesto, qual seja, para fins de falência.</li>
            </ul>
        </div>
    </li>
</ol>
@stop

@section('scripts')
<script>
    $(document).ready(function() {
        $('.duvida').click(function(event) {
            if ( $(this).hasClass('show') ) {
                $('.duvida').removeClass('show');
            } else {
                $('.duvida').removeClass('show');
                $(this).addClass('show');
            }
        });

        // To search for the word
        $('#busca').keyup(function() {
            var word = this.value;
            $('li.duvida').each(function() {
                var text = this.innerText.toLowerCase();
                if(word==''){
                    this.style.display="block";
                }
                else if( text.indexOf(word.toLowerCase())>-1 )
                {
                   this.style.display='block'
                }
                else{
                   this.style.display='none';
                }
            });
        });
    });
</script>
@stop

