@extends('layout.frontend.app')

@section('content')
    <div class="container py-5 d-flex justify-content-center">

        <div style="width: 600px;">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">

                    <!-- Judul -->
                    <h4 class="mb-4" style="color: #d88a2d; font-weight: 600;">
                        Form Peminjaman Buku
                    </h4>

                    <form action="#" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 14px;">
                                Nama Peminjam
                            </label>
                            <input type="text" name="nama" class="form-control form-control-sm"
                                placeholder="Masukkan nama" required>
                        </div>

                        <!-- Buku -->
                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 14px;">
                                Buku Yang Akan Dipinjam
                            </label>
                            <select name="buku" class="form-control form-control-sm" required>
                                <option value="">-- Pilih Buku --</option>
                                <option value="bumi">Bumi</option>
                                <option value="bulan">Bulan</option>
                                <option value="matahari">Matahari</option>
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="d-flex" style="gap: 10px;">
                            <button type="submit" class="btn btn-success btn-sm px-3" style="border-radius: 6px;">
                                Pinjam
                            </button>

                            <a href="#" class="btn btn-secondary btn-sm px-3" style="border-radius: 6px;">
                                Kembali
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
