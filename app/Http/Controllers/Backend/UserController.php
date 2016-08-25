<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;
use Illuminate\Support\Facades\Redirect;

use App\User;

class UserController extends Controller
{
    public function index(Request $request){

        $usuarios = User::orderBy('updated_at', 'DESC')->paginate(100);
        return view('backend.user.home', compact('usuarios'));
    }
    
    public function alterStatus($iduser){
        $user = User::find($iduser);
        
        $user->idstatus = ($user->idstatus == 1 ? 2 : 1);
        
        $user->save();
        
        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!! Usuário(a): '.nomeCase($user->nome).' foi '.($user->idstatus == 1 ? ' ativado(a)' : ' desativado(a)') );
    }
}
