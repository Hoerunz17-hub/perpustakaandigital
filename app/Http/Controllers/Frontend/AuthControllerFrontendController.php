<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthControllerFrontendController extends Controller
{
    public function login(){
        return view('page.auth.frontend.login');
    }
     public function registrasi(){
        return view('page.auth.frontend.register');
    }
}
