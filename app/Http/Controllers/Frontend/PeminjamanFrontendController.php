<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanFrontendController extends Controller
{
    public function index(Request $request)
{
    $buku = Buku::where('is_active', 1)->get();

    // ambil id buku dari query string (?id_buku=...)
    $selectedBuku = $request->id_buku;

    return view('page.frontend.peminjaman.index', compact('buku', 'selectedBuku'));
}
}
