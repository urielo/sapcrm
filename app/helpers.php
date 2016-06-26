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
                case 'cep':
                    $mask = "%s%s%s%s%s-%s%s%s";
                    break;
                case 'placa':
                    $string = strtoupper($string);
                    $mask = "%s%s%s-%s%s%s%s";
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
            CURLOPT_URL => "http://www.webservice.local/gerar/cotacao",
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
            return json_decode($response, true);
        }
    }
endif;

if (!function_exists('aplicaComissao')):

    function aplicaComissao($valor, $comissao)
    {
        if ($comissao > 0):
            $comissao = 1 - $comissao / 100;
            return (float) number_format($valor / $comissao, 2, '.', '');
        else:
            return (float) number_format($valor, 2, '.', '');
        endif;
    }


 
endif;
