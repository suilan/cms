@extends('admin.template.main')
@section('content')
<div class="row">
  <div class="col-xs-12">
    @if( Session::get('sucesso') )
        <div class="alert alert-info">O documento assinado foi salvo com sucesso!</div>
    @endif
    @if( Session::get('erro') )
        <div class="alert alert-danger">Não foi possivel salvar o documento!</div>
    @endif
      <div class="box box-primary">
          <div class="box-header">
              @if( !$associado || $cartorios->count()==0)
                <a href="{{url('admin/cartorios/create')}}" class="btn btn-primary pull-right">Novo Cartório</a>
              @endif
          </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        @if( sizeof($cartorios)>0 )
        <table class="table">
          <tbody><tr>
            <th>CPF/CNPJ</th>
            <th>Cidade</th>
            <th>Cartório</th>
            <th>Ações</th>
          </tr>
  	<?php foreach ($cartorios as $key => $value): ?>
          <tr style="text-transform:uppercase;">
            <td>{{$value->cnpj}}</td>
            <td>{{$value->cidade}}</td>
            <td>{{$value->nome}}</td>
            <td>
              <a class="btn" href="{{url('admin/cartorios/'.$value->id)}}" target="_blank">
                  <i style="font-size: 15px" class="fa fa-search"></i>
              </a>
              <a class="btn" href="{{url('admin/cartorios/'.$value->id).'/edit'}}">
                  <i style="font-size: 15px" class="fa fa-edit"></i>
              </a>
              <a class="btn" href="{{url('admin/cartorios/'.$value->id)}}" data-method="delete"
                data-token="{{csrf_token()}}" data-confirm="Você deseja realmente deletar este registro?">
                <i style="font-size: 15px" class="fa fa-trash"></i>
              </a>
              <a class="btn upload" data-id="{{$value->id}}" data-token="{{csrf_token()}}" data-toggle="modal" href="#upload-modal"  title="Upload do documento assinado">
                <i style="font-size: 15px" class="fa fa-upload"></i>
              </a>
            </td>
          </tr>
  	<?php  endforeach; ?>
        </tbody>
     </table>
     @else
         Nenhum registro encontrado.
     @endif
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix" style="text-align: center">
          {!! $cartorios->render() !!}
      </div>
    </div>
    <!-- /.box -->
  </div>
  <div class="modal" id="upload-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Upload do Documento Assinado</h4>
        </div>
        <form class="" action="{{url('admin/cartorios/upload')}}" method="post" enctype="multipart/form-data">
          <div class="modal-body">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="input" class="control-label">Upload do Documento Assinado: </label>
                  <input type="hidden" class="cartorio-id" name="id" value="">
                  <input type="hidden" class="csrf-token" name="_token" value="">
                  <input type="file" name="arquivo" id="arquivo" class="form-control" value="" title="Arquivo Assinado">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
@endsection

@section('scripts')
<script>
  $('#upload-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('id') // Extract info from data-* attributes
    var token = button.data('token') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.cartorio-id').val(recipient);
    modal.find('.csrf-token').val(token);
  });
</script>
@endsection
