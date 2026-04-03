<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukusayaFrontendController extends Controller
{

 public function index()
{
    if (!Auth::check()) {
        return redirect('/loginuser'); // atau route login kamu
    }

    $anggota = Auth::user()->anggota;

    if (!$anggota) {
        return back()->with('error', 'Data anggota tidak ditemukan');
    }

    $peminjaman = $anggota
        ->peminjaman()
        ->where('status', 'dipinjam')
        ->with('buku')
        ->get();

    return view('page.frontend.bukusaya.index', compact('peminjaman'));
}
}
