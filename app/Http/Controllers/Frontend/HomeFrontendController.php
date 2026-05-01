<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeFrontendController extends Controller
{
     public function index(){
         $buku = Buku::where('is_active', 1)->get(); // hanya yang aktif
         
         $popular_books = Buku::where('is_active', 1)
            ->withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->limit(4)
            ->get();

         $slider_books = Buku::where('is_active', 1)
            ->orderBy('id_buku', 'desc')
            ->limit(3)
            ->get();

        return view('page.frontend.home.index', compact('buku', 'popular_books', 'slider_books'));
    }
 public function show($id)
{
    $buku = Buku::findOrFail($id);

    $totalPinjam = 0;

    if (Auth::check()) {

        $totalPinjam = DB::table('peminjaman')
            ->join('anggota', 'peminjaman.id_anggota', '=', 'anggota.id_anggota')
            ->where('anggota.id_user', Auth::id())
            ->whereIn('peminjaman.status', ['menunggu', 'dipinjam'])
            ->count();
    }

    return view('page.frontend.home.detail', compact('buku', 'totalPinjam'));
}
}
