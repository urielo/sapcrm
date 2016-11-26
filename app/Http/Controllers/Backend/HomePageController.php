<?php

namespace App\Http\Controllers\Backend;

use App\Model\HomePage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class HomePageController extends Controller
{
    public function index()
    {

    }

    public function altera_get()
    {
        $textos = HomePage::class;
        $crypt = Crypt::class;

        return view('backend.home.alterar', compact('textos', 'crypt'));
    }

    public function altera_post(Request $request)
    {
        $retorno = $request->all();
        unset($retorno['_token']);
        (isset($retorno['text']) ? $retorno['text'] = htmlentities($retorno['text']) : NULL );

        if (isset($request->id)) {
            unset($retorno['id']);
            
            HomePage::find($request->id)->update($retorno);

        } else {

            HomePage::create($retorno);
        }

        return Redirect::back()->with('sucesso', 'Operação realizada com sucesso');


    }

    public function modal($type_id)
    {
        try {
            $type_id = Crypt::decrypt($type_id);
        } catch (DecryptException $e) {

            return abort(404);
        }

        switch ($type_id) {
            case 'h1':
                $texto = HomePage::where('type', $type_id)->first();
                break;
            case 'p':
                $texto = HomePage::where('type', $type_id)->first();
                break;
            case 'novo':
                $texto = false;
                break;
            default :
                $texto = HomePage::find($type_id);

        }

        return view('backend.home.altera_show', compact('texto'));
    }


    public function delete($home_id)
    {
        HomePage::find(Crypt::decrypt($home_id))->delete();

        return Redirect::back()->with('sucesso', 'Operação realizada com sucesso!');
    }

}
