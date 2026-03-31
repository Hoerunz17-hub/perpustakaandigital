<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class laporanBackendController extends Controller
{
    public function index(){
        return view('page.backend.laporan.index');
    }
}
