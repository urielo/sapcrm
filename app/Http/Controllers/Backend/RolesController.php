<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use App\Http\Requests;
use App\Http\Controllers\Backend\Controller;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $roles= Role::All();
        $permissions = Permission::All();

        return view('backend.user.roles',compact('roles','permissions','request'));
    }

    public function update(Request $request)
    {

//        return $request->all();
        $role = Role::find($request->role_id);
        $role->perms()->sync($request->permissions);

        return Redirect::back()->with('sucesso','Grupo atualizado com sucesso!!');
    }
}
