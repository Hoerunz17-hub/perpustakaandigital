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
        return redirect('/loginuser');
    }

    $anggota = Auth::user()->anggota;

    if (!$anggota) {
        return back()->with('error', 'Data anggota tidak ditemukan');
    }

    // 📚 Buku yang masih dipinjam
    $peminjaman = $anggota
        ->peminjaman()
        ->where('status', 'dipinjam')
        ->with('buku', 'pengembalian')
        ->get();

    // 📜 History (SEMUA kecuali yang masih dipinjam)
    $history = $anggota
        ->peminjaman()
        ->whereIn('status', ['dikembalikan', 'ditolak'])
        ->with('buku', 'pengembalian')
        ->latest()
        ->get();

    return view('page.frontend.bukusaya.index', compact('peminjaman', 'history'));
}
}
