<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileanggotaBackendController extends Controller
{
    public function index(){
        return view('page.backend.profile.index');
    }
}
