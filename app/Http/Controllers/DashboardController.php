<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    public function dashboard($token){
        return view('admin.dashboard');
    }

    

}
