$(function () {
    var produtos = $('#produtos');
    var panelprodutos = $('#panelprodutos');
    var divano = $('#divano');
    var dadosveiculos = $('#dadosveiculos');
    var btnproposta = $('#btnproposta');
    var panelsegurado = $('#panelsegurado');
    var panelproprietario = $('#panelproprietario');
    var panelcondutor = $('#panelcondutor');
    var pergunta = $('#pergunta');
    var produtopagamento = $('#produtopagamento');
    var btnsubmit = $('#btnsubmit');
    var panelpagamento = $('#panelpagamento');
    var dadoscartao = $('#dadoscartao');
    var juridica1 = $('#juridica1');
    var ramoatividade = $('#ramoatividade');

    juridica1.hide();
    ramoatividade.hide();

    divano.hide();
    panelpagamento.hide();
    dadoscartao.hide();
    btnsubmit.hide();
    btnproposta.hide();
    pergunta.hide();
    produtopagamento.hide();
    dadosveiculos.hide();
    panelprodutos.hide();
    panelsegurado.hide();
    panelcondutor.hide();
    panelproprietario.hide();

    var data = new Date();

    function setDateP(idinput) {

        return $(idinput).datepicker({
            dateFormat: 'dd-mm-yy',
            closeText: "Fechar",
            prevText: "&#x3C;Anterior",
            nextText: "Próximo&#x3E;",
            currentText: "Hoje",
            monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            weekHeader: "Sm",
            altField: idinput,
            firstDay: 1,
            changeYear: true});

    }
    ;
    function aplicaComissao(valor, comissao) {
        valor = parseFloat(valor);
        comissao = parseInt(comissao);
        if (comissao > 0) {
            comissao = 1 - comissao / 100;
            valor =  valor / comissao;
            return valor.toFixed(2);
        } else {
            return valor.toFixed(2);
        }
    }
    ;

    setDateP('input[name=segdatanasc]');
    setDateP('input[name=segrgdtemissao]');
    setDateP('input[name=segdatafund]');





    $.widget("custom.marcacomplete", $.ui.autocomplete, {
        _create: function () {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function (ul, items) {
            var that = this,
                    currentCategory = "";
            $.each(items, function (index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });




    $('#veiculo').marcacomplete({
        delay: 0,
        source: '../modelo',
        select: function (event, ui) {
            $('#codefip-value').val(ui.item.id);
            $('#codefip-text').text(ui.item.id);
            divano.fadeIn("slow");


            $.get("../anovalor/",
                    {cdfipe: ui.item.id},
            // Carregamos o resultado acima para o campo modelo
                    function (valor) {
                        $("select[name=anom]").html(valor);
                    }
            )

            $.get("../anofab/",
                    {cdfipe: ui.item.id},
            // Carregamos o resultado acima para o campo modelo
                    function (valor) {
                        $("select[name=anof]").html(valor);
                    }
            )

        }
    });

    $('#segprofissao').autocomplete({
        delay: 0,
        source: '../profissao',
        select: function (event, ui) {
            $('#segcdprofissao').val(ui.item.id);

        }
    });
    $('#segramoatividade').autocomplete({
        delay: 0,
        source: '../ramoatividade',
        select: function (event, ui) {
            $('#segcdramoatividade').val(ui.item.id);

        }
    });



    $('#btnvender').on('click', function () {


        dadosveiculos.fadeIn("slow");
        panelsegurado.fadeIn("slow");
        pergunta.fadeIn("slow");
        btnsubmit.fadeIn("slow");
        $(this).fadeOut();

    });






    $("select[name=anom]").on('change', function () {
        var djson = $.parseJSON($("select[name=anom]").val());

        var dados = {comissao: $('#comissao').val(), cdfipe: $('input[name=codefipe]').val(), valor: djson.valor, ano: djson.ano, tipo: $('input[name=tipoveiculo]:checked').val()};

        $.ajax({
            data: dados,
            url: '../produtos',
            dataType: "json",
            type: 'GET',
            success: function (retorno) {
                produtos.empty();
//                produtos.hide();
                var vltotal = 0;

                $.each(retorno, function (key, value) {
                    $('#c-veiculo').removeClass("col-md-12");
                    $('#c-veiculo').addClass("col-md-9");
                    produtopagamento.fadeIn();
                    produtos.append(value.html);

                    $(value.acordion).accordion({
                        heightStyle: "content",
                        active: true,
                        collapsible: true,
                        header: 'h6'
                    });

                    if (value.chkid) {
                        $('#comissao').focusout(function(){
                            console.log($.parseJSON($(value.chkid).val()));
                            var valor = $.parseJSON($(value.chkid).val());
                            console.log(aplicaComissao(valor.vlproduto, $(this).val()))
                            $(value.precospan).text;
                        });
                    }

                    $(value.chkid).change(function () {

                        if ($(this).is(":checked")) {
                            var valor = $.parseJSON($(this).val());
                            vltotal += parseFloat(valor.vlproduto);
                            $('#valortotal').text('R$ ' + vltotal.toFixed(2).replace('.', ','));
                            panelpagamento.fadeIn();
                        } else {
                            var valor = $.parseJSON($(this).val());
                            vltotal -= parseFloat(valor.vlproduto);
                            if (vltotal < 1) {
                                panelpagamento.fadeOut();
                            } else {
                                $('#valortotal').text('R$ ' + vltotal.toFixed(2).replace('.', ','));
                                panelpagamento.fadeIn();
                            }

                        }

                        if (value.chkid == '#porduto1') {
                            if ($(this).is(":checked")) {
                                $('#divp4').fadeOut('fast');
                            } else {
                                $('#divp4').fadeIn('fast');
                            }

                        }
                    });
                });
                panelprodutos.fadeIn('slow');
                btnproposta.fadeIn('slow');



            }

        });

    });



    $('#segcep').focusout(function () {
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://viacep.com.br/ws/" + $(this).val() + "/json/",
            "method": "GET",
            "dataType": "jsonp",
        }

        $.ajax(settings).done(function (response) {
            console.log(response.logradouro);
            console.log(response);
        });
    });

    $('input:radio').change(function () {

        if ($(this).attr('name') == 'tipopessoa') {
            if ($(this).is(":checked") && $(this).attr('value') == 1) {
                juridica1.hide();
                ramoatividade.hide();
                $('#fisica1').fadeIn('fast');
                $('#fisica2').fadeIn('fast');
                $('#profissao').fadeIn('fast');
            } else {
                juridica1.fadeIn('fast');
                ramoatividade.fadeIn('fast');
                $('#fisica1').hide();
                $('#fisica2').hide();
                $('#profissao').hide();
            }
        } else if ($(this).attr('name') == 'proptipopessoa') {
            if ($(this).is(":checked") && $(this).attr('value') == 1) {
                $('#propripessoajuridica').hide();
                $('#propripessoafisca').fadeIn('fast');
            } else {
                $('#propripessoafisca').hide();
                $('#propripessoajuridica').fadeIn('fast');
            }
        } else if ($(this).attr('name') == 'indproprietario') {
            if ($(this).is(":checked") && $(this).attr('value') == 1) {
                panelproprietario.hide();
            } else {
                $('#propripessoajuridica').hide();
                panelproprietario.fadeIn('fast');
            }
        } else if ($(this).attr('name') == 'indcondutor') {
            if ($(this).is(":checked") && $(this).attr('value') == 1) {
                panelcondutor.hide();
            } else {
                panelcondutor.fadeIn('fast');
            }
        } else if ($(this).attr('name') == 'formapagamento') {
            var values = $.parseJSON($(this).attr('value'));
            if ($(this).is(":checked") && values.idforma == 1) {
                dadoscartao.fadeIn();
            } else {
                dadoscartao.fadeOut('fast');
            }
        }


    });
});

