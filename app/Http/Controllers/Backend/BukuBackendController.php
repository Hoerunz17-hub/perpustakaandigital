<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuBackendController extends Controller
{
   public function index()
    {
        $data = Buku::all();
        return view('page.backend.buku.index', compact('data'));
    }

    public function create()
    {
        return view('page.backend.buku.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'judul_buku' => 'required',
        'penulis' => 'required',
        'tahun_terbit' => 'required|date',
        'stock' => 'required|integer',
        'kategori' => 'required',
        'deskripsi_buku' => 'required',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp'
    ]);

    try {
        $cover = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('cover_buku', 'public');
        }

        Buku::create([
            'kode_buku' => $this->generateKodeBuku(),
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'stock' => $request->stock,
            'kategori' => $request->kategori,
            'deskripsi_buku' => $request->deskripsi_buku,
            'cover' => $cover
        ]);

        return redirect('/buku')->with('success', 'Buku berhasil ditambahkan');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Buku gagal ditambahkan');
    }
}

    public function edit($id)
    {
        $data = Buku::findOrFail($id);
        return view('page.backend.buku.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $cover = $buku->cover;
        if ($request->hasFile('cover')) {
           // 🔥 HAPUS COVER LAMA
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        // 🔥 UPLOAD COVER BARU
        $cover = $request->file('cover')->store('cover_buku', 'public');
        }

        $buku->update([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'stock' => $request->stock,
            'kategori' => $request->kategori,
            'deskripsi_buku' => $request->deskripsi_buku,
            'cover' => $cover
        ]);

        return redirect('/buku')->with('success', 'Buku berhasil diupdate');
    }
    private function generateKodeBuku()
{
    $last = Buku::orderBy('id_buku', 'desc')->first();

    if (!$last) {
        return 'BK001';
    }

    $lastNumber = (int) substr($last->kode_buku, 2);
    $newNumber = $lastNumber + 1;

    return 'BK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

public function updateStatus(Request $request, $id)
{
    $buku = Buku::findOrFail($id);
    $buku->is_active = $request->is_active;
    $buku->save();

    return response()->json(['success' => true]);
}
public function show($id)
{
    $data = Buku::findOrFail($id);
    return view('page.backend.buku.detail', compact('data'));
}

   public function destroy($id)
{
    $buku = Buku::findOrFail($id);

    // 🔥 hapus cover kalau ada
    if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
        Storage::disk('public')->delete($buku->cover);
    }

    $buku->delete();

    return redirect('/buku')->with('success', 'Buku berhasil dihapus');
}
}
