@extends('admin.template.main')
@section('content')
<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>

    <div class="error-content">
      	<h3><i class="fa fa-warning text-yellow"></i> Oops! Página não encontrada.</h3>

		<p>
		Não conseguimos achar a página que você está procurando.
		Enquanto isso, você poderia <a href="{{url('admin')}}">retornar para o Sistema de Alimentação do Site</a> <!-- or try using the search form. -->
		</p>

		<!-- <form class="search-form">
			<div class="input-group">
				<input type="text" name="search" class="form-control" placeholder="Search">

				<div class="input-group-btn">
					<button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		 /.input-group
		</form> -->
    </div>
    <!-- /.error-content -->
</div>
@stop
