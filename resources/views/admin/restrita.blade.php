@extends('admin.template.main')
@section('content')
  <div class="row">
  	<div class="col-lg-3 col-xs-6">
  	  <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{!!($qtd_protestos)!!}</h3>
          <p>Protestos</p>
        </div>
        <div class="icon">
          <i class="fa  fa-exclamation-circle"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{!!($qtd_estados)!!}</h3>
          <p>Estados</p>
        </div>
        <div class="icon">
          <i class="fa  fa-map-marker"></i>
        </div>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Cartórios</h3>
        </div>
        <div class="box-body">
          <table id="cartorios" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Cartório</th>
                <th>Telefone</th>
                <th>Cidade</th>
                <th>Data da última Atualização</th>
                <th>QTD de protestos</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['conteudo']['cartorio'] as $arr)
                <tr>
                    <td>{{$arr['nome']}}</td>
                    <td>{{$arr['telefone']}}</td>
                    <td>{{$arr['cidade']}}</td>
                    <td>{{$arr['dt_atualizacao']}}</td>
                    <td>{{$arr['protestos']}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@stop
