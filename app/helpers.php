<?php
if (!function_exists('theme')):

    function theme($path)
    {
        $config = app('config')->get('sap.theme');

        return url($config['folder'] . '/' . $config['active'] . '/assets/' . $path);
    }
endif;

if (!function_exists('format')):

    function format($tipo, $string)
    {
        if (empty($string) || strlen($string) < 1):
            return $string;
        else:
            switch ($tipo):
                case 'cpfcnpj':
                    if (strlen($string) > 11):
                        $mask = "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s";

                    else:
                        $mask = "%s%s%s.%s%s%s.%s%s%s-%s%s";
                    endif;
                    break;
                case 'fone':
                    if (strlen($string) <= 8):
                        $mask = "%s%s%s%s-%s%s%s%s";
                    else:
                        $mask = "%s%s%s%s%s-%s%s%s%s";
                    endif;
                    break;
                case 'cartao':

                    if (strlen($string) != 16) {
                        return $string;
                    }
                    $mask = "%s%s%s%s %s%s%s%s %s%s%s%s %s%s%s%s";
                    break;
                case 'cep':
                    $mask = "%s%s%s%s%s-%s%s%s";
                    break;
                case 'placa':
                    $string = strtoupper($string);
                    $mask = "%s%s%s-%s%s%s%s";
                    break;
                case 'real':
                    return number_format($string, 2, ',', '.');
                    break;
                default :
                    return 'tipo invalida';
            endswitch;

            return vsprintf($mask, str_split($string));
        endif;
    }
endif;
#aqui vai meu comentario
if (!function_exists('nomeCase')):

    function nomeCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
    {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }//foreach
        return $string;
    }
endif;

