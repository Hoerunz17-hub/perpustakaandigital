<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class HomeFrontendController extends Controller
{
     public function index(){
        $buku = Buku::all(); // ambil semua buku
        return view('page.frontend.home.index', compact('buku'));
    }
    public function show($id)
{
    $buku = Buku::findOrFail($id);
    return view('page.frontend.home.detail', compact('buku'));
}
}
