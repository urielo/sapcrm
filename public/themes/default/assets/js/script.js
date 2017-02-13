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
    var produtopagamento = $('.produto-pagamento');
    var btnsubmit = $('#btnsubmit');
    var panelpagamento = $('#panelpagamento');
    var dadoscartao = $('#dadoscartao');
    var juridica1 = $('#juridica1');
    var diverror = $('#diverror');
    var ramoatividade = $('#ramoatividade');
    var vltotal = 0;
    var produtosvalores = [];
    var menorparc = 0.0;
    var comissao_valor = 0.0;
    var mask_cpfcnpj

    function addCommas(nStr) {
        nStr
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    var dados_produtos

    diverror.removeClass('hide');
    divano.removeClass('hide');
    panelsegurado.removeClass('hide');
    dadosveiculos.removeClass('hide');
    dadoscartao.removeClass('hide');
    produtopagamento.removeClass('hide');
    panelpagamento.removeClass('hide');
    produtos.removeClass('hide');
    panelproprietario.removeClass('hide');
    panelcondutor.removeClass('hide');
    pergunta.removeClass('hide');

    btnproposta.removeClass('hide');

    produtopagamento.hide();
    diverror.hide();
    pergunta.hide();
    panelsegurado.hide();
    juridica1.hide();
    ramoatividade.hide();
    divano.hide();
    dadoscartao.hide();
    btnsubmit.hide();
    panelpagamento.hide();
    panelprodutos.hide();
    btnproposta.hide();
    dadosveiculos.hide();
    panelcondutor.hide();
    panelproprietario.hide();


    var produto_master = false;
    var produto_opcional = false;

    var set_parcelas = function () {

        var parcelas = [];
        $('meta').each(function () {
            if ($(this).attr('name') == 'forma-pagamento') {
                parcelas_obg = gerarParcelas(vltotal, $(this).attr('data-maxparcela'), $(this).attr('data-parce-sem-juros'), $(this).attr('data-juros'), menorparc, $(this).attr('id-forma'), $('input[name="renova"]:checked').val())
                var html_parcelas = ''

                $.each(parcelas_obg, function (key, value) {
                    var quant_demais = value.quantidade - 1
                    html_parcelas = html_parcelas + '<tr>' +
                        '<td>' + value.quantidade + 'x</td>' +
                        '<td>' + (value.primeira != value.demais ? '1x de R$ ' + value.primeira + ' e ' + quant_demais + 'x de R$ '
                        + value.demais : 'R$ ' + value.primeira ) + '</td>' +
                        '<td>' + value.juros + '%</td>' +
                        '<td>R$ ' + value.valorfinal + '</td>' +
                        '</tr>'

                })
                parcelas.push({
                    'id_forma': $(this).attr('id-forma'),
                    'parcelas': html_parcelas
                })
            }
        })


        $('.formas_pagamento').each(function () {
            var id_forma = $(this).attr('id-forma')
            var target = $(this).attr('data-target') + ' tbody';
            $.each(parcelas, function (key, value) {
                if (id_forma == value.id_forma) {
                    $(target).html(value.parcelas)
                }


            })
            // console.log(parseInt($(this).attr('data-target')))

        })
    }


    $(document).ready(function () {
        $('#body').removeClass('blur')
        $('.bgloading').fadeOut()

    });

    $(document).ajaxStart(function () {
        $('.bgloading').fadeIn()
        $('#body').addClass('blur')
        $('.modal-content').prepend('<div class="bgloading" id="loading"></div>')
    });

    $(document).ajaxStop(function () {
        $('.bgloading').fadeOut()
        $('#body').removeClass('blur')
        $('.modal-content .bgloading').remove()
    });


    $('#body-panel').height($(window).height() - 130);
    var ttable = $(window).height() - 280;
    $(window).resize(function () {
        $('#body-panel').height($(window).height() - 125);
        ttable = $(window).height() - 250;
    });
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

    $.apllyFilters = function () {


        $(".selectpicker").selectpicker();


        $('input.cep').mask('99999-999')


        $('.date-virgencia').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            language: "pt-BR",
            orientation: "auto"
        });

        buscaCep('#segcep', '#segenduf', '#segendlog', '#segendcidade');
        buscaCep('#propcep', '#propenduf', '#propendlog', '#propendcidade');
        buscaCep('#cep', '#uf', '#logradouro', '#cidade');

        $('#veiculo').marcacomplete({

            delay: 0,
            source: function (request, response) {
                $.getJSON(
                    $('#veiculo').attr('data-url'),
                    {tipoveiculo: $('select[name="tipoveiculo"]').val(), term: request.term},
                    response);
            },
            select: function (event, ui) {

                $('input:checkbox').each(function () {
                    if ($(this).attr('name') == 'produtos[]' && $(this).is(':checked')) {
                        $(this).removeAttr('checked')
                        $(this).trigger('change')

                    }
                })
                produtos.empty();
                btnproposta.hide();
                panelprodutos.hide();
                // produtosvalores = [];
                // $('#valortotal').trigger('change');
                reusltAutoComplete(ui.item.id);


            }
        });

        $('#segprofissao').autocomplete({
            delay: 0,
            source: geturl() + 'profissao',
            select: function (event, ui) {
                $('#segcdprofissao').val(ui.item.id);

            }
        });
        $('#segramoatividade').autocomplete({
            delay: 0,
            source: geturl() + 'ramoatividade',
            select: function (event, ui) {
                $('#segcdramoatividade').val(ui.item.id);

            }
        });
        $('.input-group.date').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            language: "pt-BR",
            orientation: "auto",
            endDate: "+Infinity",
            autoclose: true
        });

        $(':input').each(function () {

            if ($(this).attr('tipoinput') == 'cpf' && $(this).attr('stats')) {
                $(this).attr('placeholder', '999.999.999-00');
                $(this).mask('999.999.999-99');

                var idmsg = 'msg' + $(this).attr('id');
                var pessoa = $(this).attr('pessoa');

                $(this).focusout(function () {
                    var value = $(this).val();
                    if (!validate_cpf($(this).val()) && value.length > 0) {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                        $(this).after(menssageError('CPF: Invalido', idmsg))
                        $(this).focus();
                    } else if (validate_cpf($(this).val())) {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                        value = value.replace('.', '');
                        value = value.replace('.', '');
                        value = value.replace('-', '');
                        var dados = {'cpfcnpj': value, 'elemento': pessoa, 'tipo': $('#tipopessoa').val()}

                        $.ajax({
                            data: dados,
                            url: geturl() + 'complete',
                            dataType: "json",
                            type: 'GET',
                            success: function (retorno) {
                                if (retorno.status) {

                                    $.each(retorno, function (key, value) {

                                        $('#' + key).val(value)
                                        $('#' + key).trigger('focusout')

                                    })
                                } else {
                                    return false
                                }

                            },
                            error: function (retorno) {
                                console.log(retorno);
                                console.log('error');
                            }
                        });

                    } else {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                    }
                });

                $(this).removeAttr('stats')


            } else if ($(this).attr('tipoinput') == 'cnpj' && $(this).attr('stats')) {
                $(this).attr('placeholder', '99.999.999/9999-00');
                $(this).mask('99.999.999/9999-00');

                var idmsg = 'msg' + $(this).attr('id');
                $(this).focusout(function () {
                    var value = $(this).val();
                    if (!validate_cnpj($(this).val()) && value.length > 0) {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                        $(this).after(menssageError('CNPJ: Invalido', idmsg))
                        $(this).focus();
                    } else if (validate_cnpj($(this).val())) {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                        value = value.replace('.', '');
                        value = value.replace('.', '');
                        value = value.replace('-', '');
                        value = value.replace('/', '');

                        var dados = {'cpfcnpj': value, 'elemento': pessoa, 'tipo': $('#tipopessoa').val()}

                        $.ajax({
                            data: dados,
                            url: geturl() + 'complete',
                            dataType: "json",
                            type: 'GET',
                            success: function (retorno) {
                                if (retorno.status) {

                                    $.each(retorno, function (key, value) {

                                        $('#' + key).val(value)
                                        $('#' + key).trigger('focusout')

                                    })
                                } else {
                                    return false
                                }

                            },
                            error: function (retorno) {
                                console.log(retorno);
                                console.log('error');
                            }
                        });
                    } else {
                        ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                    }
                });

                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == 'cpfcnpj' && $(this).attr('stats')) {
                $(this).attr('placeholder', 'CPF ou CNPJ');
                // $(this).mask('99.999.999/9999-00');

                $(this).keyup(function () {
                    var val = $(this).val();

                    $(this).unmask();

                    if (val.length < 15 && val.length > 3) {
                        $(this).unmask();
                        $(this).mask('999.999.999-999');
                    } else {
                        $(this).unmask();
                        $(this).mask('99.999.999/9999-00');
                    }

                })


                var idmsg = 'msg-' + $(this).attr('id');
                $(this).focusout(function () {
                    $(this).trigger('keyup')
                    var val = $(this).val();

                    if (val.length > 2) {

                        var value = $(this).cleanVal();
                        if (value.length > 11) {
                            if (!validate_cnpj($(this).val()) && value.length > 0) {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                                $(this).after(menssageError('CNPJ: Invalido', idmsg))
                                $(this).focus();
                                return false;
                            } else if (validate_cnpj($(this).val())) {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '');


                            } else {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                            }
                        } else {
                            if (!validate_cpf($(this).val()) && value.length > 0) {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                                $(this).after(menssageError('CPF: Invalido', idmsg))
                                $(this).focus();
                                return false
                            } else if (validate_cnpj($(this).val())) {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '')


                            } else {
                                ($('#' + idmsg) ? $('#' + idmsg).remove() : '')
                            }
                        }
                    }


                });

                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "chassi" && $(this).attr('stats')) {
                $(this).attr('placeholder', '9AAAA99AA99999999');
                $(this).mask('XXXXXXXXXXXXXXXXX', {'translation': {X: {pattern: /[A-Za-z0-9]/}}})
                $(this).keyup(function () {
                    $(this).val($(this).val().toUpperCase())
                })
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "placa" && $(this).attr('stats')) {
                $(this).attr('placeholder', 'AAA-9999');
                $(this).mask('AAA-9999')

                $(this).keyup(function () {
                    $(this).val($(this).val().toUpperCase())
                })

                $(this).focusout(function () {
                    $(this).val($(this).val().toUpperCase())

                })

                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "ddd" && $(this).attr('stats')) {

                $(this).attr('placeholder', '99');
                $(this).mask('99')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "cel" && $(this).attr('stats')) {

                $(this).attr('placeholder', '99999-9999');
                $(this).mask('99999-9999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "fone" && $(this).attr('stats')) {

                $(this).attr('placeholder', '9999-9999');
                $(this).mask('9999-9999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "data-nascimento" && $(this).attr('stats')) {

                $(this).attr('placeholder', 'DD/MM/YYYY');
                setDateP('#' + $(this).attr('id'), 'nascimento')
                $(this).mask('99/99/9999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "data-normal" && $(this).attr('stats')) {

                $(this).attr('placeholder', 'DD/MM/YYYY');
                setDateP('#' + $(this).attr('id'), null)
                $(this).mask('99/99/9999')
                $(this).removeAttr('stats')

            } else if ($(this).attr('tipoinput') == "data-pagamento-boleto" && $(this).attr('stats')) {

                $(this).attr('placeholder', 'DD/MM/YYYY');
                setDateP('#' + $(this).attr('id'), 'pagamento-boleto')
                $(this).mask('99/99/9999')
                $(this).removeAttr('stats')

            } else if ($(this).attr('tipoinput') == "data-validade-cartao" && $(this).attr('stats')) {

                $(this).attr('placeholder', 'MM/YYYY');
                setDateP('#' + $(this).attr('id'), 'valcartao')
                $(this).mask('99/9999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "cep" && $(this).attr('stats')) {

                $(this).attr('placeholder', '00000-000');
                $(this).mask('99999-999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "renavan" && $(this).attr('stats')) {

                $(this).attr('placeholder', '00000000000');
                $(this).mask('99999999999')
                $(this).removeAttr('stats')
            } else if ($(this).attr('tipoinput') == "num-cartao" && $(this).attr('stats')) {

                $(this).attr('placeholder', '0000 0000 0000 0000');
                $(this).mask('9999 9999 9999 9999')
                $(this).removeAttr('stats')
            }
            // console.log($(this).attr('data'));
        });

        var d = new Date();
        $('#nnmcartao').mask('9999 9999 9999 9999');
        $('#cvvcartao').mask('999');


        $('#valcartao').datepicker({
            format: "mm/yyyy",
            startView: 1,
            startDate: "-",
            minViewMode: 1,
            language: "pt-BR",
            autoclose: true,
            defaultViewDate: {year: d.getFullYear(), month: d.getMonth()}
        });
        $('#dataprimeira').datepicker({
            format: "dd/mm/yyyy",
            startView: 0,
            language: "pt-BR",
            startDate: "-",
            autoclose: true,
            defaultViewDate: {year: d.getFullYear(), month: d.getMonth(), day: d.getDay()}
        });
        $('#datademais').datepicker({
            format: "dd",
            language: "pt-BR",
            autoclose: true,
            defaultViewDate: {year: d.getFullYear(), month: d.getMonth(), day: d.getDay()}
        });
        $(':input').each(function () {

            if ($(this).attr('tipoinput') == "data-pagamento-boleto") {

                $(this).attr('placeholder', 'DD/MM/YYYY');
                setDateP('#' + $(this).attr('id'), 'pagamento-boleto')
                $(this).mask('99/99/9999')

            }
        });


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

        $('.selectpicker').selectpicker('refresh');

        $('.ddd').mask("99");
        $('.cel').mask("9 9999-9999");
        $('.fixo').mask("9999-9999");
        $('.placa').mask("AAA-9999");


    }

    var table = $('.table-datatable').dataTable({
        language: {
            sEmptyTable: "Nenhum registro encontrado",
            sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
            sInfoFiltered: "(Filtrados de _MAX_ registros)",
            sInfoPostFix: "",
            sInfoThousands: ".",
            sLengthMenu: "_MENU_ resultados por página",
            sLoadingRecords: "Carregando...",
            sProcessing: "Processando...",
            sZeroRecords: "Nenhum registro encontrado",
            sSearch: "Pesquisar",
            oPaginate: {
                sNext: "Próximo",
                sPrevious: "Anterior",
                sFirst: "Primeiro",
                sLast: "Último"
            },
            oAria: {
                sSortAscending: ": Ordenar colunas de forma ascendente",
                sSortDescending: ": Ordenar colunas de forma descendente"
            }
        },
        "scrollY": ttable,
        "scrollCollapse": true,
        "destroy": true,
        "fnDestroy": false,
        "fnDraw": true,
        "lengthMenu": [50, 100, 150, 200]
    });

    $.apllyFilters();


    function jurosComposto(valor, taxa, parcelas) {
        taxa = taxa / 100;
        var potencia = valor * taxa * Math.pow((taxa + 1), parcelas) / (Math.pow((taxa + 1), parcelas) - 1);


        return potencia;
    }

    function setAnofab() {
        var anom = $.parseJSON($('select[name=anom]').val());
        $('#anof').empty();

        for (var i = anom.ano; i >= anom.ano - 1; i--) {
            $('#anof').append('<option value="' + i + '">' + i + '</option>')
        }
        // return console.log(anom.ano)
    }

    function setAnoRenav() {
        var anof = $('#anof').val()
        $('#anorenav').empty();
        var d = new Date();

        for (var i = d.getFullYear(); i >= anof; i--) {
            $('#anorenav').append('<option value="' + i + '">' + i + '</option>')
        }

    }


    function setDateP(idinput, tipo) {
        var d = new Date();

        if (tipo == 'nascimento') {

            return $(idinput).datepicker({

                format: "dd/mm/yyyy",
                maxViewMode: 0,
                clearBtn: true,
                endDate: "-Infinity",
                language: "pt-BR",
                orientation: "auto",
                // toggleActive: true,
                autoclose: true,
                defaultViewDate: {year: d.getFullYear() - 18, month: d.getMonth(), day: d.getDay() - 1}

            });
        } else if (tipo == 'pagamento') {

            return $(idinput).datepicker({
                format: "dd/mm/yyyy",
                startView: 0,
                language: "pt-BR",
                startDate: "-",
                autoclose: true,
                defaultViewDate: {year: d.getFullYear(), month: d.getMonth(), day: d.getDay()}
            });
        } else if (tipo == 'pagamento-boleto') {

            return $(idinput).datepicker({
                format: "dd/mm/yyyy",
                startView: 0,
                language: "pt-BR",
                autoclose: true,
                defaultViewDate: {year: d.getFullYear(), month: d.getMonth(), day: d.getDay()}
            });
        } else if (tipo == 'valcartao') {

            return $(idinput).datepicker({
                format: "mm/yyyy",
                startView: 1,
                startDate: "-",
                minViewMode: 1,
                language: "pt-BR",
                autoclose: true,
                defaultViewDate: {year: d.getFullYear(), month: d.getMonth()}
            });
        } else {
            return $(idinput).datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                language: "pt-BR",
                orientation: "auto",
                autoclose: true,
                toggleActive: true
            });
        }


    };


    function aplicaComissao(valor, comissao) {
        valor = parseFloat(valor);
        comissao = parseInt(comissao);
        if (comissao > 0) {
            comissao = 1 - comissao / 100;
            valor = valor / comissao;
            return valor.toFixed(2);
        } else {
            return valor.toFixed(2);
        }
    };
    function buscaCep(inputcep, inputuf, inputlogra, inputcidade) {
        $(inputcep).focusout(function () {
            var cep = ($(this).val()).replace('-', '')
            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://viacep.com.br/ws/" + cep + "/json/",
                "method": "GET",
                "dataType": "jsonp",
            }

            $.ajax(settings).done(function (response) {
                $.each($(inputuf + ' option'), function (key, value) {
                    if (response.uf == value.id) {
                        $(inputuf).val(value.value);
                    }
                });
                $(inputlogra).val(response.logradouro);
                $(inputcidade).val(response.localidade);

            });
        });
    };
    function gerarParcelas(vltotal, maxparc, parcelasemjuros, taxajuros, menorparc, formapg, renova) {

        maxparc = parseInt(maxparc)
        parcelasemjuros = parseInt(parcelasemjuros)
        formapg = parseInt(formapg)
        menorparc = parseFloat(menorparc)
        vltotal = parseFloat(vltotal)

        var retorno = [];
        // var porcentj = parseFloat(taxajuros) / 100


        for (var i = 1; i < maxparc + 1; i++) {
            var juros = vltotal + (vltotal * (taxajuros / 100));
            var priparcela = 0;
            var demparcela = 0;
            var vlfinal = 0;
            var textojuros = (i > parcelasemjuros) ? 'J.: ' + taxajuros.replace('.', ',') + '%' : 'S/J';
            var textojuroc = (i > parcelasemjuros) ? 'Juros: ' + taxajuros.replace('.', ',') + '%' : 'Sem juros';
            var juros_retorno = 0


            var parcjuros = jurosComposto(vltotal, taxajuros, i);


            if (i > parcelasemjuros && parcjuros < menorparc && formapg == 2 && renova == 0) {
                priparcela = menorparc;
                demparcela = ((parcjuros * i) - menorparc) / (i - 1);
                vlfinal = menorparc + demparcela * (i - 1);
                juros_retorno = taxajuros.replace('.', ',')

            } else if (i <= parcelasemjuros && vltotal / i < menorparc && formapg == 2 && renova == 0) {
                priparcela = menorparc;
                demparcela = (vltotal - menorparc) / (i - 1);
                vlfinal = menorparc + (demparcela * (i - 1));
            } else if (i > parcelasemjuros) {
                juros_retorno = taxajuros.replace('.', ',')
                priparcela = parcjuros;
                demparcela = priparcela;
                vlfinal = demparcela * i;

            } else {
                priparcela = vltotal / i;
                demparcela = priparcela;
                vlfinal = demparcela * i;
            }

            vlfinal = addCommas(vlfinal.toFixed(2));
            priparcela = addCommas(priparcela.toFixed(2));
            demparcela = addCommas(demparcela.toFixed(2));

            retorno.push(
                {
                    "valorfinal": vlfinal,
                    "quantidade": i,
                    "primeira": priparcela,
                    "demais": demparcela,
                    "juros": juros_retorno

                })


        }

        return retorno;
    };
    function geturl() {
        var url = location.href;
        url = url.split('/');
        url = url[0] + '//' + url[2] + '/' + 'ajax' + '/';
        return url;
    }

    function reusltAutoComplete(cdfipe) {
        $('#codefip-value').val(cdfipe);
        divano.fadeIn("slow");

        $.get(geturl() + "anovalor/",
            {cdfipe: cdfipe},
            // Carregamos o resultado acima para o campo modelo
            function (valor) {
                $("select[name=anomodelo]").html(valor).trigger('change');


            }
        )


    }

    $.reusltAutoComplete = function (cdfipe) {
        $('#codefip-value').val(cdfipe);
        divano.fadeIn("slow");

        $.get(geturl() + "anovalor/",
            {cdfipe: cdfipe},
            // Carregamos o resultado acima para o campo modelo
            function (valor) {
                $("select[name=anomodelo]").html(valor).trigger('change');


            }
        )


    }


    var remove_class = function () {

        if ($('.remove-class').hasClass($('.remove-class').attr('data-target'))) {
            $('.remove-class').removeClass($('.remove-class').attr('data-target'))
        }
    }

    function validate_cnpj(val) {

        if (val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
            var val1 = val.substring(0, 2);
            var val2 = val.substring(3, 6);
            var val3 = val.substring(7, 10);
            var val4 = val.substring(11, 15);
            var val5 = val.substring(16, 18);

            var i;
            var number;
            var result = true;

            number = (val1 + val2 + val3 + val4 + val5);

            s = number;

            c = s.substr(0, 12);
            var dv = s.substr(12, 2);
            var d1 = 0;

            for (i = 0; i < 12; i++)
                d1 += c.charAt(11 - i) * (2 + (i % 8));

            if (d1 == 0)
                result = false;

            d1 = 11 - (d1 % 11);

            if (d1 > 9) d1 = 0;

            if (dv.charAt(0) != d1)
                result = false;

            d1 *= 2;
            for (i = 0; i < 12; i++) {
                d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
            }

            d1 = 11 - (d1 % 11);
            if (d1 > 9) d1 = 0;

            if (dv.charAt(1) != d1)
                result = false;

            return result;
        }
        return false;
    }

    function validate_cpf(val) {

        if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
            var val1 = val.substring(0, 3);
            var val2 = val.substring(4, 7);
            var val3 = val.substring(8, 11);
            var val4 = val.substring(12, 14);

            var i;
            var number;
            var result = true;

            number = (val1 + val2 + val3 + val4);

            s = number;
            c = s.substr(0, 9);
            var dv = s.substr(9, 2);
            var d1 = 0;

            for (i = 0; i < 9; i++) {
                d1 += c.charAt(i) * (10 - i);
            }

            if (d1 == 0)
                result = false;

            d1 = 11 - (d1 % 11);
            if (d1 > 9) d1 = 0;

            if (dv.charAt(0) != d1)
                result = false;

            d1 *= 2;
            for (i = 0; i < 9; i++) {
                d1 += c.charAt(i) * (11 - i);
            }

            d1 = 11 - (d1 % 11);
            if (d1 > 9) d1 = 0;

            if (dv.charAt(1) != d1)
                result = false;

            return result;
        }

        return false;
    }


    if ($('select[name=comissao]')) {
        var commin = $('select[name=comissao] option:eq(1)').val();
        $('select[name=comissao] option:eq(1)').remove();
        for (var i = $('select[name=comissao]').val() - 1; i > commin - 1; i--) {

            $('select[name=comissao]').append('<option value="' + i + '">' + i + '</option>')
        }
    }


    var comissao_set = function () {
        $('#comissao').change(function () {

            var comissao = $(this).val();


            $('input:checkbox').each(function () {
                if ($(this).attr('name') == 'produtos[]') {
                    var valorcomiss = aplicaComissao($(this).attr('data-val-vlproduto'), comissao);
                    $($(this).attr('data-target-preco')).text(addCommas(valorcomiss));
                }
            })

            $('#valortotal').trigger('change');
            $('#valor-comissao').trigger('change');

        });
    }


    var opcionais = [];
    var change_produtos = function (input_id, tipo) {

        if (tipo == 'master') {
            // console.log($(input_id))

            return $(input_id).on('change', function () {

                var this_id = $(this).attr('data-target-div')
                var div = $('#produtos').children('div')
                var url = $(this).attr('href')
                var menor = $(this).attr('data-val-menorparc')
                var valor = {'valor': $(this).attr('data-val-vlproduto')}

                if ($(this).is(":checked")) {

                    $('#botton-cotacao').removeClass('hide')

                    $('meta[name="produto-master"]').attr('value', $(this).val())

                    $.each(div, function (key, value) {
                        var id = '#' + value.id
                        if (id != this_id) {

                            $($(id).attr('data-target')).removeAttr('checked').attr('disabled', true)
                            $(id).hide()

                        }
                    })
                    dados_produtos.idproduto = $(this).val()


                    $.get(url, dados_produtos, function (retorno) {
                        if (retorno.length !== 0) {
                            $.each(retorno, function (key, value) {
                                $('#produtosopcionais').append(value.html);
                            })
                            $('#panelprodutosopcional').show();
                            set_produtos()
                            $('#comissao').trigger('change');
                            $.apllyFilters();


                        }


                    }, 'json')


                    produtosvalores.push(valor);
                    menorparc += parseFloat((menor > 0) ? menor : 0);


                } else {
                    $('meta[name="produto-master"]').attr('value', '')
                    $('#botton-cotacao').addClass('hide')

                    $('#panelprodutosopcional').hide();
                    $('#produtosopcionais').empty();


                    (menorparc > 0) ? menorparc -= parseFloat((menor > 0) ? menor : 0) : menorparc;
                    if (vltotal != 0) {
                        produtosvalores = [];
                        menorparc = 0
                    }

                    $.each(div, function (key, value) {
                        var id = '#' + value.id
                        if (id != this_id) {
                            $($(id).attr('data-target')).attr('disabled', false)
                            $(id).show()
                        }
                    })
                }

                $('#valortotal').trigger('change');
                $('#valor-comissao').trigger('change');


            })
        } else if (tipo == 'opcional') {

            return $(input_id).on('change', function () {
                var this_id = $(this).attr('data-target-div')
                var div = $('#produtosopcionais').children('div')
                var menor = $(this).attr('data-val-menorparc')
                var valor = {'valor': $(this).attr('data-val-vlproduto')}
                var tipo_seguro = $(this).attr('data-val-tiposeguro')

                if ($(this).is(":checked")) {

                    if ($('meta[name="produto-opcionais"]').attr('value') != '') {
                        opcionais = $.parseJSON($('meta[name="produto-opcionais"]').attr('value'))
                    } else {
                        opcionais = [];
                    }

                    if (opcionais.indexOf($(this).val()) < 0) {
                        opcionais.push($(this).val())
                    }

                    $('meta[name="produto-opcionais"]').attr('value', JSON.stringify(opcionais))

                    if ($(this).attr('data-val-tipoproduto') == 'opcional') {
                        $.each(div, function (key, value) {
                            var id = '#' + value.id

                            if (id != this_id && tipo_seguro == $(id).attr('data-val-tiposeguro')) {

                                $($(id).attr('data-target')).removeAttr('checked').attr('disabled', true)
                                $(id).hide()

                            }
                        })

                        produtosvalores.push(valor);
                        menorparc += parseFloat((menor > 0) ? menor : 0);
                        $('#valortotal').trigger('change');

                    }


                } else {

                    if ($(this).attr('data-val-tipoproduto') == 'opcional') {


                        if ($.isArray(opcionais)) {
                            opcionais.splice(opcionais.indexOf($(this).val()), 1);
                        }


                        $('meta[name="produto-opcionais"]').attr('value', JSON.stringify(opcionais));


                        // console.log(produtosvalores)
                        (menorparc > 0) ? menorparc -= parseFloat((menor > 0) ? menor : 0) : menorparc;
                        if (vltotal !== 0) {
                            produtosvalores.splice(produtosvalores.indexOf(valor), 1);
                            $('#valortotal').trigger('change');
                        }

                        $.each(div, function (key, value) {
                            var id = '#' + value.id
                            if (id != this_id) {
                                $($(id).attr('data-target')).attr('disabled', false)
                                $(id).show()
                            }
                        });
                        $('#comissao').trigger('change');

                    }
                }

                $('#valortotal').trigger('change');
                $('#valor-comissao').trigger('change');
                $('#comissao').trigger('change');


            })


        }

    }


    var set_produtos = function () {
        $('input:checkbox').each(function () {
            if ($(this).attr('name') == 'produtos[]' && $(this).attr('data-set') == 0) {
                var id_produto = '#' + $(this).attr('id')

                if ($(this).attr('data-val-tipoproduto') == "master") {
                    var produto_master_id = $('meta[name="produto-master"]').attr('value')
                    change_produtos(id_produto, 'master')
                    if ($(id_produto).val() == produto_master_id) {
                        $(id_produto).prop('checked', true)
                        $(id_produto).trigger('change')
                    }
                    $(this).attr('data-set', 1)
                } else if ($(this).attr('data-val-tipoproduto') == "opcional") {

                    change_produtos(id_produto, 'opcional')
                    $(this).attr('data-set', 1)

                    if ($('meta[name="produto-opcionais"]').attr('value') != '') {
                        var produto_opcionais_id = $.parseJSON($('meta[name="produto-opcionais"]').attr('value'));
                        $.each(produto_opcionais_id, function (key, value) {
                            if ($(id_produto).val() == value) {
                                $(id_produto).prop('checked', true)
                                $(id_produto).trigger('change')
                            }
                        });
                        $('#comissao').trigger('change');

                    }
                }

            }

        })
        toggle_sapn_icon()

    }


    $("select[name=anomodelo]").on('change', function () {
        produtosvalores = []
        menorparc = 0.0
        remove_class()
        var meta_comissao = $('meta[name="comissao"]')
        if (meta_comissao.attr('value')) {
            $('#comissao').val(meta_comissao.attr('value'))
            meta_comissao.attr('value', '')
        }

        var meta_ano = $('meta[name="anomodelo"]');

        if (meta_ano.attr('value') != '') {
            $(this).val(meta_ano.attr('value'))
            meta_ano.attr('value', '');
        }

        var option = $('select[name=anomodelo] option:selected')
        // console.log(option.attr('data-valor'))

        combus = option.attr('data-comustivel')
        $('input[name="combustivel"]').val(combus)

        dados_produtos = {
            comissao: $('#comissao').val(),
            cdfipe: $('input[name=codefipe]').val(),
            valor: option.attr('data-valor'),
            ano: $(this).val(),
            tipo: $('select[name="tipoveiculo"]').val(),
            renova: $('input[name="renova"]:checked').val()

        };
        $('#panelprodutosopcional').hide();
        $('#produtosopcionais').empty();

        $.ajax({
            data: dados_produtos,
            url: geturl() + 'produtosmaster',
            dataType: "json",
            type: 'GET',
            success: function (retorno) {
                produtos.empty();
                produtopagamento.fadeIn();
                $.apllyFilters();


                $.each(retorno, function (key, value) {
                    produtos.append(value.html);
                });

                set_produtos()
                comissao_set()

                $('#comissao').trigger('change');
                panelprodutos.fadeIn('slow');
                btnproposta.fadeIn('slow');


            }

        });

    })


    $('#btnvender').on('click', function () {
        var cc = 0;
        var pp = 0;

        $('input:radio').each(function () {

            if ($(this).attr('name') == 'quantparcela' && $(this).is(':checked') && pp == 0) {
                pp = pp + 1;

            }
        })

        $('input:checkbox').each(function () {
            if ($(this).attr('name') == 'produtos[]' && $(this).is(':checked') && cc == 0) {

                cc = cc + 1;

            }
        })

        if (cc == 0) {

            $('.panel-body').animate({scrollTop: 0}, "fast")
            $('#messageerror').text('Escolha um produto antes de proseguir');
            diverror.show();

        } else if (pp == 0) {

            $('.panel-body').animate({scrollTop: 0}, "fast")
            $('#messageerror').text('Escolha uma qunatidade de parcela antes de proseguir');
            diverror.show();
        } else {
            diverror.hide();

            dadosveiculos.fadeIn("slow");
            panelsegurado.fadeIn("slow");
            pergunta.fadeIn("slow");
            btnsubmit.fadeIn("slow");


            setAnofab()
            setAnoRenav()

            $('#placa').focus();

            $('body').animate({scrollTop: 0}, "slow")


            $('#veiculo').prop('disabled', true)
            $('#search-fipe').prop('disabled', true)
            $('.fipe-label').css('padding-top', '16%')
            $('#codefip-value').prop('readonly', true)
            $('#veiculo').after("<input type='hidden' name='anom' value='" + $("select[name=anom]").val() + "'>")
            $("select[name=anom]").prop('disabled', true);
            $('#rowtipoveiculo').hide();
            $(this).fadeOut();
        }

        return false;
    });


    $("select[name=anom]").on('change', function () {
        setAnofab()
        setAnoRenav()

        $('input:checkbox').each(function () {
            if ($(this).attr('name') == 'produtos[]' && $(this).is(':checked')) {
                $(this).removeAttr('checked')
                $(this).trigger('change')

            }
        })

        if ($("select[name=anom]").val() == 0) {
            // alert($(this).val());
            $.each($("#anom option"), function (key, value) {
                if (value.value == '{"ano":2003,"combus":1,"valor":"12024"}') {

                    $("#anom").val(value.value)
                }
            });
        } else {

        }
        var djson = $.parseJSON($("select[name=anom]").val());
        var dados = {
            comissao: $('#comissao').val(),
            cdfipe: $('input[name=codefipe]').val(),
            valor: djson.valor,
            ano: djson.ano,
            tipo: $('input[name=tipoveiculo]:checked').val()
        };
        $('#panelprodutosopcional').hide();
        $('#produtosopcionais').empty();

        $.ajax({
            data: dados,
            url: geturl() + 'produtosmaster',
            dataType: "json",
            type: 'GET',
            success: function (retorno) {
                produtos.empty();
                $('#c-veiculo').removeClass("col-md-12").addClass("col-md-9");
                produtopagamento.fadeIn();
                var frist = true;
                $.each(retorno, function (key, value) {
                    produtos.append(value.html);


                    $(value.span).on('click', function () {
                        var span = $(this).children('span')
                        console.log(span.attr('class'))
                    })

                    if (value.chkid) {


                        $('#comissao').change(function () {


                            if ($(value.chkid).val()) {
                                var valor = $.parseJSON($(value.chkid).val());

                            } else {
                                return false;
                            }
                            var valorcomiss = aplicaComissao(valor.vlproduto, $(this).val());
                            $(value.precospan).text(addCommas(valorcomiss));
                            $('#valortotal').trigger('change');
                        });


                        $(value.chkid).change(function () {
                            var valor = $.parseJSON($(this).val());
                            if ($(this).is(":checked")) {
                                $.each(retorno, function (key, idsdiv) {
                                    if (idsdiv.chkid && idsdiv.chkid != value.chkid) {
                                        $(idsdiv.chkid).attr('disabled', 'disabled');
                                        $(idsdiv.divp).hide();
                                    }
                                })
                                produtosvalores.push(valor);
                                menorparc += parseFloat((valor.menorparc > 0) ? valor.menorparc : 0);
                                $('#valortotal').trigger('change');

                                /*Buscando Produtos Opcionais*/

                                dados.idproduto = valor.idproduto;
                                $.ajax({
                                    data: dados,
                                    url: geturl() + 'produtosopcional',
                                    dataType: "json",
                                    type: 'GET',
                                    success: function (retorno2) {
                                        // $('#produtosopcionais').empty();
                                        $.each(retorno2, function (key, opcionais) {
                                            $('#produtosopcionais').append(opcionais.html);
                                            $('#panelprodutosopcional').show();

                                            if (opcionais.chkid) {
                                                $('#comissao').change(function () {

                                                    if ($(opcionais.chkid).val()) {
                                                        var valor = $.parseJSON($(opcionais.chkid).val());
                                                        var valorcomiss = aplicaComissao(valor.vlproduto, $(this).val());
                                                        $(opcionais.precospan).text(addCommas(valorcomiss));
                                                        $('#valortotal').trigger('change');
                                                    }

                                                });
                                            }

                                            $(opcionais.chkid).change(function () {
                                                var valor = $.parseJSON($(this).val());
                                                if ($(this).is(":checked")) {
                                                    $.each(retorno2, function (key, idsdiv) {
                                                        if (idsdiv.chkid && idsdiv.chkid != opcionais.chkid && valor.tiposeguro == idsdiv.tiposeguro) {
                                                            $(idsdiv.chkid).attr('disabled', 'disabled');
                                                            $(idsdiv.divp).hide();

                                                        }
                                                    })
                                                    produtosvalores.push(valor);
                                                    menorparc += parseFloat((valor.menorparc > 0) ? valor.menorparc : 0);
                                                    $('#valortotal').trigger('change');


                                                } else {
                                                    $.each(retorno2, function (key, idsdiv) {
                                                        if (idsdiv.chkid) {
                                                            $(idsdiv.chkid).removeAttr('disabled').fadeIn();
                                                            $(idsdiv.divp).fadeIn();
                                                        }
                                                    });

                                                    (menorparc > 0 ) ? menorparc -= parseFloat((valor.menorparc > 0) ? valor.menorparc : 0) : menorparc;
                                                    if (vltotal !== 0) {
                                                        produtosvalores.splice($.inArray(valor, produtosvalores), 1);
                                                        $('#valortotal').trigger('change');
                                                    }
                                                }


                                            });
                                        });

                                        $('#comissao').trigger('change');
                                        $('#panelprodutosopcional').fadeIn('fast');


                                    }

                                })

                            } else {

                                $('#panelprodutosopcional').hide();
                                $('#produtosopcionais').empty();
                                $.each(retorno, function (key, idsdiv) {
                                    if (idsdiv.chkid) {
                                        $(idsdiv.chkid).removeAttr('disabled').fadeIn();
                                        $(idsdiv.divp).fadeIn();
                                    }
                                });

                                (menorparc > 0) ? menorparc -= parseFloat((valor.menorparc > 0) ? valor.menorparc : 0) : menorparc;
                                if (vltotal !== 0) {
                                    produtosvalores.splice($.inArray(valor, produtosvalores), 1);
                                    produtosvalores = [];
                                    $('#valortotal').trigger('change');
                                }
                            }


                        });

                    }
                });


                $('#comissao').trigger('change');
                panelprodutos.fadeIn('slow');
                btnproposta.fadeIn('slow');

                // produtos_set()


            }

        });

    })


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
                $('#propjuridica1').hide();
                $('#propramoatividade').hide();
                $('#propfisica1').fadeIn('fast');
                $('#propfisica2').fadeIn('fast');
                $('#propprofissao').fadeIn('fast');
            } else {
                $('#propjuridica1').fadeIn('fast');
                $('#propramoatividade').fadeIn('fast');
                $('#propfisica1').hide();
                $('#propfisica2').hide();
                $('#propprofissao').hide();
            }
        } else if ($(this).attr('name') == 'indproprietario') {
            if ($(this).is(":checked") && $(this).attr('value') == 1) {
                panelproprietario.hide();
            } else {
                panelproprietario.fadeIn('fast');
                $('#propjuridica1').hide();
                $('#propramoatividade').hide();

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
                $('#parcelas').empty();
                $.each(gerarParcelas(vltotal, values.maxparc, values.parcsemjuros, values.juros, menorparc, values.idforma), function (key, html) {
                    $('#parcelas').append(html);
                })
                $('input[name=quantparcela]').on('change', function () {
                    if ($(this).is(":checked")) {
                        $('#valortotal').text('R$ ' + $(this).attr('data-vlfinal'))
                    }
                })

                if (vltotal > 0) {
                    $('#condutor-proprietario').removeClass('col-md-12').addClass('col-md-9');
                    dadoscartao.fadeIn('slow');
                }
            } else {
                $('#parcelas').empty();
                $.each(gerarParcelas(vltotal, values.maxparc, values.parcsemjuros, values.juros, menorparc, values.idforma), function (key, html) {
                    $('#parcelas').append(html);
                })
                $('#condutor-proprietario').removeClass('col-md-9').addClass('col-md-12');
                $('input[name=quantparcela]').on('change', function () {
                    if ($(this).is(":checked")) {
                        $('#valortotal').text('R$ ' + $(this).attr('data-vlfinal'))
                    }
                })
                dadoscartao.hide();
            }
        }
    });

    $('#valortotal').on('change', function () {
        vltotal = 0;
        $.each(produtosvalores, function (key, value) {
            // console.log(value.valor)
            vltotal += parseFloat(aplicaComissao(value.valor, $('#comissao').val()))
        });


        $('input[name=formapagamento]').trigger('change');
        if (vltotal > 0) {

            panelpagamento.fadeIn();
        } else {

            panelpagamento.fadeOut();
        }

        set_parcelas()
        $(this).text('R$ ' + addCommas(vltotal.toFixed(2)));

    });

    if ($('#valor-comissao')) {


        $('#valor-comissao').on('change', function () {
            comissao_porcentagem = $('#comissao').val() / 100
            comissao_valor = vltotal * comissao_porcentagem
            comissao_valor = parseFloat(comissao_valor).toFixed(2)


            $(this).text('R$ ' + addCommas(comissao_valor))
        })
    }

    $('#formcotacao').submit(function () {

        $.ajax({
            type: 'POST',
            url: 'gerar',
            data: $(this).serialize(),
            success: function (retorno) {
                console.log(retorno);
                if (retorno.sucesso) {

                    $('#allbody').html(retorno.html)
                } else {
                    $('body').animate({scrollTop: 0}, "slow")
                    $.each(retorno.message, function (key, value) {
                        if (key != 'cdretorno' && key != 'status') {


                            if ($.isPlainObject(value)) {
                                // console.log(value)
                                $.each(value, function (key2, value2) {
                                    $('.panel-body').animate({scrollTop: 0}, "fast")
                                    $('#messageerror').text(retorno.tipo + ': ' + value2);
                                })
                            } else {
                                $('.panel-body').animate({scrollTop: 0}, "fast")

                                $('#messageerror').text(retorno.tipo + ': ' + value);
                            }

                        }
                    })
                    diverror.show();

                }

            },
            error: function (error) {
                $('html').html(error.responseText);
                // console.log(error.responseText);
            }
        });
        return false;
    });

    $('#teste').click(function () {

        // $('#codefip-value').val();
        reusltAutoComplete($('#codefip-value').val());

        $('#anom').delay(3000).trigger('change');

        // var val = parseJSON('{"ano":2003,"combus":1,"valor":"12024"}');


        // $('#veiculo').val();
        // $('#veiculo').trigger('keydown');
        // $('#veiculo').data('ui-autocomplete').trigger('select', 'autocompleteselect', {item:{value:$(this).val()}});


    });
    $('table').delegate('.modal-call','click', function () {
        var this_ = $(this);
        var url = this_.attr('data-url');
        var target = $(this_.attr('data-target'));
        $(".selectpicker").selectpicker();

        $.ajax({
            url: url,
            success: function (retorno) {
                console.log('ok');
                target.find('.modal-content').empty().html(retorno);
                $.apllyFilters();
                $('.modal-header').trigger('change');


            }
        });
    });


    // $('.modal-call').on('click', function () {
    //
    //
    //
    // });


    // $(':button').on('click', function () {
    //
    //     if ($(this).attr('data-toggle') && $(this).attr('data-toggle') == 'modal') {
    //
    //         if ($(this).attr('id') == 'showinfo') {
    //             $('.modal-content').empty()
    //             $.ajax({
    //                 url: $(this).attr('href'),
    //                 type: 'GET',
    //                 success: function (retorno) {
    //
    //                     $('.modal-content').html(retorno);
    //                     $.apllyFilters();
    //
    //
    //
    //                     return false;
    //                 }
    //
    //             });
    //         } else if ($(this).attr('id') == 'erro') {
    //             var idmsg = '#' + $(this).attr('message')
    //             $('#msgdeerro').text($(idmsg).val())
    //
    //         } else if ($(this).attr('id') == 'xml') {
    //             var idmsg = '#' + $(this).attr('message')
    //             $('#msgdeerro').text($(idmsg).val())
    //
    //         } else if ($(this).attr('id') == 'cancelar') {
    //
    //             $.ajax({
    //                 url: $(this).attr('href'),
    //                 type: 'GET',
    //                 success: function (retorno) {
    //                     $('.modal-content').html(retorno);
    //                     $.apllyFilters();
    //
    //
    //                 }
    //
    //             });
    //
    //         } else if ($(this).attr('id') == 'pagar') {
    //
    //             $.ajax({
    //                 url: $(this).attr('href'),
    //                 type: 'GET',
    //                 success: function (retorno) {
    //                     $('.modal-content').html(retorno);
    //                     $.apllyFilters();
    //
    //
    //                 }
    //
    //             });
    //
    //         } else if ($(this).attr('id') == 'comfirmapgto') {
    //
    //             $.ajax({
    //                 url: $(this).attr('href'),
    //                 type: 'GET',
    //                 success: function (retorno) {
    //                     $('.modal-content').html(retorno);
    //                     $.apllyFilters();
    //
    //
    //
    //
    //                 }
    //
    //             });
    //
    //
    //         }
    //     } else if ($(this).attr('id') == 'fechasecesso') {
    //
    //         $('#sucesso').hide();
    //     } else if ($(this).attr('data-target') != 'undefined') {
    //         $('.modal-content').empty()
    //
    //         $.ajax({
    //             url: $(this).attr('href'),
    //             type: 'GET',
    //             success: function (retorno) {
    //
    //                 $('.modal-content').html(retorno);
    //                 $.apllyFilters();
    //
    //
    //
    //                 return false;
    //             }
    //
    //         });
    //
    //     }
    //
    //     // return false;
    //
    // });

    function menssageError(message, idmessage) {
        return '<small><div class="col-md-6 col-md-offset-3 alert alert-danger" id="' + idmessage + '">' + message + '</div></small>'

    }



    $('.load-more').on('click', function () {
        // var table = $('.table-datatable').dataTable({});
        var _this = $(this);
        var _offset = parseInt(_this.attr('data-offset')) + parseInt(_this.attr('data-sum'));
        var _url = _this.attr('data-url');
        var _mostrando = $(_this.attr('data-mostrando'));
        var show = parseInt(_mostrando.attr('data-show')) + parseInt(_this.attr('data-sum'));
        var who = _mostrando.attr('data-nome');
        _this.attr('data-offset', parseInt(_this.attr('data-offset')) + parseInt(_this.attr('data-sum')));

        $.ajax({
            data: {offset: _offset},
            url: _url,
            success: function (retorno) {
                _mostrando.empty().attr('data-show',show).text('Mostrando últimas(os) '+show+ ' '+who);


                $('.panel-body').append('<div class="hide temp_table">' + retorno + '</div>');

                var tr = $('.temp_table').find('tbody').children();

                table.fnDestroy();

                $('tbody').append(tr);
                $('.table-datatable').dataTable({
                    language: {
                        sEmptyTable: "Nenhum registro encontrado",
                        sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
                        sInfoFiltered: "(Filtrados de _MAX_ registros)",
                        sInfoPostFix: "",
                        sInfoThousands: ".",
                        sLengthMenu: "_MENU_ resultados por página",
                        sLoadingRecords: "Carregando...",
                        sProcessing: "Processando...",
                        sZeroRecords: "Nenhum registro encontrado",
                        sSearch: "Pesquisar",
                        oPaginate: {
                            sNext: "Próximo",
                            sPrevious: "Anterior",
                            sFirst: "Primeiro",
                            sLast: "Último"
                        },
                        oAria: {
                            sSortAscending: ": Ordenar colunas de forma ascendente",
                            sSortDescending: ": Ordenar colunas de forma descendente"
                        }
                    },
                    "scrollY": ttable,
                    "scrollCollapse": true,
                    "destroy": true,
                    "fnDestroy": false,
                    "fnDraw": true,
                    "lengthMenu": [50, 100, 150, 200]
                });
                $('.temp_table').remove();


            }

        });

    });


    // $('a').click(function () {
    //
    //
    //     if ($(this).attr('id') == 'showinfo') {
    //         $('.modal-content').empty()
    //         $.ajax({
    //             url: $(this).attr('href'),
    //             type: 'GET',
    //             success: function (retorno) {
    //                 $('.modal-content').html(retorno);
    //
    //                 $('.modal-content').trigger('click');
    //
    //                 return false;
    //             }
    //
    //         });
    //     }
    //
    // });

    $('.modal-content').draggable({srcoll: false});

    $('.modal-content').on('mouseover', function () {

    })


    $('.cpfcnpj2').focusout(function () {
        var val = $(this).val();
        $(this).trigger('keyup');
        if (val.length > 11) {

            var value = $(this).cleanVal();
            var dados = {'cpfcnpj': value}

            $.ajax({
                data: dados,
                url: geturl() + 'getcorretor',
                dataType: "json",
                type: 'GET',
                success: function (retorno) {
                    if (retorno.status) {

                        $.each(retorno, function (key, value) {

                            $('div.form-group').each(function () {
                                if ($(this).children('input').attr('name') == 'nomerazao' && key == 'nomerazao') {

                                    $('#' + key).prop('disabled', true);
                                    $('#cpfcnpj').after('<input type="hidden" name="cpfcnpj" value="' + $('#cpfcnpj').val() + '">')
                                    $('#nome').focus();
                                    $('#cpfcnpj').prop('disabled', true);
                                    $('#' + key).val(value)
                                    $('<div class="alert alert-success col-md-6 col-md-offset-3"><samll>Corretaor(a) já cadastrado, preencha só os dados do usuário</samll></div>').insertAfter($(this))
                                } else if ($(this).children('input').attr('name') != 'nomerazao' && $(this).children('input').attr('name') == key) {
                                    $(this).remove()
                                } else if ($(this).children('input').attr('name') != 'nomerazao' && $(this).children('select').attr('name') == key) {
                                    $(this).remove()
                                }
                            })

                        })
                    } else {
                        return false

                    }

                }

            });
        }


    })


    $('.forma-pagamento').on('click', function () {

        $('.forma-pagamento').each(function () {
            $(this).removeClass('active')
                .removeClass('btn-primary')
                .addClass('btn-default');

        })
        $(this).removeClass('btn-default').addClass('active').addClass('btn-primary');

    })


