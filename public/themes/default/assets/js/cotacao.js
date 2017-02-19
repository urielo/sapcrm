$(function () {
    $('.fipe').mask('999999-9');

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

    });
    
    if($('.fipe').val() != ''){
        $('#search-fipe').trigger('click');
    }

    $('input[name="renova"]').on('change', function () {

        $('#valortotal').trigger('change');


        if($('select[name="anomodelo"]').val() != 1){
            $('select[name="anomodelo"]').trigger('change');
            
        }
    })
    
    

});
/**
 * Created by uriel on 23/11/16.
 */
