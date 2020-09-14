@include('ieptbma::jornal.head')
<style>
    .card-header{
        background-color: rgba(0,132,178,.4);
    }
</style>
<div class="container">
    <h2 class="my-4 text-center text-lg-left">EDITAIS DE PROTESTO</h2>
    <h5 style="margin-top: -23px" class="text-center text-lg-left">RESULTADO DA PESQUISA PARA O DOCUMENTO (<span style="color: #0084b2">{{ $documento }}</span>) REALIZADA EM <strong style="color: #0084b2">{{ date('d/m/Y À\S H:i:s') }}</strong></h5>
    <hr />
    {{--  @if( sizeof($registros) > 0 )
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <h5 class="card-header">
                            CARTÓRIO
                        </h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <h5 class="text-lg-left">Endereço</h5>
                                    <span class="text-uppercase">{{ $enderecoCartorio->endereco }}, {{ $enderecoCartorio->numero }} -  {{ $enderecoCartorio->complemento }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-6 mb-2">
                                    <h5 class="text-lg-left">Bairro</h5>
                                    <span class="text-uppercase">{{ $enderecoCartorio->bairro }}</span>
                                </div> 
                                <div class="col-sm-6">
                                    <h5 class="text-lg-left">CEP</h5>
                                    {{ $enderecoCartorio->cep }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-6 mb-2">
                                    <h5 class="text-lg-left">Tabelião</h5>
                                    {{ $enderecoCartorio->nome }}
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="text-lg-left">Telefone</h5>
                                    {{ $enderecoCartorio->tel }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <h5 class="text-lg-left">Horário de funcionamento</h5>
                                    09:00 às 18:00
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <h5 class="card-header">
                            DEVEDOR
                        </h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <h5 class="text-lg-left">Nome</h5>
                                    <span class="text-uppercase">{{ $registros->nome_sacado }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 mt-2">
                                    <h5 class="text-lg-left">Endereço</h5>
                                    <span class="text-uppercase">{{ $registros->endereco_sacado }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="card">
                            <h5 class="card-header">
                                DADOS DO TÍTULO
                            </h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">Protocolo</h5>
                                        <span class="text-uppercase">{{ $registros->protocolo }}</span>
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">Data do Protocolo</h5>
                                        <span class="text-uppercase">{{ $registros->data_apontamento }}</span>
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">N˚ do Título</h5>
                                        <span class="text-uppercase">{{ $registros->numero_titulo }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">Espécie</h5>
                                        <span class="text-uppercase">{{ $registros->especie_titulo }}</span>
                                    </div>
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">Data do vencimento</h5>
                                        <span class="text-uppercase">{{ $registros->data_vencimento_titulo }}</span>
                                    </div> 
                                    <div class="col-sm-4 mt-2">
                                        <h5 class="text-lg-left">Pagamento em Cartório até</h5>
                                        <span class="text-uppercase">{{ $registros->vencimento_boleto }}</span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @else  --}}
        <h5>
            Não há intimações por edital em desfavor do documento pesquisado(<span style="color: #0084b2">{{ $documento }}</span>), publicados na data de <span style="color: #0084b2">{{ date('d/m/Y') }}</span>.
        </h5>
        <h5>
            O resultado acima reflete os dados fornecidos pelos cartórios que publicam suas intimações por edital eletrônico no Jornal do Protesto.
        </h5>
    {{--  @endif  --}}
    <div class="row mt-2">
        <div class="col-sm-12">
            <h5>
                <a href="#" style="color: #0084b2">Clique aqui</a> para conhecer a lista de cartórios participantes desta publicação.
            </h5>
        </div>
    </div>
</div>
@include('ieptbma::jornal.footer')