//    search table function
    var toggle_sapn_icon = function () {
        $('.detalhe-toggle span').on('click', function () {
            console.log($(this))
        })
    }


    $('.button-cotacao-submit').on('click', function () {
        var id_error_msg = 'form_error'

        if ($('#cpfcnpj').val() == "" || !$('#cpfcnpj').val()) {

            $($('#cpfcnpj').attr('data-target-input')).addClass('has-error')
            $($('#cpfcnpj').attr('data-target-label')).addClass('label-danger')

            if ($('#' + id_error_msg)) {
                $('#' + id_error_msg).remove()
            }
            $('#form-cotacao').prepend(menssageError('O campo CPF/CNPJ é obrigatorio', id_error_msg))

            $('.panel-body').scrollTop('fast')
            return false

        } else if ($('#' + id_error_msg)) {
            $($('#cpfcnpj').attr('data-target-input')).removeClass('has-error')
            $($('#cpfcnpj').attr('data-target-label')).removeClass('label-danger')
            $('#' + id_error_msg).hide()
        }

        $('#cpfcnpj').unmask(mask_cpfcnpj)
        $('#form-cotacao').append('<input name="tipoenvio" type="hidden" value="' + $(this).attr('id') + '">')

    })


    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500);
    });

    $('.tipo-consulta').on('change', function () {
        var tipo_consulta = $(this);

        if (tipo_consulta.placa == 'placa') {
            $('.input-consulta').mask('AAA-9999')
        }
    });
    
    
    $('.modal-content').delegate('button.cep', 'click', function () {
        var input = $('input.cep ');

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

    $('.modal-content').delegate('.modal-header','change',function(){
        $('.cpfcnpj').trigger('focusin');
        $('button.cep').trigger('click');


    });


});

