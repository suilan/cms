@include('ieptbma::jornal.head')
<div class="container">
    <h3 class="my-4 text-center text-lg-left">Edições do Jornal do <strong style="color: #0084b2">Protesto MA</strong></h3>
    <div class="row text-center text-lg-left">
        @foreach( $downloads as $k=>$r )
            <div class="col-lg-3 col-md-4 col-xs-6">
                <a href="{{url('jornaldoprotestoma/'.$r->id)}}" class="d-block mb-4 h-100 text-center">
                    <img class="img-fluid img-thumbnail" src="http://www.arim.com.br/wp-content/themes/arim/assets/images/icones/ico-noticia.png" alt="" style="border: none">
                    <h6 style="margin-top: 6px; color: #0084b2"><small class="text_center">{{$r->titulo}} - {{$r->data_postagem}}</small></h6>
                </a>
            </div>
        @endforeach
    </div>
</div>
<div class = "pagination_list">
    {{ $downloads->links() }}
</div>
@include('ieptbma::jornal.footer')