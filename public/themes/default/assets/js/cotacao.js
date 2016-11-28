$(function () {
    var mask_cpfcnpj
    $('.fipe').mask('999999-9')

    $('.cpfcnpj').on('focusin', function () {
        $(this).unmask()
        var key = $.Event('keyup')
        key.which = 8
        $(this).trigger(key)
    }).keyup(function (event) {

        if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
            event.preventDefault();
        }

        $(this).unmask(mask_cpfcnpj);


        var tamanho = $(this).val().length;
        // console.log(tamanho)
        if (tamanho <= 11) {
            $(this).mask("999.999.999-999");
            mask_cpfcnpj = "999.999.999-999";

        } else {
            mask_cpfcnpj = "99.999.999/9999-99";

            $(this).mask("99.999.999/9999-99");
        }
    });

    $('#search-fipe').on('click', function () {
        var input = $($(this).attr('data-target'))
        var fipe = input.val()
        var dados = {"fipe": fipe}
        var url = $(this).attr('href')
        var veiculo = $(input.attr('data-veiculo'))

        $.ajax({
            data: dados,
            url: url,
            dataType: "json",
            type: 'GET',
            success: function (retorno) {


                if (retorno.status) {
                    veiculo.val(retorno.marca + ' - ' + retorno.modelo + ' (' + retorno.preiodo + ')')
                    $.reusltAutoComplete(retorno.codefipe)
                }

            }
        })

    })
    
    if($('.fipe').val() != ''){
        $('#search-fipe').trigger('click')
        var key = $.Event('keyup')
        key.which = 8
        $('.cpfcnpj').trigger(key)
    }

    $('input[name="renova"]').on('change', function () {

        $('#valortotal').trigger('change')

        $('select[name="anomodelo"]').trigger('change')
    })
    
    

})
/**
 * Created by uriel on 23/11/16.
 */
