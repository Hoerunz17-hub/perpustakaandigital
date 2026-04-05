<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardPetugasBackendController extends Controller
{
   public function index()
{
    $jumlahBuku = Buku::count();
    $jumlahAnggota = Anggota::count();

    $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
    $bukuDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
    $bukuDitolak = Peminjaman::where('status', 'ditolak')->count();
 $historyPeminjaman = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
     ->orderBy('tanggal_pinjam', 'desc')
    ->take(10)
    ->get();

    return view('page.backend.dashboradpetugas.index', compact(
        'jumlahBuku',
        'jumlahAnggota',
        'bukuDipinjam',
        'bukuDikembalikan',
         'bukuDitolak',
        'historyPeminjaman'
    ));
}
}
