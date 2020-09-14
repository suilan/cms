@extends('admin.template.main')
@section('content')
<style>
    th{
        text-align: center;
    }
    td{
        text-align: center;        
    }
    table{
        border-color: #3c8dbc;
    }
    @if($creden != null)
        .content-header form {
            display: none !important;
        }
    @endif
</style>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="contadorTotens">{{ $qtdTitulos }}<sup style="font-size: 20px"></sup></h3>

                <p>Qtd. Títulos</p>
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
                <h3 id="contadorBuscaTotal">{{ $qtdTitulosAVencer }}<sup style="font-size: 20px"></sup></h3>

                <p>Qtd. Títulos a vencer</p>
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
                    <h3 id="contadorEnvioEmailTotal">{{ $qtdTitulosImpressos }}<sup style="font-size: 20px"></sup></h3>

                <p>Qtd. Boletos impressos</p>
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
            @if(Auth::user()->papel_id != 8)
                @if(Input::get('razao'))
                    <h4>Sacado: <strong>{{ strtoupper(Input::get('razao')) }}</strong> - {{ Input::get('cnpj') }}</h4>
                @endif

                @if(Input::get('name'))
                    <h4>Sacado: <strong>{{ strtoupper(Input::get('name')) }}</strong> - {{ Input::get('cpf') }}</h4>
                @endif
                
                <form action="{{ url('admin/segundavia') }}" method="GET" id="formFilter">
                    <div class="pull-right" style="height: 77px">
                        <button class="btn btn-primary" type="submit" style="margin-top:24px">Filtrar</button>
                    </div>
                    
                    <input type="hidden" name="campo" value="{{ Input::get('campo') }}">
                    <input type="hidden" name="pesquisar" value="{{ Input::get('pesquisar') }}">

                    <div class="pull-right"  style="margin-right: 40px">
                        <p><strong>Status da Impressão</strong></p>
                        <label class="radio-inline">
                            <input type="radio" name="statusImpressao" checked value="9">Todos
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="statusImpressao" value="1">Impresso
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="statusImpressao" value="4">Não Impresso
                        </label>
                    </div>
                    <div class="pull-right" style="margin-right: 40px">
                        <p><strong>Vencimento</strong></p>
                        <label class="radio-inline">
                            <input type="radio" name="statusVencimento" checked value="9">Todos
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="statusVencimento" value="1">Vencido
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="statusVencimento" value="4">A vencer
                        </label>
                    </div>
                </form>
            @endif
        </div>
    <!-- /.box-header -->
    @if( sizeof($registros)>0 )
        <div class="box-body table-responsive no-padding">
            <table class="table" id="tabelaTitulos">
                <tbody>
                    <tr>
                        <th>Apresentante</th>
                        <th>Protocolo</th>
                        <th>Data do Apontamento</th>
                        <th style="width: 130px">Pagamento antes do Protesto até</th>
                        <th>Valor do Título</th>                        
                        <th>Valor das custas</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($registros as $key => $value): ?>
                    <tr>
                        <td>{{ strtoupper(trim($value->nome_apresentante)) }}</td>
                        <td>{{ $value->protocolo }}</td>
                        <td>{{ $value->data_emissao_titulo }}</td>
                        <td>{{ $value->vencimento_boleto }}</td>
                        <td>{{ "R$ ".$value->valor_principal_titulo }}</td>                        
                        <td>{{ "R$ ".$value->valor_custas_emolumento }}</td>
                        <td>{{ "R$ ".$value->valor_total_boleto }}</td>
                        <td>
                            <a class="btn" target="_blank" href="{{url('admin/segundavia/'.$value->id)}}" title="Gerar intimação/boleto" data-placement="bottom" data-toggle="tooltip"><i style="font-size: 15px" class="fa fa-print"></i></a>
                        </td>
                        
                        @if ($value->impresso == 0)
                            <td><span class='badge bg-red'>Não Impresso</span></td>
                        @else
                            <td>
                                <span class='badge bg-green'>Impresso </span>
                                @if($value->dataprimimpressao)
                                    <br />
                                    <span class='badge bg-green'>{{ $value->dataprimimpressao }}</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                <?php  endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer clearfix">
            <div class="row">
                <div class="col-sm-12 col-md-4 no-margin pull-left">
                    <div class="dataTables_info" role="status" aria-live="polite" style="margin: 20px 0;">
                        <strong>
                            @if($registros->count() != 1)
                                Visualizando {{$registros->count() * $registros->currentPage()}} de {{$registros->total()}}
                            @else
                                Visualizando {{$registros->total()}} de {{$registros->total()}}
                            @endif
                        </strong>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 no-margin pull-right">
                    @if(!Input::get('pesquisar') && !Input::get('statusImpressao') && !Input::get('statusVencimento'))
                        {!! $registros->render() !!}
                    @else
                        {!! $registros->appends($_GET)->render() !!}
                    @endif
                </div>    
            </div>
        </div>
    @elseif($creden != null && $creden != "credenpj")
        <div class="alert alert-warning" style="margin-left: 10px; margin-right: 10px; margin-bottom: 10px;">
            <strong>2º Tabelionato de Protestos de São Luís informa:</strong> {{$creden}}
        </div>
    @else
        @if($user->papel_id!=2)
            <div class="alert alert-success" style="margin-left: 10px; margin-right: 10px;">
                @if($creden != "credenpj")
                    <strong>2º Tabelionato de Protestos de São Luís informa:</strong> Você não possui nenhuma Intimação Eletônica de Protesto para pagamento.
                @else
                    <strong>2º Tabelionato de Protestos de São Luís informa:</strong> Não foi encontrado nenhuma Intimação Eletônica de Protesto para pagamento.
                @endif
            </div>
        @else
            <div class="alert alert-success" style="margin-left: 10px; margin-right: 10px;">
                @if($creden != "credenpj")
                    <strong>2º Tabelionato de Protestos de São Luís informa:</strong> Você não possui nenhuma Intimação Eletônica de Protesto para pagamento.
                @else
                    <strong>2º Tabelionato de Protestos de São Luís informa:</strong> Não foi encontrado nenhuma Intimação Eletônica de Protesto para pagamento.
                @endif
            </div>
        @endif
    @endif
    </div>
    <!-- /.box -->
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('input:radio[name="statusImpressao"]').filter('[value="{{ Input::get('statusImpressao') }}"]').attr('checked', true);
    </script>

    <script type="text/javascript">
        $('input:radio[name="statusVencimento"]').filter('[value="{{ Input::get('statusVencimento') }}"]').attr('checked', true);
    </script>
@endsection