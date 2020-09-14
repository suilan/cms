</body>

<script src="{{url('ieptbma/js/pdf.js')}}"></script>
<script src="{{url('ieptbma/js/text_layer_builder.js')}}"></script>
<script src="{{url('ieptbma/js/jornal.js')}}"></script>
<script src="{{url('ieptbma/js/moment.js')}}"></script>
<script src="{{url('ieptbma/js/mask.js')}}"></script>

<script>
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'],
                mask = (cpf.length > 14) ? masks[1] : masks[0];
            el.mask(mask, op);
        }
    }

    $('#documento').mask('000.000.000-000', options);
</script>

</html>