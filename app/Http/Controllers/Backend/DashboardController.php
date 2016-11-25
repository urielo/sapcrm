<?php

namespace App\Http\Controllers\Backend;
use App\Model\HomePage;




class DashboardController extends Controller
{
    public function index()
    {
        $textos = HomePage::class;

        return view('backend.home.index',compact('textos'));
    }
}
