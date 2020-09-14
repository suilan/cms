<script src="{{url('default/js/jquery-3.2.0.min.js')}}"></script>
<script src="{{url('ieptbma/js/remodal.js')}}"></script>
<script src="{{url('ieptbma/js/jquery.inputmask.js')}}"></script>
<script src="{{url('ieptbma/js/inputmask.js')}}"></script>

<script type="text/javascript">
    var rootURL = "{{url('')}}";
    $('.bt-busca').click(function(event) {
        event.preventDefault();
        $('.nav').addClass('show-busca');
        $('.input-busca').focus();
    });
    $('.bt-fechar-busca').click(function(event) {
        event.preventDefault();
        $('.input-busca').blur();
        $('.nav').removeClass('show-busca');
    });
    $('.nav-sub').hover(function() {
        $(this).addClass('show');
    }, function() {
        $(this).removeClass('show');
    });
</script>

<!-- Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-xxxxxxxxxx-1', 'auto');
    ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
