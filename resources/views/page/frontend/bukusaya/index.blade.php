@extends('layout.frontend.app')
@section('content')
    @auth
        <section class="bg-white" style="padding-top: 100px; padding-bottom: 100px;">
            <div class="container">

                <div class="row g-4">

                    <!-- PROFILE KIRI -->
                    <div class="col-md-4">
                        <div class="profile-card text-center p-4 h-100">

                            @if (Auth::user()->anggota && Auth::user()->anggota->image)
                                <img src="{{ asset('storage/' . Auth::user()->anggota->image) }}" class="profile-img mb-3">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}" class="profile-img mb-3">
                            @endif

                            <h5 class="mb-1">{{ Auth::user()->username }}</h5>
                            <p class="text-muted small">{{ Auth::user()->email }}</p>

                        </div>
                    </div>

                    <!-- DATA KANAN -->
                    <div class="col-md-8">
                        <div class="data-card p-4 h-100">

                            <h5 class="mb-4">Informasi Anggota</h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <div class="data-value">
                                        {{ Auth::user()->anggota->jenis_kelamin ?? '-' }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <div class="data-value">
                                        {{ Auth::user()->anggota->tanggal_lahir ?? '-' }}
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Alamat</label>
                                    <div class="data-value">
                                        {{ Auth::user()->anggota->alamat ?? '-' }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>
    @endauth
    <section id="featured-books" class="bg-white" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <div class="title">
                            <span>Buku Yang sedang dipinjam</span>
                        </div>
                        <h2 class="section-title">Buku Dipinjam</h2>
                    </div>

                    <div class="product-list" data-aos="fade-up">
                        <div class="row">

                            @forelse ($peminjaman as $pinjam)
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $wajib = \Carbon\Carbon::parse($pinjam->wajib_kembali)->startOfDay();
                                    $isPengembalianDitolak =
                                        $pinjam->pengembalian && $pinjam->pengembalian->status == 'ditolak';
                                    $isPeminjamanDitolak = $pinjam->status == 'ditolak';
                                    $selisih = $today->diffInDays($wajib, false);
                                @endphp
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <figure class="product-style">
                                            <img src="{{ asset('storage/' . $pinjam->buku->cover) }}" alt="Books"
                                                class="product-item">
                                            @if ($isPengembalianDitolak)
                                                <button class="book-btn btn-danger" disabled>
                                                    Pengembalian Ditolak
                                                </button>
                                            @elseif ($isPeminjamanDitolak)
                                                <button class="add-to-cart bg-dark" disabled>
                                                    Peminjaman Ditolak
                                                </button>
                                            @elseif ($pinjam->status == 'menunggu_pengembalian')
                                                <button class="add-to-cart bg-warning text-dark" disabled>
                                                    Menunggu Konfirmasi
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="add-to-cart {{ $selisih < 0 ? 'bg-danger text-white' : '' }}"
                                                    onclick="window.location.href='{{ url('/anggota/pengembalian?id_buku=' . $pinjam->id_buku) }}'">
                                                    Kembalikan Buku
                                                </button>
                                            @endif
                                        </figure>
                                        <figcaption>
                                            <h3>{{ $pinjam->buku->judul_buku ?? '-' }}</h3>

                                            @if ($isPengembalianDitolak)
                                                <small class="text-danger d-block">
                                                    ⚠️ Pengembalian ditolak
                                                </small>
                                            @else
                                                @if ($selisih > 1)
                                                    <small class="text-success d-block">
                                                        ⏳ Sisa waktu {{ $selisih }} hari lagi
                                                    </small>
                                                @elseif ($selisih == 1)
                                                    <small class="text-warning d-block">
                                                        ⚠️ Sisa waktu 1 hari lagi
                                                    </small>
                                                @elseif ($selisih == 0)
                                                    <small class="text-warning d-block fw-bold">
                                                        ⚠️ Hari ini batas terakhir!
                                                    </small>
                                                @else
                                                    @php
                                                        $hariTelat = abs($selisih);
                                                        $denda = $hariTelat * 1000;
                                                    @endphp

                                                    <small class="text-danger d-block fw-bold">
                                                        🚨 Telat {{ $hariTelat }} hari • Rp
                                                        {{ number_format($denda, 0, ',', '.') }}
                                                    </small>
                                                @endif
                                            @endif

                                            <span>{{ $pinjam->buku->penulis ?? '-' }}</span>

                                            <div class="mt-2">
                                                @if ($isPengembalianDitolak)
                                                    <span class="badge bg-danger">Pengembalian Ditolak</span>
                                                @elseif ($isPeminjamanDitolak)
                                                    <span class="badge bg-dark">Peminjaman Ditolak</span>
                                                @elseif ($pinjam->status == 'menunggu_pengembalian')
                                                    <span class="badge bg-info">Menunggu Konfirmasi</span>
                                                @elseif ($pinjam->status == 'dikembalikan')
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                @else
                                                    @if ($selisih < 0)
                                                        <span class="badge bg-danger">
                                                            Terlambat {{ abs($selisih) }} hari 🚨 | Rp
                                                            {{ number_format(abs($selisih) * 1000, 0, ',', '.') }}
                                                        </span>
                                                    @elseif ($selisih == 0)
                                                        <span class="badge bg-warning text-dark">
                                                            Hari ini batas terakhir ⚠️
                                                        </span>
                                                    @elseif ($selisih == 1)
                                                        <span class="badge bg-warning text-dark">
                                                            Besok harus dikembalikan ⏳
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            Dipinjam
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>

                                            @if (!$isPengembalianDitolak)
                                                <small class="d-block mt-1 text-muted">
                                                    Wajib kembali:
                                                    {{ \Carbon\Carbon::parse($pinjam->wajib_kembali)->translatedFormat('d M Y') }}
                                                </small>
                                            @endif
                                        </figcaption>
                                    </div>
                                </div>




                            @empty
                                <p class="text-center">Belum ada buku yang dipinjam</p>
                            @endforelse


                        </div><!--ft-books-slider-->
                    </div><!--grid-->


                </div><!--inner-content-->
            </div>


        </div>
    </section>
    <section class="bg-white" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="container">

            <div class="section-header align-center">
                <div class="title">
                    <span>Riwayat Peminjaman</span>
                </div>
                <h2 class="section-title">History Buku</h2>
            </div>

            <div class="row">
                @forelse ($history as $item)
                    <div class="col-md-3">
                        <div class="product-item">
                            <figure class="product-style">
                                <img src="{{ asset('storage/' . $item->buku->cover) }}" class="product-item">
                            </figure>

                            <figcaption>
                                <h3>{{ $item->buku->judul_buku }}</h3>
                                <span>{{ $item->buku->penulis }}</span>

                                <div class="mt-2">

                                    @if ($item->status == 'ditolak')
                                        <span class="badge bg-dark">Peminjaman Ditolak</span>
                                    @elseif ($item->status == 'dikembalikan')
                                        @if ($item->pengembalian && $item->pengembalian->status == 'ditolak')
                                            <span class="badge bg-danger">Pengembalian Ditolak</span>
                                        @elseif ($item->pengembalian && $item->pengembalian->status == 'terlambat')
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    @elseif ($item->status == 'menunggu_pengembalian')
                                        <span class="badge bg-info">Menunggu Konfirmasi</span>
                                    @endif

                                </div>
                                <small class="d-block mt-1 text-muted">
                                    Pinjam:
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </small>

                                <small class="d-block text-muted">
                                    Kembali:
                                    {{ optional($item->pengembalian)->tanggal_kembali
                                        ? \Carbon\Carbon::parse(optional($item->pengembalian)->tanggal_kembali)->translatedFormat('d M Y')
                                        : '-' }}
                                </small>
                                @if ($item->pengembalian && $item->pengembalian->denda > 0)
                                    <div class="badge bg-danger mt-2">
                                        Denda Rp {{ number_format($item->pengembalian->denda, 0, ',', '.') }}
                                    </div>
                                @endif

                            </figcaption>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Belum ada riwayat peminjaman</p>
                @endforelse
            </div>

        </div>
    </section>
    <style>
        .book-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 12px;

            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;

            border: none;
            border-radius: 6px;

            transition: all 0.3s ease;
            text-align: center;
        }

        /* warna */
        .book-btn.btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .book-btn.btn-dark {
            background: #212529;
            color: #fff;
        }

        .book-btn.btn-warning {
            background: #ffc107;
            color: #000;
        }

        .book-btn.btn-primary {
            background: #222;
            color: #fff;
        }

        /* hover ala booksaw */
        .book-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .profile-card:hover {
            transform: translateY(-4px);
        }

        .data-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
        }

        .profile-img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f1f1f1;
        }

        label {
            font-size: 13px;
            color: #888;
            margin-bottom: 3px;
            display: block;
        }

        .data-value {
            font-size: 15px;
            font-weight: 500;
            color: #2c2c2c;
        }

        /* NEW */
        .stat-box {
            background: #fafafa;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #eee;
            transition: 0.2s;
        }

        .stat-box:hover {
            background: #f1f1f1;
        }

        .stat-box h4 {
            margin: 0;
            font-weight: 600;
            color: #2c2c2c;
        }

        .stat-box small {
            color: #888;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
