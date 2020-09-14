@extends('admin.template.main')
@section('content')
<div class="row">
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box box-header">
            <?php 
                $user = Auth::user();
                if( $user->papel_id==2 ){ 
            ?>
                <form action="{{url('admin/segundavia/')}}" id="form_remessa" method="post" enctype="multipart/form-data" style="float: left;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <label for='remessas'>
                        Selecione um arquivo para atualizar a base de dados dos boletos
                    </label>
                    <input id='remessa' name="remessa" type='file'>
                </form>
            <?php } else if ($creden == null) { ?>
                <div class="alert alert-warning" style="margin-left: 10px; margin-right: 10px; margin-bottom: 10px;">
                    Caso você seja representante de alguma empresa. Cadastre <strong><a href="{{ url('admin/representante') }}">Aqui</a></strong> para acompanhar as intimações.
                </div>
            <?php } ?>
        </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
	@if( sizeof($remessaboleto)>0 )
      <table class="table">
        <tbody>
            <tr>
                <th>Nome do arquivo</th>
                <th>Data da remessa</th>
                <th>Cartório</th>
                <th>Quantidade de títulos</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
	<?php foreach ($remessaboleto as $key => $value): ?>
        <tr>
            <td>{{ $value->nome_arquivo }}</td>
            <td>{{ date('d/m/Y',strtotime($value->data_remessa)) }}</td>
            <td>{{ $value->nome_cartorio }}</td>
            <td>{{ (int) $value->quantidade_remessa }}</td>
            <td>
                @if ($value->deteled_at != null)
                    <span class="label label-danger">Removido</span>
                @elsif ( $value->status!=0 )
                    <span class="label label-danger">Não Publicado</span>
                @else
                    <span class="label label-success">Publicado</span>
                @endif
            </td>
            <td>
                <a class="btn" target="_blank" href="{{url('admin/remessaboleto/'.$value->id)}}"><i style="font-size: 15px" class="fa fa-search"></i></a>
                <a class="btn" href="{{url('admin/remessaboleto/'.$value->id).'/edit'}}"><i style="font-size: 15px" class="fa fa-edit"></i></a>
                <a class="btn" href="{{url('admin/remessaboleto/'.$value->id)}}" data-method="delete" 
                data-token="{{csrf_token()}}" data-confirm="Você deseja realmente excluir este registro?">
                <i style="font-size: 15px" class="fa fa-trash"></i>
                </a>

            </td>
	<?php  endforeach; ?>
        </tr>
      </tbody>
   </table>
        @else
        Nenhum registro encontrado.
        @endif

    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix" style="text-align: center">
        @if( Input::get('pesquisar') )
        {!! $remessaboleto->appends(['pesquisar' => Input::get('pesquisar')])->render() !!}
	@else
        {!! $remessaboleto->render() !!}
        @endif
       
    </div>
  </div>
  <!-- /.box -->
</div>

<script type="text/javascript">
    document.getElementById("remessa").onchange = function() {
        document.getElementById("form_remessa").submit();
    };
</script>

@endsection
