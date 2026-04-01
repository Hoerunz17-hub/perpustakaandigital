@extends('layout.frontend.app')

@section('content')
    <section class="py-5" style="background:#f8f5f2;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="borrow-card p-4">

                        <h3 class="mb-4 text-center">Form Peminjaman Buku</h3>

                        <form action="" method="POST">


                            <!-- Nama -->
                            <div class="mb-3">
                                <label class="form-label">Nama Peminjam</label>

                                @auth
                                    <input type="text" class="form-control" value="{{ Auth::user()->username }}" readonly>
                                @else
                                    <input type="text" class="form-control" value="" placeholder="Silakan login dulu"
                                        readonly>
                                @endauth
                            </div>

                            <!-- PILIH BUKU (DROPDOWN) -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Buku</label>
                                <select name="id_buku" class="form-control" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @if (isset($buku) && count($buku) > 0)
                                        @foreach ($buku as $item)
                                            <option value="{{ $item->id_buku }}">
                                                {{ $item->judul_buku }} (Stock: {{ $item->stock }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Data buku tidak tersedia</option>
                                    @endif
                                </select>
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" value="" readonly>
                                <input type="hidden" name="tanggal_pinjam" value="">
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="mb-4">
                                <label class="form-label">Tanggal Wajib Kembali</label>
                                <input type="date" class="form-control" value="" readonly>
                                <input type="hidden" name="tanggal_kembali" value="">
                            </div>

                            <!-- Button -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-pinjam">
                                    Pinjam
                                </button>

                                <a href="/" class="btn-kembali">
                                    Kembali
                                </a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </section>

    <style>
        .borrow-card h3 {
            color: #c59d5f;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .borrow-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Input & Select */
        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #c59d5f;
        }

        /* Label */
        .form-label {
            font-size: 13px;
            color: #777;
        }

        .d-flex.gap-2 {
            align-items: center;
            /* biar sejajar */
        }

        .btn-pinjam,
        .btn-kembali {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            /* samain tinggi */
            padding: 0 16px;
            /* biar rapi */
            font-size: 13px;
            border-radius: 6px;
        }

        /* Button */
        .btn-pinjam {
            background: #198754;
            color: white;
            padding: 6px 14px;
            /* lebih kecil */
            font-size: 13px;
            border-radius: 6px;
            border: none;
        }

        .btn-pinjam:hover {
            background: #157347;
        }

        .btn-kembali {
            background: #6c757d;
            color: white;
            padding: 6px 14px;
            /* kecil juga */
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-kembali:hover {
            background: #5c636a;
        }
    </style>
@endsection
