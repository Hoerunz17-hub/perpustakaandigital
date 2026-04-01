<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanFrontendController extends Controller
{
    public function index(){
          $buku = Buku::where('is_active', 1)->get(); // hanya yang aktif
        return view('page.frontend.peminjaman.index', compact('buku'));
    }
}
