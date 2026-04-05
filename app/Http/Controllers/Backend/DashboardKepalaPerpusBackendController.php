<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

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

    return view('page.backend.dashboardperpus.index', [
        'keterlambatan' => $keterlambatan,
        // data lain juga kirim:
        'jumlahPetugas' => \App\Models\User::where('role', 'petugas')->count(),
        'jumlahAnggota' => \App\Models\Anggota::count(),
        'jumlahBuku' => \App\Models\Buku::count(),
        'totalDenda' => Pengembalian::sum('denda'),
    ]);
}
}
