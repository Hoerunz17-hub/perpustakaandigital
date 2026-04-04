@extends('layout.frontend.app')

@section('content')
    <section class="py-5" style="background:#f8f5f2;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="borrow-card p-4">

                        <h3 class="mb-4 text-center">Form Peminjaman Buku</h3>
                        @if (isset($totalPinjam) && $totalPinjam >= 3)
                            <div class="alert alert-warning">
                                ⚠️ Kamu sudah meminjam <b>3 buku</b><br>
                                Silakan kembalikan buku terlebih dahulu sebelum meminjam lagi
                            </div>
                        @endif
                        {{-- ALERT ERROR --}}
                        @if (session('error'))
                            <div class="alert alert-danger">
                                ❌ {{ session('error') }}
                            </div>
                        @endif
                        <form action="/anggota/peminjaman/store" method="POST" id="formPinjam"
                            @guest onsubmit="confirmLogin(); return false;" @endguest>
                            @csrf

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

                                @if ($buku->isEmpty())
                                    {{-- ❌ KALAU BUKU KOSONG --}}
                                    <div class="alert alert-warning">
                                        Buku sedang tidak tersedia / stok habis
                                    </div>
                                @elseif (isset($selectedBuku))
                                    {{-- MODE DARI DETAIL --}}
                                    <input type="hidden" name="id_buku" value="{{ $selectedBuku }}">

                                    @php
                                        $selectedBook = $buku->where('id_buku', $selectedBuku)->first();
                                    @endphp

                                    <input type="text" class="form-control"
                                        value="{{ $selectedBook ? $selectedBook->judul_buku : 'Buku tidak ditemukan' }}"
                                        readonly>

                                    <small class="text-muted">Buku sudah dipilih dari halaman sebelumnya</small>
                                @else
                                    {{-- ✅ NORMAL DROPDOWN --}}
                                    <select name="id_buku" id="pilih_buku" class="form-control" required
                                        @guest onclick="confirmLogin()" disabled @endguest
                                        {{ isset($totalPinjam) && $totalPinjam >= 3 ? 'disabled' : '' }}>

                                        <option value="">-- Pilih Buku --</option>

                                        @foreach ($buku as $item)
                                            <option value="{{ $item->id_buku }}">
                                                {{ $item->judul_buku }}
                                            </option>
                                        @endforeach

                                    </select>
                                @endif
                            </div>

                            <!-- Tanggal Pinjam (hidden aja) -->
                            <input type="hidden" name="tanggal_pinjam" id="tanggal_pinjam">

                            <!-- Tanggal Wajib Kembali -->
                            <div class="mb-4">
                                <label class="form-label">Tanggal Wajib Kembali</label>
                                <input type="date" class="form-control" id="wajib_kembali_view" readonly>
                                <input type="hidden" name="wajib_kembali" id="wajib_kembali">
                            </div>
                            <div id="note_peminjaman" class="alert alert-info d-none mt-2">
                                📌 Buku harus dikembalikan maksimal <b>3 hari</b><br>
                                📌 Keterlambatan akan dikenakan denda
                            </div>

                            <!-- Button -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-pinjam"
                                    @guest onclick="confirmLogin(); return false;" @endguest
                                    {{ isset($totalPinjam) && $totalPinjam >= 3 ? 'disabled' : '' }}>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogin() {
            Swal.fire({
                icon: 'warning',
                title: 'Harus Login!',
                text: 'Silahkan login atau daftar dulu untuk meminjam buku',
                confirmButtonText: 'Login Sekarang',
                confirmButtonColor: '#c59d5f'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/loginuser";
                }
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let selectBuku = document.getElementById('pilih_buku');

            // format yyyy-mm-dd
            let formatDate = (date) => {
                return date.toISOString().split('T')[0];
            };

            selectBuku.addEventListener('change', function() {

                if (this.value !== "") {

                    let today = new Date();

                    let tanggalPinjam = formatDate(today);
                    document.getElementById('tanggal_pinjam').value = tanggalPinjam;

                    let kembali = new Date();
                    kembali.setDate(today.getDate() + 3);

                    let wajibKembali = formatDate(kembali);

                    document.getElementById('wajib_kembali').value = wajibKembali;
                    document.getElementById('wajib_kembali_view').value = wajibKembali;

                    // 🔥 TAMPILKAN NOTE
                    document.getElementById('note_peminjaman').classList.remove('d-none');
                } else {
                    // kalau balik ke kosong, note hilang lagi
                    document.getElementById('note_peminjaman').classList.add('d-none');
                }
            });

        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false, // ❌ gak ada tombol OK
                timer: 3000 // ⏱ auto hilang 2 detik
            });
        </script>
    @endif
    @if (isset($selectedBuku))
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let today = new Date();

                let formatDate = (date) => {
                    return date.toISOString().split('T')[0];
                };

                let tanggalPinjam = formatDate(today);
                document.getElementById('tanggal_pinjam').value = tanggalPinjam;

                let kembali = new Date();
                kembali.setDate(today.getDate() + 3);

                let wajibKembali = formatDate(kembali);

                document.getElementById('wajib_kembali').value = wajibKembali;
                document.getElementById('wajib_kembali_view').value = wajibKembali;
                document.getElementById('note_peminjaman').classList.remove('d-none');
            });
        </script>
    @endif
@endsection
