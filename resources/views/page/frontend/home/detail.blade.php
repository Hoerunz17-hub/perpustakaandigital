@extends('layout.frontend.app')

@section('content')
    <section class="book-detail py-5">
        <div class="container">

            <div class="detail-wrapper">
                <div class="row align-items-start g-5">
                    <!-- COVER -->
                    <div class="col-md-4">
                        <div class="book-cover">
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul_buku }}">
                        </div>
                    </div>

                    <!-- DETAIL -->
                    <div class="col-md-8">

                        <!-- Judul -->
                        <h2 class="book-title mb-2">
                            {{ $buku->judul_buku }}
                        </h2>

                        <!-- Badge -->
                        <div class="book-badge mb-3">
                            <span class="badge-kategori">
                                {{ $buku->kategori }}
                            </span>

                            <span
                                class="badge-stock
                        {{ $buku->stock > 0 ? 'available' : 'empty' }}">
                                Stock: {{ $buku->stock }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="book-info">
                            <div class="info-item">
                                <span>Penulis</span>
                                <strong>{{ $buku->penulis }}</strong>
                            </div>

                            <div class="info-item">
                                <span>Tahun Terbit</span>
                                <strong>{{ $buku->tahun_terbit }}</strong>
                            </div>
                            <div class="info-item">
                                <span>Kode Buku</span>
                                <strong>{{ $buku->kode_buku }}</strong>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="book-desc mt-4">
                            <h5>Deskripsi</h5>
                            <p>
                                {{ $buku->deskripsi_buku }}
                            </p>
                        </div>

                        <!-- Button -->
                        <div class="book-action mt-4">
                            <a href="#" class="btn-pinjam">
                                📚 Pinjam Buku
                            </a>

                            <a href="" class="btn-kembali">
                                ← Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .book-cover img {
            width: 100%;
            height: 520px;
            /* lebih tinggi */
            object-fit: contain;
            /* BUKAN cover */
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            background: #f8f9fa;
        }

        .book-cover img:hover {
            transform: scale(1.03);
        }

        .book-cover {
            padding: 15px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Judul */
        .book-title {
            font-weight: 700;
            font-size: 28px;
        }

        /* Badge */
        .book-badge {
            display: flex;
            gap: 10px;
        }

        .badge-kategori {
            background: #f5d0c5;
            color: #7a3e2b;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
        }

        .badge-stock {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
        }

        .badge-stock.available {
            background: #d1f7e3;
            color: #1b7f5e;
        }

        .badge-stock.empty {
            background: #fde2e2;
            color: #b02a37;
        }

        .book-detail {
            background: #f5f5f5;
        }

        /* Info */
        .book-info {
            margin-top: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
        }

        .info-item span {
            color: #888;
        }

        .info-item strong {
            font-weight: 500;
        }

        /* Deskripsi */
        .book-desc h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .book-desc p {
            color: #666;
            line-height: 1.8;
            text-align: justify;
        }

        /* Button */
        .book-action {
            display: flex;
            gap: 12px;
        }

        .btn-pinjam {
            background: linear-gradient(45deg, #0d6efd, #4dabf7);
            color: white;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-pinjam:hover {
            opacity: 0.9;
        }

        .btn-kembali {
            border: 1px solid #ccc;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            color: #555;
        }

        .btn-kembali:hover {
            background: #f8f9fa;
        }

        .detail-wrapper {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogin() {
            Swal.fire({
                icon: 'warning',
                title: 'Harus Login!',
                text: 'Silahkan login atau daftar dulu untuk meminjam buku',
                confirmButtonColor: '#c59d5f'
            });
            return false;
        }
    </script>
@endsection
