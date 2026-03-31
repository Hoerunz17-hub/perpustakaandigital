<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllerBackendController extends Controller
{
    public function login(){
        return view('page.auth.backend.login');
    }

  public function prosesLogin(Request $request)
    {
        // 🔥 VALIDASI DULU
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 🔥 AMBIL DATA LOGIN
        $credentials = $request->only('username', 'password');

        // 🔥 COBA LOGIN
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate(); // penting banget

            $user = Auth::user();

            // 🔥 CEK ROLE
            if ($user->role == 'petugas') {
                return redirect('/adminpetugas')->with('success', 'Login berhasil sebagai petugas');
            }

            if ($user->role == 'kepala') {
                return redirect('/kepalaperpus')->with('success', 'Login berhasil sebagai kepala');
            }

            // fallback
            return redirect('/');
        }

        // ❌ KALAU GAGAL
        return back()->with('error', 'Username atau password salah');
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

      return redirect('/login')->with('success', 'Berhasil logout');
}
}
