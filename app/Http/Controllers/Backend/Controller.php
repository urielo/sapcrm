<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use  ValidatesRequests;

    public function __construct()
    {

        $this->middleware('auth');


    }
}
