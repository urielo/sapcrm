<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{


    use ResetsPasswords;

    protected $redirectTo = '/';
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    

}