if (!function_exists('webserviceCotar')):

    function webserviceCotacao($cotacao, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado)
    {
        $data = json_encode(array_merge($cotacao, $perfilsegurado, $corretor, $segurado, $veiculo, $produtos, $proprietario, $condutor));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://producao.seguroautopratico.com.br/gerar/cotacao",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                "x-api-key: 000666"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
endif;

if (!function_exists('webserviceProposta')):

    function webserviceProposta($proposta, $segurado, $veiculo, $produtos, $proprietario, $condutor, $perfilsegurado)
    {
        $data = json_encode(array_merge($proposta, $perfilsegurado, $segurado, $veiculo, $produtos, $proprietario, $condutor));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://producao.seguroautopratico.com.br/gerar/proposta",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                "x-api-key: 000666"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
endif;

if (!function_exists('aplicaComissao')):

    function aplicaComissao($valor, $comissao)
    {
        if ($comissao > 0):
            $comissao = 1 - $comissao / 100;
            return (float)number_format($valor / $comissao, 2, '.', '');
        else:
            return (float)number_format($valor, 2, '.', '');
        endif;
    }


endif;

if (!function_exists('gerarXml')):

    function gerarXml($servico, $config, $proposta)

    {
        $tipopessoa = (strlen($proposta->cotacao->veiculo->clicpfcnpj) > 11 ? 2 : 1);
        switch ($servico):

            case "cotacao":
                $xml = '<i4proerp><cotacao_auto_configuravel id_revenda = "' . $config->id_revenda . '"';
                $xml .= ' nm_usuario = "' . $config->nm_usuario . '"';
                $xml .= ' cd_tipo_pessoa = "' . $tipopessoa . '"';
                $xml .= ' nr_cpf_cnpj_cliente = "' . $proposta->cotacao->veiculo->clicpfcnpj . '"';
                $xml .= ' nr_cep = "' . $proposta->cotacao->segurado->clicep . '"';
                $xml .= ' cd_fipe = "' . $proposta->cotacao->veiculo->veiccodfipe . '"';
                $xml .= ' nr_ano_auto = "' . $proposta->cotacao->veiculo->veicano . '"';
                $xml .= ' dv_auto_zero = "' . ($proposta->cotacao->veiculo->veicautozero == 0 ? 2 : 1) . '"';
                $xml .= ' id_auto_combustivel = "' . $proposta->cotacao->veiculo->veictipocombus . '"';
                $xml .= ' cd_categoria_tarifaria = "' . $proposta->cotacao->veiculo->categoria . '"';
                $xml .= ' cd_produto = "' . $config->cd_produto . '"';
                $xml .= ' nr_mes_periodo_vigencia = "' . $config->mes_periodo_virgencia . '" /></i4proerp>';
                break;
            case "proposta":
                $xml = '<i4proerp><proposta_auto_configuravel id_revenda = "' . $config->id_revenda . '"';
                $xml .= ' nm_usuario = "' . $config->nm_usuario . '"';
                $xml .= ' nr_cotacao_i4pro = "' . $proposta->cotacaoseguradora->id_cotacao_seguradora . '"';
                $xml .= ' nm_pessoa = "' . $proposta->cotacao->segurado->clinomerazao . '"';
                ($tipopessoa == 1 ? $xml .= ' id_sexo = "' . $proposta->cotacao->segurado->clicdsexo . '"' : null);
                ($tipopessoa == 1 ? $xml .= ' id_estado_civil = "' . $proposta->cotacao->segurado->clicdestadocivil . '"' : null);
                $xml .= ' dt_nascimento = "' . $proposta->cotacao->segurado->clidtnasc . '"';
                ($tipopessoa == 1 ? $xml .= ' nm_resp1 = "' . $config->nm_resp1_gov . '"' : null);
                ($tipopessoa == 1 ? $xml .= ' nm_resp2 = "' . $config->nm_resp2_gov . '"' : null);
                $xml .= ' nr_ddd_res = "' . $proposta->cotacao->segurado->clidddfone . '"';
                $xml .= ' nm_fone_res = "' . $proposta->cotacao->segurado->clinmfone . '"';
                $xml .= ' nr_ddd_cel = "' . $proposta->cotacao->segurado->clidddcel . '"';
                $xml .= ' nm_fone_cel = "' . $proposta->cotacao->segurado->clinmcel . '"';
                $xml .= ' nm_email = "' . $proposta->cotacao->segurado->cliemail . '"';
                $xml .= ' nm_endereco = "' . $proposta->cotacao->segurado->clinmend . '"';
                $xml .= ' nr_endereco = "' . $proposta->cotacao->segurado->clinumero . '"';
                $xml .= ' nm_complemento = "' . $proposta->cotacao->segurado->cliendcomplet . '"';
                $xml .= ' nm_cidade = "' . $proposta->cotacao->segurado->clinmcidade . '"';
                $xml .= ' cd_uf = "' . $proposta->cotacao->segurado->clicduf . '"';
                $xml .= ($tipopessoa == 1 ? ' cd_profissao = "' : ' id_ramo_atividade = "') . $proposta->cotacao->segurado->clicdprofiramoatividade . '"';
                $xml .= ' nm_placa = "' . $proposta->cotacao->veiculo->veicplaca . '"';
                $xml .= ' nm_chassis = "' . $proposta->cotacao->veiculo->veicchassi . '"';
                $xml .= ' dv_segurado_proprietario = "' . ($proposta->cotacao->veiculo->propcpfcnpj == $proposta->cotacao->veiculo->clicpfcnpj ? 1 : 0) . '"';
                $xml .= ' id_auto_utilizacao = "' . $proposta->cotacao->veiculo->veiccdutilizaco . '"';
                $xml .= ' cd_forma_pagamento_pparcela = "' . $config->cd_forma_pagamento . '"';
                $xml .= ' id_produto_parc_premio = "' . $config->id_produto_parcela_premio . '" /></i4proerp>';
                break;
            case "venda":
                $xml = '<i4proerp><venda_auto_configuravel id_revenda = "' . $config->id_revenda . '"';
                $xml .= ' nm_usuario = "' . $config->nm_usuario . '"';
                $xml .= ' nr_cotacao_i4pro = "' . $proposta->cotacaoseguradora->id_cotacao_seguradora . '"';
                $xml .= ' id_proposta = "' . $proposta->propostaseguradora->id_proposta_seguradora . '"';
                $xml .= ' dt_instala_rastreador = "' . date("Ymd") . '"';
                $xml .= ' dt_ativa_rastreador = "' . date("Ymd") . '"';
                $xml .= ' dt_inicio_vig_comodato = "' . date("Ymd") . '"';
                $xml .= ' dt_fim_vig_comodato = "' . date('Ymd', strtotime('+1 year')) . '"  /></i4proerp>';
                break;
            default:
                $xml = false;

        endswitch;

        return $xml;
    }

endif;

if (!function_exists('Getcall')):

    function Getcall($SoapClient, $servico, $xml)
    {
        $result = $SoapClient->__soapCall('Executar', array(
            'Executar' => array(
                'Servico' => $servico,
                'conteudoXML' => $xml
            )));
        return $result->ExecutarResult;
    }

endif;

if (!function_exists('GetCallNobre')):

    function GetCallNobre($seguradora, $SoapClient, $servico, $xml)
    {
        $result = $SoapClient->__soapCall('Executar', array(
            'Executar' => array(
                'Servico' => $servico,
                'conteudoXML' => $xml
            )));
        return $result->ExecutarResult;
    }

endif;

if (!function_exists('getDateFormat')):

    function getDateFormat($date, $type = null)
    {
        switch ($type) {

            case 'valcartao':
                $validade = '01-' . str_replace('/', "-", $date);
                return date('Ym', strtotime($validade));
                break;
            case 'nascimento':
                $validade = str_replace('/', "-", $date);
                return date('Ymd', strtotime($validade));
            default:
                return $validade = str_replace('/', "-", $date);

        }


    }

endif;

if (!function_exists('getDataReady')):

    function getDataReady($data)
    {
        $search = [
            '/',
            '.',
            '-',
            ',',
            '\\',
            '(',
            ')',
            ' ',
        ];

        return str_replace($search, '', $data);


    }

endif;


