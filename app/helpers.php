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

    function webserviceCotacao($cotacao, $url)
    {
        $data = json_encode($cotacao);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "cotacao",
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
            return json_decode($response);
        }
    }
endif;

if (!function_exists('webserviceProposta')):

    function webserviceProposta($proposta, $url)
    {
        $data = json_encode($proposta);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "proposta",
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

if (!function_exists('showDate')):

    function showDate($date, $interval = NULL)
    {


        if ($interval == NULL) {
            return date('d/m/Y', strtotime($date));

        } else {
            return date('d/m/Y', strtotime($interval, strtotime($date)));
        }


    }

endif;
if (!function_exists('between')):

    function between($val, $min, $max)
    {
        return ($val >= $min && $val <= $max);
    }

endif;
if (!function_exists('primeiroNome')):

    /**
     * Get a users first name from the full name
     * or return the full name if first name cannot be found
     * e.g.
     * James Smith        -> James
     * James C. Smith   -> James
     * Mr James Smith   -> James
     * Mr Smith        -> Mr Smith
     * Mr J Smith        -> Mr J Smith
     * Mr J. Smith        -> Mr J. Smith
     *
     * @param string $fullName
     * @param bool $checkFirstNameLength Should we make sure it doesn't just return "J" as a name? Defaults to TRUE.
     *
     * @return string
     */
    function primeiroNome($fullName, $checkFirstNameLength = TRUE)
    {
        // Split out name so we can quickly grab the first name part
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        // If the first part of the name is a prefix, then find the name differently
        if (in_array(strtolower($firstName), array('sr', 'sra', 'srs', 'sras', 'dr', 'dra'))) {
            if ($nameParts[2] != '') {
                // E.g. Mr James Smith -> James
                $firstName = $nameParts[1];
            } else {
                // e.g. Mr Smith (no first name given)
                $firstName = $fullName;
            }
        }
        // make sure the first name is not just "J", e.g. "J Smith" or "Mr J Smith" or even "Mr J. Smith"
        if ($checkFirstNameLength && strlen($firstName) < 3) {
            $firstName = $fullName;
        }
        return $firstName;
    }

endif;

if (!function_exists('jurosComposto')):

    function jurosComposto($valor, $taxa, $parcelas)
    {
        $taxa = $taxa / 100;
        $potencia = $valor * $taxa * pow(($taxa + 1), $parcelas) / (pow(($taxa + 1), $parcelas) - 1);
        $valParcela = number_format($potencia, 2, ".", "");

        return $valParcela;
    }

endif;

if (!function_exists('geraParcelas')):
    //gerarParcelas(vltotal, maxparc, parcelasemjuros, taxajuros, menorparc, formapg)

    function geraParcelas($premio, $max_parcelas, $parcelas_sem_juros, $taxa_juros, $valor_menor_parcela, $id_forma, $renova = 0)
    {
        $parcela = 1;
        $retorno = [];

        while ($parcela <= $max_parcelas) {


            $obj_retorno = new stdClass();
            $obj_retorno->taxa_juros = 0;
            $obj_retorno->quantidade = $parcela;


            $parcela_com_juros = jurosComposto($premio, $taxa_juros, $parcela);

            if ($parcela > $parcelas_sem_juros && $parcela_com_juros < $valor_menor_parcela && $id_forma == 2 && $renova == 0) {
                $obj_retorno->primeira_parcela = $valor_menor_parcela;
                $obj_retorno->demais_parcela = ((jurosComposto($premio, $taxa_juros, $parcela) * $parcela) - $valor_menor_parcela) / ($parcela - 1);
                $obj_retorno->valor_final = $valor_menor_parcela + $obj_retorno->demais_parcela * ($parcela - 1);
                $obj_retorno->taxa_juros = $taxa_juros;
            } elseif ($parcela <= $parcelas_sem_juros && $premio / $parcela < $valor_menor_parcela && $id_forma == 2 && $renova == 0 ) {
                $obj_retorno->primeira_parcela = $valor_menor_parcela;
                $obj_retorno->demais_parcela = ($premio - $valor_menor_parcela) / ($parcela - 1);
                $obj_retorno->valor_final = $valor_menor_parcela + ($obj_retorno->demais_parcela * ($parcela - 1));
            } elseif ($parcela > $parcelas_sem_juros) {
                $obj_retorno->primeira_parcela = $parcela_com_juros;
                $obj_retorno->demais_parcela = $parcela_com_juros;
                $obj_retorno->valor_final = $parcela_com_juros * $parcela;
                $obj_retorno->taxa_juros = $taxa_juros;
            } else {
                $obj_retorno->primeira_parcela = $premio / $parcela;
                $obj_retorno->demais_parcela = $obj_retorno->primeira_parcela;
                $obj_retorno->valor_final = $obj_retorno->primeira_parcela * $parcela;
            }
            $parcela++;
            $retorno[] = $obj_retorno;

        }

        return $retorno;
    }

endif;
if (!function_exists('hiddenId')):


    function hiddenId($id, $tipo)
    {
        $token = md5('hidden') . '-';
        
        switch ($tipo) {
            case 'encode':
            $id = base64_encode($token . $id);
                break;
            case 'decode':
                $id = str_replace($token,'',base64_decode($id));
                break;
            default :
                return false;

        }

        return $id;
    }

endif;




