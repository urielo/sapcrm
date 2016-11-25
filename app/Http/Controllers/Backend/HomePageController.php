<?php

namespace App\Http\Controllers\Backend;

use App\Model\HomePage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        $textos = HomePage::class;
        
        return view('backend.home.index',compact('textos'));
    }

    public function altera_get()
    {
        
    }
    
    public function altera_post()
    {
        
    }
    
    
}
