<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Model\Role;
use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;
use Illuminate\Support\Facades\Redirect;

use App\User;

class UserController extends Controller
{
    public function index()
    {

        $usuarios = User::orderBy('updated_at', 'DESC')->get();
        return view('backend.user.home', compact('usuarios'));

    }

    public function search($searchterm = null, Request $request)
    {
        if ($request->status == 'true') {
            $usuarios = User::orderBy('updated_at', 'DESC')->
            where('nome', 'ilike', '%' . $searchterm . '%')->
            orWhere('email', 'ilike', '%' . $searchterm . '%')->
            paginate(100);
        } else {
            $usuarios = User::orderBy('id', 'ASC')->paginate(100);
        }

        return view('backend.user.table', compact('usuarios'));

    }

    public function alterStatus($iduser)
    {
        $user = User::find($iduser);

        $user->idstatus = ($user->idstatus == 1 ? 2 : 1);

        $user->save();

        return Redirect::back()->with('sucesso', 'Operação relaizada com sucesso!! Usuário(a): ' . nomeCase($user->nome) . ' foi ' . ($user->idstatus == 1 ? ' ativado(a)' : ' desativado(a)'));
    }

    /**
     * @param array $middleware
     */
    public function tipos($iduser)
    {
        $usuario = User::find($iduser);
        $roles = Role::all();
        
        return view('backend.show.showtipos', compact('usuario', 'roles'));
    }
    public function alteratipos(Request $request)
    {


        $usuario = User::find($request->usuario_id);

        $usuario->roles()->sync( (count($request->roles) > 0 ? $request->roles : [] ) );

     return redirect()->route('usuarios.gestao')->with('sucesso','Alterações realizadas com sucesso');
    }
}
