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
    <section id="active-loans-section" class="bg-white"
        style="padding-top: 100px; padding-bottom: 80px; position: relative; overflow: hidden;">
        <div class="loans-bg-accent"></div>
        <div class="container">
            <div class="section-header align-center mb-5" data-aos="fade-up">
                <div class="premium-badge mb-3">DURASI PINJAM AKTIF</div>
                <h2 class="section-title display-5 fw-bold mb-2" style="font-family: var(--heading-font);">Buku Sedang
                    Dipinjam</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Kelola koleksi yang sedang Anda baca. Pastikan untuk
                    mengembalikan buku tepat waktu untuk menjaga reputasi literasi Anda.</p>
            </div>

            <div class="row g-4 justify-content-center" id="active-loans-grid">
                @forelse ($peminjaman as $pinjam)
                    @php
                        $today = \Carbon\Carbon::today();
                        $wajib = \Carbon\Carbon::parse($pinjam->wajib_kembali)->startOfDay();
                        $isPengembalianDitolak = $pinjam->pengembalian && $pinjam->pengembalian->status == 'ditolak';
                        $isPeminjamanDitolak = $pinjam->status == 'ditolak';
                        $selisih = $today->diffInDays($wajib, false);

                        $borderClass = '';
                        $glowClass = '';
                        if ($selisih < 0) {
                            $borderClass = 'border-danger-premium';
                            $glowClass = 'glow-danger';
                        } elseif ($selisih <= 1) {
                            $borderClass = 'border-warning-premium';
                            $glowClass = 'glow-warning';
                        }
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 loan-card-wrapper">
                        <div class="premium-loan-card {{ $borderClass }}" data-tilt data-tilt-max="5"
                            data-tilt-speed="1000">
                            <div class="card-inner">
                                <div class="loan-cover-wrapper">
                                    <div class="loan-status-overlay">
                                        @if ($pinjam->status == 'dikembalikan')
                                            @if ($pinjam->pengembalian)
                                                @if ($pinjam->pengembalian->status == 'ditolak')
                                                    <span class="luminous-badge badge-ditolak">Return Ditolak</span>
                                                @elseif ($pinjam->pengembalian->kondisi_buku == 'hilang')
                                                    <span class="luminous-badge badge-ditolak">Buku Hilang</span>
                                                @elseif ($pinjam->pengembalian->kondisi_buku == 'rusak' && $pinjam->pengembalian->status == 'terlambat')
                                                    <span class="luminous-badge badge-warning">Rusak & Terlambat</span>
                                                @elseif ($pinjam->pengembalian->kondisi_buku == 'rusak')
                                                    <span class="luminous-badge badge-warning">Buku Rusak</span>
                                                @elseif ($pinjam->pengembalian->status == 'terlambat')
                                                    <span class="luminous-badge badge-terlambat">Terlambat</span>
                                                @else
                                                    <span class="luminous-badge badge-kembali">Dikembalikan</span>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    <img src="{{ asset('storage/' . $pinjam->buku->cover) }}"
                                        class="loan-book-img {{ $glowClass }}" alt="{{ $pinjam->buku->judul_buku }}">
                                </div>

                                <div class="loan-info">
                                    <h3 class="loan-title">{{ $pinjam->buku->judul_buku }}</h3>
                                    <span class="loan-author">{{ $pinjam->buku->penulis }}</span>

                                    <div
                                        class="loan-deadline-box {{ $selisih < 0 ? 'bg-soft-danger' : ($selisih <= 1 ? 'bg-soft-warning' : 'bg-soft-success') }}">
                                        @if ($selisih < 0)
                                            <div class="deadline-text text-danger">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                <span>Telat {{ abs($selisih) }} Hari</span>
                                            </div>
                                            <div class="fine-amount text-danger fw-bold">
                                                Rp {{ number_format(abs($selisih) * 1000, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div
                                                class="deadline-text {{ $selisih <= 1 ? 'text-warning' : 'text-success' }}">
                                                <i class="bi bi-calendar-check"></i>
                                                <span>{{ $selisih == 0 ? 'Hari Ini Terakhir' : $selisih . ' Hari Lagi' }}</span>
                                            </div>
                                            <div class="deadline-date opacity-75">
                                                {{ \Carbon\Carbon::parse($pinjam->wajib_kembali)->translatedFormat('d M Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="loan-actions mt-3">
                                        @if ($isPengembalianDitolak)
                                            <button class="btn-premium-action btn-danger-glow w-100" disabled>
                                                Tinjau Masalah
                                            </button>
                                        @elseif ($pinjam->status == 'menunggu_pengembalian')
                                            <button class="btn-premium-action btn-info-glow w-100" disabled>
                                                Proses Verifikasi...
                                            </button>
                                        @else
                                            <a href="{{ url('/anggota/pengembalian?id_buku=' . $pinjam->id_buku) }}"
                                                class="btn-premium-action {{ $selisih < 0 ? 'btn-danger-glow' : 'btn-primary-glow' }} w-100">
                                                <span>Kembalikan Buku</span>
                                                <i class="bi bi-arrow-right-short"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="empty-state-luxury bg-light">
                            <i class="bi bi-journal-x display-1 text-muted mb-4"></i>
                            <h4>Tidak Ada Pinjaman Aktif</h4>
                            <p class="text-muted">Rak bu
                                ku digital Anda sedang kosong. Yuk cari bacaan menarik!</p>
                            <a href="{{ url('/#popular-books') }}" class="btn btn-dark px-4 py-2 mt-3 rounded-pill">Lihat
                                Katalog</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <section class="history-dashboard-section"
        style="padding-top: 100px; padding-bottom: 150px; background: #fdfdfd; overflow: hidden;">
        <div class="container">

            <div class="section-header align-center mb-5" data-aos="fade-up">
                <div class="premium-badge mb-3">RIWAYAT PEMINJAMAN</div>
                <h2 class="section-title display-5 fw-bold mb-2" style="font-family: var(--heading-font);">History Koleksi
                    Saya</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Jejak literasi perjalanan membaca Anda yang
                    tersimpan secara aman dalam arsip digital kami.</p>
            </div>

            <div class="row g-4 justify-content-center" id="history-grid">
                @forelse ($history as $item)
                    <div class="col-xl-3 col-lg-4 col-md-6 history-card-wrapper">
                        <div class="premium-history-card" data-tilt data-tilt-max="7" data-tilt-speed="1000"
                            data-tilt-perspective="1000">
                            <div class="card-inner">
                                <!-- Book Cover Container -->
                                <div class="book-cover-wrapper">
                                    <div class="book-cover-glow"></div>
                                    <img src="{{ asset('storage/' . $item->buku->cover) }}" class="history-book-img"
                                        alt="{{ $item->buku->judul_buku }}">

                                    <!-- Status Badge Over Image -->
                                    <div class="status-overlay">
                                        @if ($item->status == 'ditolak')
                                            <span class="luminous-badge badge-ditolak">Ditolak</span>
                                        @elseif ($item->status == 'menunggu_pengembalian')
                                            <span class="luminous-badge badge-menunggu">Menunggu Konfirmasi</span>
                                        @elseif ($item->status == 'dikembalikan' && $item->pengembalian)
                                            @php
                                                $kondisi = $item->pengembalian->kondisi_buku;
                                                $statusKembali = $item->pengembalian->status;

                                                $isRusak = $kondisi == 'rusak';
                                                $isHilang = $kondisi == 'hilang';
                                                $isTerlambat = $statusKembali == 'terlambat';
                                            @endphp

                                            @if ($statusKembali == 'ditolak')
                                                <span class="luminous-badge badge-ditolak">Return Ditolak</span>

                                                {{--  TERLAMBAT --}}
                                            @elseif ($isTerlambat)
                                                <span class="luminous-badge badge-terlambat">
                                                    @if ($isHilang)
                                                        Hilang
                                                    @elseif ($isRusak)
                                                        Rusak
                                                    @endif
                                                    & Terlambat
                                                </span>

                                                {{--  HILANG --}}
                                            @elseif ($isHilang)
                                                <span class="luminous-badge badge-ditolak">Buku Hilang</span>

                                                {{--  RUSAK --}}
                                            @elseif ($isRusak)
                                                <span class="luminous-badge badge-warning">Buku Rusak</span>

                                                {{--  NORMAL --}}
                                            @else
                                                <span class="luminous-badge badge-kembali">Dikembalikan</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Card Info Body -->
                                <div class="history-info">
                                    <h3 class="history-title">{{ $item->buku->judul_buku }}</h3>
                                    <span class="history-author">{{ $item->buku->penulis }}</span>

                                    <div class="history-metadata-grid">
                                        <div class="meta-item">
                                            <div class="meta-content">
                                                <small>Pinjam</small>
                                                <span>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="meta-item border-start">
                                            <div class="meta-content">
                                                <small>Kembali</small>
                                                <span>
                                                    {{ optional($item->pengembalian)->tanggal_kembali
                                                        ? \Carbon\Carbon::parse(optional($item->pengembalian)->tanggal_kembali)->translatedFormat('d M Y')
                                                        : '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($item->pengembalian && $item->pengembalian->denda > 0)
                                        <div class="fine-banner-premium">

                                            <div class="fine-pulse"></div>

                                            <div class="d-flex flex-column">
                                                {{-- KETERANGAN --}}
                                                <span class="fine-text">
                                                    @php
                                                        $kondisi = $item->pengembalian->kondisi_buku ?? null;
                                                        $statusKembali = $item->pengembalian->status ?? null;

                                                        $isRusak = $kondisi == 'rusak';
                                                        $isHilang = $kondisi == 'hilang';
                                                        $isTerlambat = $statusKembali == 'terlambat';
                                                    @endphp

                                                    @if ($isHilang)
                                                        Hilang
                                                    @elseif ($isRusak)
                                                        Rusak
                                                    @endif

                                                    @if ($isTerlambat)
                                                        & Terlambat
                                                    @endif

                                                    @if (!$isRusak && !$isHilang && !$isTerlambat)
                                                        Denda
                                                    @endif
                                                </span>

                                                {{-- NOMINAL --}}
                                                <small class="text-danger fw-bold">
                                                    Rp {{ number_format($item->pengembalian->denda, 0, ',', '.') }}
                                                </small>
                                            </div>

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="empty-state-luxury">
                            <i class="icon-book-open display-1 text-light mb-4"></i>
                            <h4>Belum Ada Jejak Membaca</h4>
                            <p class="text-muted">Mulai petualangan barumu hari ini di katalog kami.</p>
                            <a href="{{ url('/#popular-books') }}"
                                class="btn btn-outline-primary px-4 py-2 mt-3 rounded-pill">Eksplor Buku</a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </section>
    <style>
        :root {
            --premium-gold: #C5A992;
            --premium-dark: #1a1a1a;
            --soft-bg: #fdfdfd;
        }

        /* GENERAL ACCENTS */
        .loans-bg-accent {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(197, 169, 146, 0.03) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        /* PREMIUM LOAN CARD */
        .premium-loan-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .premium-loan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            border-color: rgba(197, 169, 146, 0.2);
        }

        .border-danger-premium {
            border-color: rgba(255, 71, 87, 0.3) !important;
        }

        .border-warning-premium {
            border-color: rgba(255, 165, 2, 0.3) !important;
        }

        .loan-cover-wrapper {
            position: relative;
            padding: 20px 20px 0 20px;
        }

        .loan-status-overlay {
            position: absolute;
            top: 30px;
            right: 30px;
            z-index: 10;
        }

        .loan-book-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }

        .premium-loan-card:hover .loan-book-img {
            transform: scale(1.03);
        }

        .glow-danger {
            box-shadow: 0 12px 30px rgba(255, 71, 87, 0.2) !important;
        }

        .glow-warning {
            box-shadow: 0 12px 30px rgba(255, 165, 2, 0.2) !important;
        }

        .loan-info {
            padding: 12px 16px;
        }

        .loan-title {
            font-family: var(--heading-font);
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .loan-author {
            display: block;
            font-size: 0.8rem;
            color: #95a5a6;
            margin-bottom: 8px;
        }

        .loan-deadline-box {
            padding: 8px 12px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            margin-bottom: 8px;
        }

        .bg-soft-success {
            background: rgba(46, 213, 115, 0.08);
        }

        .bg-soft-warning {
            background: rgba(255, 165, 2, 0.08);
        }

        .bg-soft-danger {
            background: rgba(255, 71, 87, 0.08);
        }

        .deadline-text {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
        }

        .deadline-date {
            font-size: 0.7rem;
            font-weight: 600;
            opacity: 0.8;
        }

        /* PREMIUM ACTION BUTTON */
        .btn-premium-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary-glow {
            background: var(--premium-dark);
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-glow:hover {
            background: #000;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(197, 169, 146, 0.3);
        }

        .btn-danger-glow {
            background: #ff4757;
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(255, 71, 87, 0.2);
        }

        .btn-danger-glow:hover {
            background: #ff6b81;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(255, 71, 87, 0.4);
        }

        .btn-info-glow {
            background: #3498db;
            color: #fff !important;
            opacity: 0.8;
        }

        /* PULSE ANIMATION */
        .pulse-danger {
            animation: pulse-red-badge 2s infinite;
        }

        @keyframes pulse-red-badge {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 71, 87, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0);
            }
        }

        /* REUSING HISTORY STYLES OR SIMILAR MAPPINGS */
        .history-dashboard-section {
            background-image:
                radial-gradient(at 0% 0%, rgba(197, 169, 146, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(197, 169, 146, 0.05) 0px, transparent 50%);
        }

        .premium-badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(197, 169, 146, 0.15);
            color: #C5A992;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 3px;
            border-radius: 50px;
            text-transform: uppercase;
            border: 1px solid rgba(197, 169, 146, 0.3);
        }

        .premium-history-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            height: 100%;
            border: 1px solid rgba(240, 240, 240, 1);
            transform-style: preserve-3d;
        }

        .premium-history-card:hover {
            box-shadow: 0 20px 50px rgba(197, 169, 146, 0.15);
            border-color: rgba(197, 169, 146, 0.3);
        }

        .book-cover-wrapper {
            position: relative;
            padding: 20px 20px 0 20px;
            overflow: hidden;
            transform: translateZ(30px);
        }

        .book-cover-glow {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 50px;
            background: radial-gradient(circle, rgba(197, 169, 146, 0.2) 0%, transparent 70%);
            z-index: 1;
        }

        .history-book-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transition: transform 0.5s ease;
        }

        .premium-history-card:hover .history-book-img {
            transform: scale(1.02);
        }

        .status-overlay {
            position: absolute;
            top: 35px;
            right: 35px;
            z-index: 5;
        }

        .luminous-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge-kembali {
            background: rgba(46, 213, 115, 0.9);
            color: #fff;
            box-shadow: 0 0 15px rgba(46, 213, 115, 0.3);
        }

        .badge-menunggu {
            background: rgba(52, 152, 219, 0.9);
            color: #fff;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .badge-terlambat {
            background: rgba(255, 71, 87, 0.9);
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.3);
        }

        .badge-ditolak {
            background: rgba(47, 53, 66, 0.9);
            color: #fff;
            box-shadow: 0 0 15px rgba(47, 53, 66, 0.3);
        }

        .badge-warning {
            background: rgba(255, 165, 2, 0.9);
            color: #fff;
        }

        .history-info {
            padding: 15px 20px;
            transform: translateZ(20px);
        }

        .history-title {
            font-family: var(--heading-font);
            font-size: 1.15rem !important;
            margin-bottom: 5px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
        }

        .history-author {
            font-size: 0.85rem;
            color: rgba(161, 123, 92, 0.9);
            font-weight: 600;
            display: block;
            margin-bottom: 20px;
        }

        .history-metadata-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            /* Stack label and date vertically */
            align-items: center;
            /* Center them horizontally */
            text-align: center;
            flex: 1;
            /* Occupy equal space */
        }

        .meta-content {
            width: 100%;
        }

        .meta-content small {
            display: block;
            font-size: 11px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .meta-content span {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
            white-space: nowrap;
            /* Keep the date on one line */
        }

        .fine-banner-premium {
            margin-top: 20px;
            background: rgba(255, 71, 87, 0.05);
            border: 1px solid rgba(255, 71, 87, 0.1);
            padding: 8px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .fine-pulse {
            width: 8px;
            height: 8px;
            background: #ff4757;
            border-radius: 50%;
            animation: pulse-red 2s infinite;
        }

        .fine-text {
            color: #ff4757;
            font-size: 0.75rem;
            font-weight: 800;
        }

        @keyframes pulse-red {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(255, 71, 87, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0);
            }
        }

        .empty-state-luxury {
            background: #fff;
            padding: 60px;
            border-radius: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #f5f5f5;
        }

        /* Original Styles Kept or Modified */
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

        .data-value {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // GSAP Animations for Active Loans
            gsap.from(".loan-card-wrapper", {
                duration: 1.2,
                y: 50,
                opacity: 0,
                stagger: 0.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: "#active-loans-grid",
                    start: "top 85%",
                }
            });

            // GSAP Animations for History Cards
            gsap.from(".history-card-wrapper", {
                duration: 1,
                y: 60,
                opacity: 0,
                stagger: 0.15,
                ease: "power4.out",
                scrollTrigger: {
                    trigger: "#history-grid",
                    start: "top 85%",
                }
            });

            // Initialize Vanilla Tilt for all premium cards
            VanillaTilt.init(document.querySelectorAll(".premium-loan-card, .premium-history-card"), {
                max: 5,
                speed: 1000,
                glare: true,
                "max-glare": 0.15,
                perspective: 1500,
            });

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
        });
    </script>
@endsection
