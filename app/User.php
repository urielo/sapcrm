<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model

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
