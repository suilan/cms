@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
  <div class="box box-primary">
    <div class="box-header">
      <h2 >Eventos</h2>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table class="table">
        <tbody><tr>
	  <th>Sel.</th>
          <th>User</th>
          <th>Date</th>
          <th>Status</th>
          <th>Título</th>
          <th></th>
        </tr>
	<?php foreach ($eventos as $key => $value): ?>
        <tr>
	  <td><input type="checkbox"></td>
          <td>John Doe</td>
          <td>{!! $value->created_at !!}</td>
          <td><span class="label label-success">Approved</span></td>
          <td>{!! $value->titulo !!}</td>
          <td>
            <a class="btn" href="{!! url('visualizar-evento/'.$value->id) !!}"><i style="font-size: 15px" class="fa fa-search"></i></a>
            <a class="btn" href="{!! url('editar-evento/'.$value->id) !!}"><i style="font-size: 15px" class="fa fa-edit"></i></a>
            <a class="btn" href="{!! url('deletar-evento/'.$value->id) !!}"><i style="font-size: 15px" class="fa fa-trash"></i></a>
          </td>
	<?php  endforeach; ?>
        </tr>
      </tbody></table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
      <ul class="pagination pagination-sm no-margin">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
      </ul>
    </div>
  </div>
  <!-- /.box -->
</div>


  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header">
        <h2>Novo Evento</h2>
      </div>
	<form action="{{ url("criar-evento")}}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
          @if (session('erro'))
                 <div class="alert alert-danger">
                  {{ session('erro') }}
                 </div>
          @endif
        <div class="box-body">
            <div class="form-group">
               <label for="evento" class="col-sm-1 control-label">Evento</label>
                  <div class="col-sm-5">
                    <input type="text" name="titulo" id="titulo" class="form-control" >
                  </div>
            </div>
        </div>
	<!-- COMEÇO RANGER -->
	<div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Data do Evento - Início</h3>
            </div>
            <div class="box-body">
              <!-- Date -->
              <div class="form-group">
                <label>Data Inicial:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="data_inicial"class="form-control pull-right" id="datepickerInicio">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date and time range -->
              <div class="form-group">
                <label>Hora Inicial:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text" name="hora_inicial" class="form-control pull-right timepicker" id="timepickerInicio">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
	<!-- FIM RNAGER -->
	<!-- COMECO RNGER 2 -->
	       <!-- COMEÇO RANGER -->
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Data do Evento - Fim</h3>
            </div>
            <div class="box-body">

              <!-- Date range -->
              <div class="form-group">
                <label>Data Final:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="data_final" class="form-control pull-right" id="datepickerFim">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date and time range -->
              <div class="form-group">
                <label>Hora Final:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text" name="hora_final" class="form-control pull-right timepicker" id="timepickerFim">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- FIM RNAGER -->

	<!-- FIM RANGER 2 -->
	<div class="box-body">
	</div>
	             <div class="box-body col-xs-12">
                <textarea placeholder="Digite um novo Evento" name="conteudo" class="form-control" style="height: 300px;"></textarea>
                </div>

      <!-- /.box-header -->
      <div class="box-footer">
        <div class="pull-right">
          <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i>   Adicionar Evento</button>
        </div>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
      </div>

      <!-- /.box-footer -->
    </div>
    <!-- /. box -->
  </div>
</div>
@stop
