/**
 * Jornal
 *
 * @type {{init}}
 */
const Jornal = (() => {

    /**
     * Button handling
     */
    const handleCalendar = () => {

        $('#calendar').datepicker({
            format         : 'dd/mm/yyyy',
            todayHighlight : true,
            language       : 'pt-BR',
            startDate      : '01/08/2017',
            endDate        : '+1 day',
        }).on('changeDate', function () {
            let date = moment($('#calendar').datepicker('getDate')).format('DD/MM/YYYY');

            if (date) {
                $('#edicao-jornal').removeClass('hide');
                $('.data-edicao').text('EdiÃ§Ã£o ' + date);
            }
        });
    };

    /**
     * Handle data tables
     */
    const handleTable = () => {
        $(document).on('change', '#listaDatas', function () {
            $('#dataTable').zfTable('', {
                sendAdditionalParams : function () {
                    return '&data=' + $('#listaDatas').find('option:selected').text();
                },
            });
        });

        $('#listaDatas').trigger('change');
    };

    /**
     * Load PDF
     *
     * @return void
     */
    const loadPdf = (file) => {

        let $object = $(document.createElement('iframe'));
        
        $object.attr({
            src    : `${file}`,
            width  : '100%',
            height : '1240px',
        });

        $('#ajax-content').html($object).css({
            'margin-top' : '0px',
        });
    };

    /**
     * Handle buttons
     *
     * @return void
     */
    const handleButtons = () => {

        $(document).on('click', '#visualizar-pdf', function (e) {
            e.preventDefault();
            const data = moment($('#calendar').datepicker('getDate')).format('YYYYMMDD');
            loadPdf(data);
        });

        $(document).on('click', '#download-pdf', function (e) {
            e.preventDefault();

            const data = moment($('#calendar').datepicker('getDate')).format('YYYY-MM-DD');
            const url  = `/publicacao/download?data=${data}`;
            window.open(url);
        });
    };

    /**
     * Handle buttons
     *
     * @return void
     */
    const handleConsulta = () => {

        let getDocumentoFormatado = (doc) => {
            return doc.length === 14 ? `CPF (${doc})` : `CNPJ (${doc})`;
        };

        let $documento = $('#documento');
        let $validacao = $('#validacao');
        $documento.maskDocumento();
        let $spin = $('#consulta-spin');

        $spin.removeClass();

        $(document).on('click', '#btn-consultar', function (e) {
            $spin.removeClass();
            $spin.addClass('fa fa-spinner fa-spin').show();
            $validacao.text('');

            let response  = grecaptcha.getResponse();
            let documento = $documento.val();

            if (documento === '') {
                $validacao.text('Informe um documento para realizar a consulta').addClass('text-danger');
                $spin.removeClass().addClass('fa fa-exclamation-circle animated bounceIn font-red text-danger');
                return;
            }

            let ajax = $.ajax({
                'method'     : 'POST',
                'url'        : '/consulta',
                'data'       : {
                    'documento' : documento,
                    'recaptcha' : response,
                },
                'beforeSend' : () => $(this).attr('disabled', true),
            });

            ajax.always(() => $spin.removeClass().addClass('fa fa-check-circle animated bounceIn text-success'));

            ajax.done(data => {
                if (data.erro === 1) {
                    $validacao.text(data.message).addClass('text-danger');
                    $spin.removeClass().addClass('fa fa-exclamation-circle  animated bounceIn font-red text-danger');
                } else if (data.erro === 2) {
                    grecaptcha.reset();
                    $spin.removeClass().addClass('fa fa-exclamation-triangle animated bounceIn text-warning');
                    $('#consulta-resultado').html('');
                    $('#consulta-mensagem').html(`RESULTADO DA PESQUISA PARA O  ${getDocumentoFormatado(documento)} REALIZADA EM ${moment().format('DD/MM/YYYY [Ã€S] HH:mm')} 
                        <hr class="custom-divider">
                        <h4>NÃ£o foram encontradas intimaÃ§Ãµes por edital do ${getDocumentoFormatado(documento)} pesquisado. <br/></h4>`,
                    );
                } else if (data.erro === 3) {
                    $validacao.text(data.message).addClass('text-danger');
                    $spin.removeClass().addClass('fa fa-exclamation-circle  animated bounceIn font-red text-danger');
                } else {
                    grecaptcha.reset();
                    $('#consulta-mensagem').text(`RESULTADO DA PESQUISA PARA O  ${getDocumentoFormatado(documento)} REALIZADA EM ${moment().format('DD/MM/YYYY [Ã€S] HH:mm')}`);
                    $('#consulta-resultado').html(data);
                }
            });

            ajax.always(() => $(this).removeAttr('disabled'));
        });

    };

    /**
     * Handle modal
     */
    const handleModal = () => {
        $('#modalFraude').modal();
    };

    return {
        init     : () => {
            handleCalendar();
            handleTable();
            handleModal();
            handleButtons();

        },
        consulta : () => {
            handleConsulta();
        },
        loadPdf  : (pdfData) => loadPdf(pdfData),
    };
})();