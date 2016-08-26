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
    var diverror = $('#diverror');
    var ramoatividade = $('#ramoatividade');
    var vltotal = 0;
    var produtosvalores = [];
    var menorparc = 0.0;

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

    $('#body-panel').height($(window).height() - 170);
    $(window).resize(function () {
        $('#body-panel').height($(window).height() - 170);
    })

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
                toggleActive: true,
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

    if ($('input[name=tipocadastro]')) {
        $('input[name=tipocadastro]')


    }


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
    function gerarParcelas(vltotal, maxparc, parcelasemjuros, taxajuros, menorparc,formapg) {


        var retorno = [];
        // var porcentj = parseFloat(taxajuros) / 100


        for (var i = 1; i < maxparc + 1; i++) {
            var juros = vltotal + (vltotal * (taxajuros / 100));
            var priparcela = 0;
            var demparcela = 0;
            var textojuros = (i > parcelasemjuros) ? 'J.: ' + taxajuros.replace('.', ',') + '%' : 'S/J';
            var textojuroc = (i > parcelasemjuros) ? 'Juros: ' + taxajuros.replace('.', ',') + '%' : 'Sem juros';


            if (i > parcelasemjuros && juros / i < menorparc && formapg == 2) {
                priparcela = menorparc;
                demparcela = (juros - menorparc) / (i - 1);
            } else if (i <= parcelasemjuros && vltotal / i < menorparc && formapg == 2) {
                priparcela = menorparc;
                demparcela = (vltotal - menorparc) / (i - 1);
            } else if (i > parcelasemjuros) {
                priparcela = juros / i;
                demparcela = priparcela;
            } else {
                priparcela = vltotal / i;
                demparcela = priparcela;
            }
            priparcela = priparcela.toFixed(2).replace('.', ',');
            demparcela = demparcela.toFixed(2).replace('.', ',');
            if (i == 1) {
                retorno.push('<label style="font-size: 10px;"><input type="radio" name="quantparcela" id="formapagamento" value="' + i + '">' + i + 'x de R$ ' + priparcela + ' (' + textojuroc +') </label><br>')
            } else if (formapg == 1) {
                retorno.push('<label style="font-size: 10px;"><input type="radio" name="quantparcela" id="formapagamento" value="' + i + '">' + i + 'x de R$ ' + priparcela + ' (' + textojuroc +') </label><br>')
            } else {
                var ii = i -1;
                retorno.push('<label style="font-size: 10px;"><input type="radio" name="quantparcela" id="formapagamento" value="' + i + '">' + i + 'x (1x de R$ ' + priparcela + ' e '+ ii +'x de  R$ ' + demparcela + ' ' + textojuros + ') </label><br>')
            }
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
        $('#codefip-text').text(cdfipe);
        divano.fadeIn("slow");

        $.get(geturl() + "anovalor/",
            {cdfipe: cdfipe},
            // Carregamos o resultado acima para o campo modelo
            function (valor) {
                $("select[name=anom]").html(valor);
            }
        )


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

    buscaCep('#segcep', '#segenduf', '#segendlog', '#segendcidade');
    buscaCep('#propcep', '#propenduf', '#propendlog', '#propendcidade');
    buscaCep('#cep', '#uf', '#logradouro', '#cidade');


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
    var commin = $('select[name=comissao] option:eq(1)').val();
    $('select[name=comissao] option:eq(1)').remove();

    for (var i = $('select[name=comissao]').val() - 1; i > commin - 1; i--) {

        $('select[name=comissao]').append('<option value="' + i + '">' + i + '</option>')
    }


    $('#veiculo').marcacomplete({

        delay: 0,
        source: geturl() + 'modelo',
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


    $('#btnvender').on('click', function () {
        var cc = 0;
        $('input:checkbox').each(function () {
            if ($(this).attr('name') == 'produtos[]' && $(this).is(':checked') && cc == 0) {
                dadosveiculos.fadeIn("slow");
                panelsegurado.fadeIn("slow");
                pergunta.fadeIn("slow");
                btnsubmit.fadeIn("slow");

                setAnofab()
                setAnoRenav()

                $('#placa').focus();

                $('body').animate({scrollTop: 0}, "slow")
                cc = cc + 1;

            }
        })

        if(cc == 0){
            alert('Escolha um produto antes de proseguir')
        } else {
            $('#veiculo').prop('disabled', true)
            $('#veiculo').after("<input type='hidden' name='anom' value='"+$("select[name=anom]").val()+"'>")
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

            var djson = $.parseJSON($("select[name=anom]").val());
        }
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


                    $(value.acordion).accordion({
                        heightStyle: "content",
                        active: true,
                        collapsible: true,
                        header: 'h6'
                    });

                    if (value.chkid) {


                        $('#comissao').change(function () {
                            var valor = $.parseJSON($(value.chkid).val());
                            var valorcomiss = aplicaComissao(valor.vlproduto, $(this).val());
                            $(value.precospan).text(valorcomiss.replace('.', ','));
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
                                            $(opcionais.acordion).accordion({
                                                heightStyle: "content",
                                                active: true,
                                                collapsible: true,
                                                header: 'h6'
                                            });

                                            if (opcionais.chkid) {
                                                $('#comissao').change(function () {

                                                    if ($(opcionais.chkid).val()) {
                                                        var valor = $.parseJSON($(opcionais.chkid).val());
                                                        var valorcomiss = aplicaComissao(valor.vlproduto, $(this).val());
                                                        $(opcionais.precospan).text(valorcomiss.replace('.', ','));
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


            }

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
                if (vltotal > 0) {
                    $('#condutor-proprietario').removeClass('col-md-12').addClass('col-md-9');
                    dadoscartao.fadeIn('slow');
                }
            } else {
                $('#parcelas').empty();

                $.each(gerarParcelas(vltotal, values.maxparc, values.parcsemjuros, values.juros, menorparc,values.idforma), function (key, html) {
                    $('#parcelas').append(html);
                })
                $('#condutor-proprietario').removeClass('col-md-9').addClass('col-md-12');
                dadoscartao.hide();
            }
        }
    });

    $('#valortotal').on('change', function () {
        vltotal = 0;
        $.each(produtosvalores, function (key, value) {
            vltotal += parseFloat(aplicaComissao(value.vlproduto, $('#comissao').val()))
        });
        $('input[name=formapagamento]').trigger('change');
        if (vltotal > 0) {
            $(this).text('R$ ' + vltotal.toFixed(2).replace('.', ','));
            panelpagamento.fadeIn();
        } else {
            panelpagamento.fadeOut();
        }

    });

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
                                $.each(value, function (key2, value2) {
                                    $('#messageerror').text(value2);
                                })
                            } else {
                                $('#messageerror').text(value);
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


    $(':button').on('click', function () {

        if ($(this).attr('id') == 'erro') {
            var idmsg = '#' + $(this).attr('message')
            $('#msgdeerro').text($(idmsg).val())

        } else if ($(this).attr('id') == 'xml') {
            var idmsg = '#' + $(this).attr('message')
            $('#msgdeerro').text($(idmsg).val())

        } else if ($(this).attr('id') == 'cancelar') {

            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                success: function (retorno) {
                    $('.modal-content').html(retorno);

                }

            });

        } else if ($(this).attr('id') == 'pagar') {

            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                success: function (retorno) {
                    $('.modal-content').html(retorno);

                    $('.modal-content').on('mouseover', function () {
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
                    })
                }

            });

        } else if ($(this).attr('id') == 'comfirmapgto') {

            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                success: function (retorno) {
                    $('.modal-content').html(retorno);

                    $('.modal-content').on('mouseover', function () {

                        $(':input').each(function () {

                            if ($(this).attr('tipoinput') == "data-pagamento-boleto") {

                                $(this).attr('placeholder', 'DD/MM/YYYY');
                                setDateP('#' + $(this).attr('id'), 'pagamento-boleto')
                                $(this).mask('99/99/9999')

                            }
                        })

                        // $('#datapgto').datepicker({
                        //     format: "dd/mm/yyyy",
                        //     startView: 0,
                        //     language: "pt-BR",
                        //     startDate: "-",
                        //     autoclose: true,
                        //     defaultViewDate: {year: d.getFullYear(), month: d.getMonth(), day: d.getDay()}
                        // });

                    })


                }

            });

        } else if ($(this).attr('id') == 'fechasecesso') {

            $('#sucesso').hide();
        }

    });

    function menssageError(message, idmessage) {
        return '<small><div class="alert alert-danger" id="' + idmessage + '" style="padding: 0px; margin: 0px; background-color: transparent; border: transparent;">' + message + '</div></small>'

    }


    $('a').click(function () {

        if ($(this).attr('id') == 'showinfo') {
            $('.modal-content').empty()
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                success: function (retorno) {

                    $('.modal-content').html(retorno);


                    return false;
                }

            });
        }

    });


    $('body').on('mouseover', function () {

        // $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();


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
        })


    });

    $('#cpfcnpj').focusout(function () {
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



//    search table function

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
            return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','false');
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','true');
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}
    });
});

