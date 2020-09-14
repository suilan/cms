@if (count($errors) > 0)
    <div class="alert alert-danger">
       <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if( Session::get('sucesso') )
    <div class="alert alert-info">Seus dados foram salvos com sucesso!</div>
@endif

@if( Session::get('aceite') )
    <div class="alert alert-success">Aceite realizado com sucesso!</div>
@endif