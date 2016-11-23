$(function () {
    $('input:radio[name="formapagamento"]').on('change', function () {
        var radio = $(this)

        $('.quant-parcelas').each(function () {
            var quant = $(this)
            var data_target
            if (quant.hasClass('hide')) {
                quant.removeClass('hide')
                data_target = radio.attr('data-target')
            } else {
                quant.addClass('hide')
            }

            $('input:radio[name="quant_parcela"]').each(function () {
                var parcela = $(this)
                var value = $('input:radio[name="quant_parcela"]:checked').val()



                if(parcela.attr('data-name') == data_target && parcela.val() == value){
                    parcela.prop('checked', true)
                }
            })
        })

        $('.dados-forma-pagamento').each(function () {
            var dados_forma = $(this)

            if (dados_forma.hasClass('hide')) {
                dados_forma.removeClass('hide')

            } else {
                dados_forma.addClass('hide')
            }

        })



    })

    $('#search-placa').on('click', function () {
        var input = $($(this).attr('data-target'))
        var placa = input.val().replace('-', '')
        var dados = {"placa": placa}
        var url = $(this).attr('href')

        var chassi = $(input.attr('data-target-chassi'))
        var renavan = $(input.attr('data-target-renavan'))
        var municipio = $(input.attr('data-target-municipio'))
        var ufplaca = $(input.attr('data-target-uf'))
        var anorevav = $(input.attr('data-target-anorenav'))
        var cor = $(input.attr('data-target-cor'))


        $.ajax({
            data: dados,
            url: url,
            dataType: "json",
            type: 'GET',
            success: function (retorno) {
                // var debug = retorno

                if (retorno.status) {
                    chassi.val(retorno.chassi)
                    renavan.val(retorno.renavan)
                    municipio.val(retorno.municipio)
                    ufplaca.val(retorno.uf)
                    cor.val(retorno.cor)

                }
                // console.log(debug)
            }
        })

    })
    $('#search-fipe').on('click', function () {
        var input = $($(this).attr('data-target'))
        var fipe = input.val()
        var dados = {"fipe": fipe}
        var url = $(this).attr('href')

        var veiculo = $(input.attr('data-veiculo'))

        if (fipe == '') {
            return false
        } else {
            $.ajax({
                data: dados,
                url: url,
                dataType: "json",
                type: 'GET',
                success: function (retorno) {
                    // var debug = retorno

                    if (retorno.status) {
                        veiculo.val(retorno.marca + ' - ' + retorno.modelo + ' (' + retorno.preiodo + ')')
                        reusltAutoComplete(retorno.codefipe)
                    }
                    // console.log(debug)
                }
            })
        }


    })



    if($('.cpfcnpj').val().length > 11){
        $('.cpfcnpj').mask("99.999.999/9999-99");
    } else {
        $('.cpfcnpj').mask("999.999.999-99")
    }

    $('.ddd').mask("99")
    $('.cel').mask("9 9999-9999")
    $('.fixo').mask("9999-9999")


    $('.input-group.date.nascimento').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        orientation: "auto",
        endDate: "+Infinity",
        autoclose: true
    })
    
    $('.input-group.date.vencimento').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        orientation: "auto",
        startDate: "-Infinity",
        autoclose: true
    })
    $('.input-group.date.dia').datepicker({
        format: "dd",
        language: "pt-BR",
        orientation: "auto",
        startView: 0,
        minViewMode: 0,
        autoclose: true
    })
    
    $('.input-group.date.validade').datepicker({
        format: "mm/yyyy",
        language: "pt-BR",
        orientation: "auto",
        startView: 1,
        minViewMode: 1,
        startDate: "-Infinity",
        autoclose: true
    })

    
        $('input.cep').mask('99999-999')
        $('button.cep').on('click',function () {
            var input =  $('input.cep ');

            var cep = (input.val()).replace('-', '')
            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://viacep.com.br/ws/" + cep + "/json/",
                "method": "GET",
                "dataType": "jsonp",
            }

            var logradouro = $(input.attr('data-target-logradouro'))
            var bairro = $(input.attr('data-target-bairro'))
            var cidade = $(input.attr('data-target-cidade'))
            var ufs = $(input.attr('data-target-uf') + 'option')
            var uf = $(input.attr('data-target-uf'))


            $.ajax(settings).done(function (response) {


                $.each(ufs, function (key, value) {
                    if (response.uf == value.id) {
                        uf.val(value.value);
                    }
                });
                logradouro.val(response.logradouro);
                bairro.val(response.bairro);
                cidade.val(response.localidade);

            });


        })

    if( $('input.cep').val() != ''){
        $('button.cep').trigger('click')
    }

    $('select[name="ind_propritetario"]').on('change',function () {
        var ind_proprietario = $(this)
       
        $('.dados-proprietario').each(function () {
            var dados_prop = $(this)
            
            if(ind_proprietario.val() == 0 && !dados_prop.hasClass('hide')){
                dados_prop.addClass('hide')
                
            } else if(ind_proprietario.val() == 1 && dados_prop.hasClass('hide')){
                dados_prop.removeClass('hide')

            }
        })
    })

})
/**
 * Created by uriel on 21/11/16.
 */
