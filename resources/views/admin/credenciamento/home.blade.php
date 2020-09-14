@extends('admin.template.main')
@section('content')
<style media="screen">
    .row-centered {
        text-align:center;
    }
    .col-centered {
        display:inline-block;
        float:none;
        text-align:left;
        margin-right:-4px;
    }
    .pos{
        position: relative;
        top: 240px;
    }
</style>

@if ($status != '')
    @if(strpos($status,'sucesso') === false)
        <div class="alert alert-danger">
            <ul>
                <li>{{ $status }}</li>
            </ul>
        </div>
    @else
      <div class="alert alert-info">
          <ul>
              <li>{{ $status }}</li>
          </ul>
      </div>
    @endif
@endif
<div class="row row-centered">
    <div class="col-lg-8 col-xs-12 col-centered">
      <div class="box box-primary">
        <div class="box ">
	      <h3>{{$qtd_confirmados}} Confirmados | {{$qtd_credenciados}} Credenciados </h3>
        </div>
          <div class="box-header with-border">
              <h3 class="box-title">Credenciamento</h3>
          </div>
          <div class="box-body">
              <form action="{{url('admin/credenciamento/1')}}" method="get">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                      <label for="cpfParticipante">CPF</label>
                      <input id="cpfParticipante" name="cpfParticipante" class="form-control input-lg cpf-mask" type="text" placeholder="CPF do participante">
                  </div>
                  <div class="form-group">
                      <label for="cpfParticipante">Nome</label>
                      <input id="cpfParticipante" name="nomeParticipante" class="form-control input-lg" type="text" placeholder="Nome do participante">
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-block btn-info btn-lg">Buscar</button>
                  </div>
              </form>
          </div>
      </div>
    <!-- /.box -->
</div>
@endsection
