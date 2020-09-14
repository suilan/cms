@extends('admin.template.main')
@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
        {{$carousel->titulo}}
<!--         <h3 class="box-title">
        	<strong>Data:</strong> {{date('d/m/Y',strtotime($carousel->created_at))}} - <strong>Usuário:</strong> {{$user->name}}
        </h3> -->

        <div class="box-tools pull-right">
            Criado em: <strong>{{date('d/m/Y',strtotime($carousel->created_at))}}</strong> - Criado por: <strong>{{$user->name}}</strong> - Status:
        	@if( $carousel->status==0 )
            	<span class="label label-danger">Rascunho</span>
            @else
            	<span class="label label-success">Publicado</span>
            @endif
        </div>
    </div>
    <div class="box-body" style="background-color: rgb(0, 153, 186);">
        <a href="{{$carousel->link?$carousel->link:'#'}}">
        	@if ( $carousel->imagem_url != "" )
        	<a href="{!! url($carousel->imagem_url) !!}"> Visualizar Arquivo</a>
        	@else
        	<img src="{!! url($carousel->imagem) !!}" width="100%">
        	@endif
        </a>
    </div>
        <!-- /.box-body -->
</div>
@endsection
