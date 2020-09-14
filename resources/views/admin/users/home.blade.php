@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            @if(Auth::user()->papel_id <= 2)
                <a href="{{url('admin/usuarios/create')}}" class="btn btn-primary pull-right">Novo</a>
            @endif
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
      @include('admin.template.alerts')
      <table class="table">
        <tbody>
        <tr>
          <th>Usuário</th>
          <th>Perfil</th>
          <th>CPF/CNPJ</th>
          <th>E-mail</th>
          <th>Aceite do Termo</th>
          <th>Ações</th>
        </tr>
	      <?php foreach ($users as $key => $value): ?>
          <tr>
            <td>{{$value->name}}</td>
            <td>{{strtoupper($perfis[$value->papel_id])}}</td>
            <td>{{$value->cpf}}</td>
            <td>{{$value->email}}</td>
            <td>{{ $value->adesao_at != null ? date('d/m/Y H:i:s', strtotime($value->adesao_at)) : null }}</td>
            <td>
              <a class="btn" href="{{url('admin/usuarios/'.$value->id)}}" title="Visualizar"><i style="font-size: 15px" class="fa fa-search"></i></a>
              <a class="btn" href="{{url('admin/usuarios/'.$value->id).'/edit'}}" title="Editar"><i style="font-size: 15px" class="fa fa-edit"></i></a>
              @if( $currentUser!=$value->id )
              <a class="btn" href="{{url('admin/usuarios/'.$value->id)}}" data-method="delete" title="Excluir"
                data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                <i style="font-size: 15px" class="fa fa-trash"></i>
              </a>
              @endif
            </td>
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
                      @if($users->count() != 1)
                          Visualizando {{$users->count() * $users->currentPage()}} de {{$users->total()}}
                      @else
                          Visualizando {{$users->total()}} de {{$users->total()}}
                      @endif
                  </strong>
              </div>
          </div>
          <div class="col-sm-12 col-md-8 no-margin pull-right">
            {!! $users->render() !!}
          </div>    
      </div>
    </div>
  </div>
  <!-- /.box -->
</div>

@endsection
