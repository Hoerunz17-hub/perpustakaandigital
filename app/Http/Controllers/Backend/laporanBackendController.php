<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class laporanBackendController extends Controller
{
  public function index(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $query = Peminjaman::with(['anggota', 'buku', 'pengembalian']);

    if ($bulan) {
        $query->whereMonth('tanggal_pinjam', $bulan);
    }

    if ($tahun) {
        $query->whereYear('tanggal_pinjam', $tahun);
    }

    $data = $query->get();

    // ✅ TAMBAHAN LOGIC STATUS
    foreach ($data as $item) {
        $status = $item->status;
        $pengembalian = $item->pengembalian;

        if ($status == 'dikembalikan') {
            if ($pengembalian && $pengembalian->status == 'terlambat') {
                $item->status_final = 'terlambat';
            } else {
                $item->status_final = 'dikembalikan';
            }
        } else {
            $item->status_final = $status;
        }
    }

    return view('page.backend.laporan.index', compact('data', 'bulan', 'tahun'));
}

public function cetak(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $query = Peminjaman::with(['anggota', 'buku', 'pengembalian']);

    if ($bulan) {
        $query->whereMonth('tanggal_pinjam', $bulan);
    }

    if ($tahun) {
        $query->whereYear('tanggal_pinjam', $tahun);
    }

    $data = $query->get();

    // ✅ LOGIC YANG SAMA
    foreach ($data as $item) {
        $status = $item->status;
        $pengembalian = $item->pengembalian;

        if ($status == 'dikembalikan') {
            if ($pengembalian && $pengembalian->status == 'terlambat') {
                $item->status_final = 'terlambat';
            } else {
                $item->status_final = 'dikembalikan';
            }
        } else {
            $item->status_final = $status;
        }
    }

   $pdf = Pdf::loadView('page.backend.laporan.laporanpdf', compact('data', 'bulan', 'tahun'));

   return $pdf->stream('laporan.pdf');
}
}
