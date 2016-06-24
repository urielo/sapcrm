<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    protected $table = 'usuarios';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    
    protected $fillable = [
        'nome', 'email', 'password','idstatus','idtipousuario'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function corretor()
    {
        return $this->hasOne('App\Model\Corretores','idcorretor','idcorretor');
    }
}
