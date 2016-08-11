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
    panelpagamento.hide();
    panelprodutos.hide();
    panelsegurado.hide();
    juridica1.hide();
    ramoatividade.hide();
    divano.hide();
    dadoscartao.hide();
    btnsubmit.hide();
    btnproposta.hide();
    dadosveiculos.hide();
    panelcondutor.hide();
    panelproprietario.hide();


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
            changeYear: true
        });

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
    function gerarParcelas(vltotal, maxparc, parcelasemjuros, taxajuros, menorparc) {


        setDateP('input[name=segdatanasc]');
        setDateP('input[name=segrgdtemissao]');
        setDateP('input[name=segdatafund]');

        var retorno = [];
        // var porcentj = parseFloat(taxajuros) / 100


        for (var i = 1; i < maxparc + 1; i++) {
            var juros = vltotal + (vltotal * (taxajuros / 100));
            var priparcela = 0;
            var demparcela = 0;
            var textojuros = (i > parcelasemjuros) ? 'J.: ' + taxajuros.replace('.', ',') + '%' : 'S/J';


            if (i > parcelasemjuros && juros / i < menorparc) {
                priparcela = menorparc;
                demparcela = (juros - menorparc) / (i - 1);
            } else if (i <= parcelasemjuros && vltotal / i < menorparc) {
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
                retorno.push('<label style="font-size: 10px;"><input type="radio" name="quantparcela" id="formapagamento" value="' + i + '">' + i + 'x de R$ ' + priparcela + '</label><br>')
            } else {
                retorno.push('<label style="font-size: 10px;"><input type="radio" name="quantparcela" id="formapagamento" value="' + i + '">' + i + 'x 1ª de R$ ' + priparcela + ' Demais:  R$ ' + demparcela + ' ' + textojuros + '</label><br>')
            }
        }

        return retorno;
    };
    function geturl() {
        var url = location.href;
        url = url.split('/');
        url = url[0] + '//' + url[2] + '/';
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

        $.get(geturl() + "anofab/",
            {cdfipe: cdfipe},
            // Carregamos o resultado acima para o campo modelo
            function (valor) {
                $("select[name=anof]").html(valor);
            }
        )

    }

    buscaCep('#segcep', '#segenduf', '#segendlog', '#segendcidade');
    buscaCep('#propcep', '#propenduf', '#propendlog', '#propendcidade');


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

    for (var i = $('select[name=comissao]').val() - 1; i > -1; i--) {
        $('select[name=comissao]').append('<option value="' + i + '">' + i + '</option>')
    }


    $('#veiculo').marcacomplete({

        delay: 0,
        source: geturl() + 'modelo',
        select: function (event, ui) {
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


        dadosveiculos.fadeIn("slow");
        panelsegurado.fadeIn("slow");
        pergunta.fadeIn("slow");
        btnsubmit.fadeIn("slow");
        $(this).fadeOut();
    });


    $("select[name=anom]").on('change', function () {


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

                $.each(gerarParcelas(vltotal, values.maxparc, values.parcsemjuros, values.juros, menorparc), function (key, html) {
                    $('#parcelas').append(html);
                })
                if (vltotal > 0) {
                    $('#condutor-proprietario').removeClass('col-md-12').addClass('col-md-9');
                    dadoscartao.fadeIn('slow');
                }
            } else {
                $('#parcelas').empty();

                $.each(gerarParcelas(vltotal, values.maxparc, values.parcsemjuros, values.juros, menorparc), function (key, html) {
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

                if (retorno.sucesso) {

                    $('#allbody').html(retorno.html)
                } else {

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
                $('#allbody').html(error);
                // console.log(error);
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

                }

            });

        } else if ($(this).attr('id') == 'fechasecesso') {

            $('#sucesso').hide();
        }

    });

    $('a').click(function () {

        if ($(this).attr('id') == 'linksegurado') {

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
    // $('input:text').on('keydown', function () {
    //
    //     if ($(this).attr('id') == 'dataprimeira') {
    //
    //         console.log($(this).attr('value'))
    //
    //         // if ($(this).attr('value').length == 2) {
    //         //
    //         // }
    //     }
    // });

});

