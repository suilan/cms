@include('ieptbma::jornal.head')
<div class="container col-lg-12">
    <div class="row">
        <div class="container-fluid" style="padding: 0;">
            <div id="ajax-content">
                <p>&nbsp;</p>
                <script>
                    $(document).ready(() => {
                        Jornal.loadPdf('{{url('')}}/ieptbma/visualizador/web/viewer.html?file={{ url('').$downloads->arquivo}}');
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@include('ieptbma::jornal.footer')