@extends('layout.frontend.app')

@section('content')
    <section class="bg-white" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="borrow-card p-4">

                        <h3 class="mb-4 text-center">Form Pengembalian Buku</h3>

                        <form action="/anggota/pengembalian/store" method="POST" id=""
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

                                @if (isset($selectedBuku))
                                    {{-- MODE DARI DETAIL (AUTO SELECT, TANPA DROPDOWN) --}}

                                    <input type="hidden" name="id_buku" value="{{ $selectedBuku }}">

                                    @php
                                        $selectedBook = $buku->where('id_buku', $selectedBuku)->first();
                                    @endphp

                                    <input type="text" class="form-control"
                                        value="{{ $selectedBook ? $selectedBook->judul_buku : 'Kamu belum meminjam buku' }}"
                                        readonly>
                                    <small class="text-muted">Buku sudah dipilih dari halaman sebelumnya</small>
                                @else
                                    {{-- MODE MANUAL (DROP DOWN) --}}
                                    @if ($buku->isEmpty())
                                        <div class="alert alert-warning">
                                            Kamu tidak sedang meminjam buku
                                        </div>
                                    @else
                                        <select name="id_buku" id="pilih_buku" onchange="filterBuku(this.value)"
                                            class="form-control" required>

                                            <option value="">-- Pilih Buku --</option>

                                            @foreach ($buku as $item)
                                                <option value="{{ $item->id_buku }}">
                                                    {{ $item->judul_buku }}
                                                </option>
                                            @endforeach

                                        </select>
                                    @endif
                                @endif
                            </div>

                            <!-- Tanggal Pinjam (hidden aja) -->
                            <input type="hidden" name="tanggal_pinjam" id="tanggal_pinjam">

                            <!-- Tanggal Wajib Kembali -->
                            <div class="mb-4">
                                <label class="form-label">Tanggal Wajib Kembali</label>
                                <input type="hidden" name="wajib_kembali" id="wajib_kembali"
                                    value="{{ $detailPinjam ? \Carbon\Carbon::parse($detailPinjam->wajib_kembali)->format('Y-m-d') : '' }}">

                                <input type="date" class="form-control" id="wajib_kembali_view"
                                    value="{{ $detailPinjam ? \Carbon\Carbon::parse($detailPinjam->wajib_kembali)->format('Y-m-d') : '' }}"
                                    readonly>
                            </div>
                            <!-- Tanggal Kembali (otomatis hari ini) -->
                            <div class="mb-4">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                    readonly>
                            </div>

                            <!-- Status -->
                            <div id="hasil_pengembalian" style="display: none;">

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status Pengembalian</label>
                                    <input type="text" class="form-control" id="status_pengembalian" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kondisi Buku</label>
                                    <select name="kondisi_buku" id="kondisi_buku" class="form-control" required>
                                        <option value="normal">Normal</option>
                                        <option value="rusak">Rusak (Denda Rp 50.000)</option>
                                        <option value="hilang">Hilang (Denda Rp 30.000)</option>
                                    </select>
                                </div>

                                <!-- Denda -->
                                <div class="mb-3">
                                    <label class="form-label">Denda</label>
                                    <input type="text" class="form-control" id="denda" name="denda" readonly>
                                </div>

                                <!-- NOTE -->
                                <small id="note_denda"></small>

                            </div>

                            <!-- Button -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-pinjam"
                                    @guest onclick="confirmLogin(); return false;" @endguest>
                                    kembalikan
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
        document.addEventListener("DOMContentLoaded", function() {

            let today = new Date().toISOString().split('T')[0];
            document.getElementById("tanggal_kembali").value = today;

            let wajibInput = document.getElementById("wajib_kembali");
            let hasilDiv = document.getElementById("hasil_pengembalian");

            let dendaInput = document.getElementById("denda");
            let statusInput = document.getElementById("status_pengembalian");
            let note = document.getElementById("note_denda");
            let kondisiSelect = document.getElementById("kondisi_buku");

            function hitungDenda() {
                if (!wajibInput.value) return;

                let today = new Date().toISOString().split('T')[0];

                let wajib = new Date(wajibInput.value);
                let kembali = new Date(today);

                let selisihHari = Math.floor((kembali - wajib) / (1000 * 60 * 60 * 24));

                hasilDiv.style.display = "block";

                let denda = 0;

                // Denda keterlambatan
                if (selisihHari > 0) {
                    denda += selisihHari * 1000;
                    statusInput.value = "Terlambat";
                } else {
                    statusInput.value = "Tepat Waktu";
                }

                // 🔥 TAMBAHAN: kondisi buku
                let kondisi = kondisiSelect.value;

                if (kondisi === "rusak") {
                    denda += 50000;
                } else if (kondisi === "hilang") {
                    denda += 30000;
                }

                // format rupiah
                let formatted = denda.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                dendaInput.value = formatted;

                note.className = "fw-bold";
                if (denda > 0) {
                    note.className = "text-danger fw-bold";
                    note.innerText = `Total Denda: Rp ${formatted}`;
                } else {
                    note.className = "text-success fw-bold";
                    note.innerText = "Tidak ada denda Madepp";
                }
            }

            // trigger saat ganti kondisi
            kondisiSelect.addEventListener("change", hitungDenda);
            document.getElementById("pilih_buku")?.addEventListener("change", function() {
                setTimeout(hitungDenda, 500);
            });
            // jalankan kalau sudah ada data
            if (wajibInput.value) {
                hitungDenda();
            }

        });
    </script>
    <script>
        function filterBuku(id_buku) {
            window.location.href = "?id_buku=" + id_buku;
        }
    </script>

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
