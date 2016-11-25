$(function () {
    $('.fipe').mask('999999-9')




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

})
/**
 * Created by uriel on 23/11/16.
 */
