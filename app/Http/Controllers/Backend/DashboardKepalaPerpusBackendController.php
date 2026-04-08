<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardKepalaPerpusBackendController extends Controller
{
  public function index()
{
    $keterlambatan = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
        ->whereNotNull('tanggal_kembali')
        ->whereHas('peminjaman', function ($query) {
            $query->whereColumn('pengembalian.tanggal_kembali', '>', 'peminjaman.wajib_kembali');
        })
        ->latest()
        ->get();

     // ✅ BUKU PALING POPULER
    $bukuPopuler = DB::table('peminjaman')
        ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
        ->select(
                    'buku.penulis',
                    'buku.id_buku',
            'buku.judul_buku',
            'buku.kode_buku',
            DB::raw('COUNT(peminjaman.id_peminjaman) as total_pinjam')
        )
        ->groupBy('buku.id_buku', 'buku.judul_buku', 'buku.kode_buku', 'buku.penulis')
        ->orderByDesc('total_pinjam')
        ->limit(5)
        ->get();

    return view('page.backend.dashboardperpus.index', [
        'keterlambatan' => $keterlambatan,
        'bukuPopuler' => $bukuPopuler, // ⬅️ kirim ke blade
        'jumlahPetugas' => \App\Models\User::where('role', 'petugas')->count(),
        'jumlahAnggota' => \App\Models\Anggota::count(),
        'jumlahBuku' => \App\Models\Buku::count(),
        'totalDenda' => Pengembalian::sum('denda'),
    ]);
}
}
