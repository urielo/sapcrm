<?php

namespace App\Http\Controllers\Backend;

use App\Model\Movimentos;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MovimentosController extends Controller
{
    public function index()
    {
        $movimentos = Movimentos::all();


        foreach ($movimentos as $movimento){
            
        }
    }
}
