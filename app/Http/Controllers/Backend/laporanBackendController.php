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
    $search = $request->search;

    $query = Peminjaman::with(['anggota', 'buku', 'pengembalian']);
    // bulan dan tahun
    if ($bulan) {
        $query->whereMonth('tanggal_pinjam', $bulan);
    }

    if ($tahun) {
        $query->whereYear('tanggal_pinjam', $tahun);
    }

    // search
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('anggota', function ($q2) use ($search) {
                $q2->where('nama_anggota', 'like', "%$search%");
            })
            ->orWhereHas('buku', function ($q3) use ($search) {
                $q3->where('judul_buku', 'like', "%$search%");
            });
        });
    }

    $data = $query->get();


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

    return view('page.backend.laporan.index', compact('data', 'bulan', 'tahun', 'search'));
}

public function cetak(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $search = $request->search;

    $query = Peminjaman::with(['anggota', 'buku', 'pengembalian']);

    if ($bulan) {
        $query->whereMonth('tanggal_pinjam', $bulan);
    }

    if ($tahun) {
        $query->whereYear('tanggal_pinjam', $tahun);
    }

    //  SEARCH
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('anggota', function ($q2) use ($search) {
                $q2->where('nama_anggota', 'like', "%$search%");
            })
            ->orWhereHas('buku', function ($q3) use ($search) {
                $q3->where('judul_buku', 'like', "%$search%");
            });
        });
    }

    $data = $query->get();

    // logic data bulan tahun
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

    $pdf = Pdf::loadView('page.backend.laporan.laporanpdf', compact('data', 'bulan', 'tahun', 'search'));

    return $pdf->stream('laporan.pdf');
}
}
