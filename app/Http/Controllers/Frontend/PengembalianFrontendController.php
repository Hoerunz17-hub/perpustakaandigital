<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianFrontendController extends Controller
{
public function index(Request $request)
{
    $anggotaId = Auth::user()->anggota->id_anggota;

   $peminjaman = Peminjaman::with('buku')
    ->where('id_anggota', $anggotaId)
    ->whereIn('status', ['dipinjam', 'menunggu_pengembalian', 'dikembalikan', 'ditolak'])
    ->get();

    $buku = $peminjaman->pluck('buku');

    $selectedBuku = $request->id_buku;

    $detailPinjam = null;

    if ($selectedBuku) {
        $detailPinjam = Peminjaman::where('id_anggota', $anggotaId)
            ->where('id_buku', $selectedBuku)
            ->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
            ->first();
    }

    return view('page.frontend.pengembalian.index', compact('buku', 'selectedBuku', 'detailPinjam'));
}  public function store(Request $request)
{
    $request->validate([
    'id_buku' => 'required|exists:buku,id_buku',
    'tanggal_kembali' => 'required|date',
     'kondisi_buku' => 'required|in:normal,rusak,hilang',
]);

    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Silakan login terlebih dahulu');
    }

    DB::beginTransaction();

    try {

        $anggotaId = Auth::user()->anggota->id_anggota;

$peminjaman = Peminjaman::where('id_buku', $request->id_buku)
    ->where('id_anggota', $anggotaId) // ✅ BENAR
    ->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
    ->whereDoesntHave('pengembalian')
    ->latest()
    ->first();

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        $wajib = Carbon::parse($peminjaman->wajib_kembali);
        $kembali = Carbon::today();

        $selisih = $kembali->diffInDays($wajib, false);

       $denda = 0;

// keterlambatan
if ($selisih < 0) {
    $status = 'terlambat';
    $denda += abs($selisih) * 1000;
} else {
    $status = 'tepat_waktu';
}

// 🔥 kondisi buku
if ($request->kondisi_buku == 'rusak') {
    $denda += 50000;
} elseif ($request->kondisi_buku == 'hilang') {
    $denda += 30000;
}

        // 1. simpan pengembalian
        Pengembalian::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
           'id_petugas' => 1,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $denda,
            'status' => $status,
             'kondisi_buku' => $request->kondisi_buku,
        ]);

        // 2. update status peminjaman (MENUNGGU KONFIRMASI)
$peminjaman->status = 'menunggu_pengembalian';
$peminjaman->save();


        DB::commit();

        return redirect('/bukusaya')->with('success', 'Menunggu Konfirmasi Petugas');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}
}
