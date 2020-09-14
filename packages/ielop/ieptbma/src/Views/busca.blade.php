@extends('ieptbma::template.main')
@section('content')
<div class="breadcrumb">
    <ul>
        <li><a href="">Home</a></li>
        <li>Busca</li>
    </ul>
</div>
<h2 class="titulo">Resultado da Busca</h2>
<script>
  (function() {
    var cx = '004770548015883505955:uftve5ofsao';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:searchresults-only>Carregando...</gcse:searchresults-only>
@stop