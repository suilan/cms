@extends('admin.template.main')
@section('content')
<div class="box">
	<div class="box-header with-border">
        <h3 class="box-title">
        </h3>

        <div class="box-tools pull-right">
        	@if( $downloads->status==0 )
            	<span class="label label-danger">Não Publicado</span>
            @else
            	<span class="label label-success">Publicado</span>
            @endif
        </div>
    </div>
    <div class="box-body">
	<h3 class="titulo">{{$downloads->titulo}}</h3>
	@if ( $downloads->arquivo )
	<img src="{{asset($downloads->arquivo) }}">
	@else
	<a href="{{$downloads->arquivo_url}}">Visualizar Arquivo</a>
	@endif
	    <div class="box-body">
        	{!!$downloads->conteudo!!}
	    </div>

    </div>
        <!-- /.box-body -->
</div>
@endsection
