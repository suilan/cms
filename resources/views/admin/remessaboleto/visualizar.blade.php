@extends('admin.template.main')
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="contadorTotens">{{ (int) $qtdTitulos->qtdTitulos }}<sup style="font-size: 20px"></sup></h3>

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
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table ">
                <tbody>
                    <tr>
                        <th>Apresentante</th>
                        <th>Tipo Intimação</th>
                        <th>Data Emissão</th>
                        <th>Pagamento antes do Protesto até</th>
                        <th>Valor do Título</th>                        
                        <th>Valor das custas</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($registros as $key => $value): ?>
                        <tr>
                            <!-- <td><input type="checkbox"></td> -->
                            <td>{{ trim($value->nome_apresentante) }}</td>
                            <td>{{ $value->especie_titulo }}</td>
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
                                <td><span class='badge bg-green'>Impresso</span></td>
                            @endif
                        </tr>
                    <?php  endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix" style="text-align: center">
            @if( Input::get('pesquisar') )
                {!! $registros->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
            @else
                {!! $registros->render() !!}
            @endif
        </div>
    </div>
    <!-- /.box -->
</div>
@endsection