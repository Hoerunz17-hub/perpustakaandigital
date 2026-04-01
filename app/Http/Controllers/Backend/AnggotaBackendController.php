<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaBackendController extends Controller
{
   public function index(){
    $anggota = Anggota::all(); // ambil semua data
    return view('page.backend.anggota.index', compact('anggota'));
}

public function show($id){
    $anggota = Anggota::findOrFail($id);
    return view('page.backend.anggota.detail', compact('anggota'));
}
}
