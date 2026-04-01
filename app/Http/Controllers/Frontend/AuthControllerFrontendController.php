<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllerFrontendController extends Controller
{
    public function login(){
        return view('page.auth.frontend.login');
    }
public function prosesLogin(Request $request)
{
    // validasi
   $request->validate([
    'email' => 'required|email',
    'password' => 'required'
]);

    // login pakai username
   $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    if (Auth::attempt($credentials)) {

        // cek role anggota
        if (Auth::user()->role == 'anggota') {
            return redirect('/')->with('success', 'Login berhasil');
        } else {
            Auth::logout();
            return back()->with('error', 'Bukan akun anggota!');
        }
    }

    return back()->with('error', 'email atau password salah');
}

public function logout()
{
    Auth::logout();
    return redirect('/')->with('success', 'Berhasil logout');
}
     public function registrasi(){
        return view('page.auth.frontend.register');
    }
     public function store(Request $request)
    {

        // VALIDASI
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'password' => 'required|min:3|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // SIMPAN USER
       $user = User::create([
    'username' => $request->nama,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'anggota'
]);

        // UPLOAD IMAGE
        $imageName = null;
        if ($request->hasFile('foto')) {
            $imageName = $request->file('foto')->store('anggota', 'public');
        }

        // SIMPAN ANGGOTA
        Anggota::create([
            'nama_anggota' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'image' => $imageName,
            'id_user' => $user->id_user ?? $user->id, // sesuaikan PK user kamu
        ]);

        return redirect('/loginuser')->with('success', 'Registrasi berhasil');
    }
}
