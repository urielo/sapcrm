<?php

namespace App\Http\Controllers\Backend\Config;

use Illuminate\Http\Request;
use Excel;
use App\Model\FipeModel;
use App\Model\FipeAnoValorModel;

class UploadController extends Controller
{

    public function index()
    {
        return view('backend.upload.home');
    }

    public function postUploadFipeAnoValor(Request $request)
    {
         ini_set('max_execution_time', 300);
        Excel::load($request->File('xlsfipe'), function($reader) {

            $reader->each(function($sheet) {
                $ii = 0;               
                $repl = array('med', 'g');
                $comb = array('GGG' => 1, 'AAA' => 2, 'DDD' => 3);
                $sh = $sheet->toArray();
                $datas = array();
                
                foreach ($sh as $key => $value):
                    
                    if ($value != NULL && str_replace($repl, '', $key) > 0):
                        $key = str_replace($repl, '', $key);
                        if ($key > 80 && $key < 100 && date('Y')<2100):
                            $key = "19{$key}";
                        else:
                            $y = substr(date('Y'), 0,-2);
                            $key = "{$y}{$key}";
                        endif;
                        $datas[$ii]['codefipe'] = $sh['cod_fipe'];
                        $datas[$ii]['ano'] = $key;
                        $datas[$ii]['valor'] = $value;
                        $datas[$ii]['idcombustivel'] = $comb[$sh['combus']];
                        $ii++;

                    elseif ($key == 'novo_g' && $value != NULL):
                        $datas[$ii]['codefipe'] = $sh['cod_fipe'];
                        $datas[$ii]['ano'] = 0;
                        $datas[$ii]['valor'] = $value;
                        $datas[$ii]['idcombustivel'] = $comb[$sh['combus']];
                        $ii++;
        
                    endif;
                endforeach;
                FipeAnoValorModel::destroy($sh['cod_fipe']);
                foreach ($datas as $v):                   
                    FipeAnoValorModel::firstOrCreate($v);
                endforeach;

                
            });
        });
        return \Redirect::route('backend.upload')->with('message','sucesso');
    }
    public function postUploadFipe(Request $request)
    {

        Excel::load($request->File('xlsfipe'), function($reader) {

            $reader->select(['marca','modelo','fipe'])->each(function($sheet) {

                $a = $sheet->toArray();

                foreach ($a as $k=>$v):
                 if($k == 'fipe'):
                     $a['codefipe'] = $v;
                     unset($a[$k]);
                 endif;   
                endforeach;
                echo"<hr>";

                
                
                FipeModel::firstOrCreate($a);
                    
                
            });
        });
        return \Redirect::route('backend.upload')->with('message1','sucesso');
    }
}
