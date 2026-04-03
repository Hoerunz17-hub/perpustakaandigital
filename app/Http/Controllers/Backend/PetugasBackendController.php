<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PetugasBackendController extends Controller
{
   public function index()
    {
        $data = Petugas::all();
        return view('page.backend.petugas.index', compact('data'));
    }

    public function create()
    {
        return view('page.backend.petugas.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'nama_petugas' => 'required',
        'jenis_kelamin' => 'required',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required',
        'email' => 'required|email|unique:petugas,email',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp'
    ]);

    DB::transaction(function () use ($request) {

        // ✅ CEK USER DULU
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'username' => $request->nama_petugas,
                'email' => $request->email,
                'role' => 'petugas',
                'password' => Hash::make('123456'),
            ]);
        }

        // ✅ UPLOAD IMAGE
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('petugas', 'public');
        }

        // ✅ SIMPAN PETUGAS
        Petugas::create([
            'id_user' => $user->id_user,
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'image' => $image,
        ]);

    });

    return redirect('/petugas')->with('success', 'Petugas berhasil ditambahkan');
}
    public function edit($id)
    {
        $data = Petugas::findOrFail($id);
        return view('page.backend.petugas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $image = $petugas->image;
      if ($request->hasFile('image')) {

    // hapus foto lama
    if ($petugas->image && Storage::disk('public')->exists($petugas->image)) {
        Storage::disk('public')->delete($petugas->image);
    }

    $image = $request->file('image')->store('petugas', 'public');
}

        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'image' => $image
        ]);

        return redirect('/petugas')->with('success', 'petugas berhasil diupdate');
    }
    public function updateStatus(Request $request, $id)
{
    $petugas = Petugas::findOrFail($id);
    $petugas->is_active = $request->is_active;
    $petugas->save();

    return response()->json(['success' => true]);
}
public function show($id)
{
    $data = Petugas::findOrFail($id);
    return view('page.backend.petugas.detail', compact('data'));
}

   public function destroy($id)
{
    $petugas = Petugas::findOrFail($id);

    // hapus gambar
    if ($petugas->image && Storage::disk('public')->exists($petugas->image)) {
        Storage::disk('public')->delete($petugas->image);
    }

    $petugas->delete();

    return redirect('/petugas')->with('success', 'Petugas berhasil dihapus');
}
}
