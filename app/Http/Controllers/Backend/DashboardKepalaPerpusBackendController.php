<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKepalaPerpusBackendController extends Controller
{
    public function index(){
        return view('page.backend.dashboardperpus.index');
    }
}
