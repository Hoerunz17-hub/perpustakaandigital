  @extends('layout.backend.app')
  @section('content')
      <div class="page-heading">
          <div class="page-title">
              <div class="row">
                  <div class="col-12 col-md-6 order-md-1 order-last">
                      <h3>Detail Peminjaman</h3>
                      <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                  </div>
                  <div class="col-12 col-md-6 order-md-2 order-first">
                      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="/petugas/peminjaman">Peminjaman</a></li>
                              <li class="breadcrumb-item active" aria-current="page">detail</li>
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
          <section class="section">
              <div class="container-fluid">

                  {{-- CARD UTAMA --}}
                  <div class="card shadow-sm border-0 mb-4">
                      <div class="card-body">

                          <div class="row align-items-center">

                              {{-- FOTO --}}
                              <div class="col-md-2 text-center">
                                  @php
                                      use Illuminate\Support\Facades\Storage;
                                      $foto = $peminjaman->buku->cover ?? null;
                                  @endphp

                                  <img src="{{ $foto && Storage::disk('public')->exists($foto) ? Storage::url($foto) : asset('assets/images/book.png') }}"
                                      width="120" class="rounded shadow-sm">
                              </div>

                              {{-- INFO --}}
                              <div class="col-md-7">

                                  {{-- BARIS 1: BUKU + KODE --}}
                                  <div class="row mb-3">
                                      <div class="col-md-6">
                                          <small class="text-muted d-block">Buku</small>
                                          <div class="fw-bold fs-5">
                                              {{ $peminjaman->buku->judul_buku ?? '-' }}
                                          </div>
                                      </div>

                                      <div class="col-md-6">
                                          <small class="text-muted d-block">Kode Buku</small>
                                          <span class="badge bg-light text-dark border px-2 py-1">
                                              {{ $peminjaman->buku->kode_buku ?? '-' }}
                                          </span>
                                      </div>
                                  </div>

                                  {{-- BARIS 2: ANGGOTA + STATUS --}}
                                  <div class="row">
                                      <div class="col-md-6">
                                          <small class="text-muted d-block">Anggota</small>
                                          <div class="fw-semibold fs-5">
                                              {{ $peminjaman->anggota->nama_anggota ?? '-' }}
                                          </div>
                                      </div>

                                      <div class="col-md-6">
                                          <small class="text-muted d-block">Status</small>

                                          @php
                                              $status = $peminjaman->status;

                                              if ($peminjaman->pengembalian && $peminjaman->pengembalian->denda > 0) {
                                                  $status = 'terlambat';
                                              }
                                          @endphp

                                          @switch($status)
                                              @case('menunggu')
                                                  <span class="badge bg-warning px-2 py-1">Menunggu</span>
                                              @break

                                              @case('dipinjam')
                                                  <span class="badge bg-primary px-2 py-1">Dipinjam</span>
                                              @break

                                              @case('ditolak')
                                                  <span class="badge bg-secondary px-2 py-1">Ditolak</span>
                                              @break

                                              @case('terlambat')
                                                  <span class="badge bg-danger px-2 py-1">Terlambat</span>
                                              @break

                                              @case('dikembalikan')
                                                  <span class="badge bg-success px-2 py-1">Dikembalikan</span>
                                              @break
                                          @endswitch
                                      </div>
                                  </div>

                              </div>

                              {{-- ACTION --}}
                              <div class="col-md-3 text-md-end mt-3 mt-md-0">

                                  @if ($peminjaman->status == 'menunggu')
                                      <div class="d-flex justify-content-md-end gap-2">

                                          <a href="{{ route('peminjaman.acc', $peminjaman->id_peminjaman) }}"
                                              class="btn btn-success btn-sm">
                                              Acc
                                          </a>

                                          <a href="{{ route('peminjaman.tolak', $peminjaman->id_peminjaman) }}"
                                              class="btn btn-outline-danger btn-sm">
                                              Tolak
                                          </a>

                                      </div>
                                  @endif

                              </div>

                          </div>

                      </div>
                  </div>

                  {{-- DETAIL --}}
                  <div class="card shadow-sm border-0 mb-4">
                      <div class="card-header">
                          <h5 class="mb-0">Informasi Peminjaman</h5>
                      </div>

                      <div class="card-body">

                          <div class="row g-3">

                              <div class="col-md-4">
                                  <small class="text-muted">Tanggal Pinjam</small>
                                  <div class="fw-semibold">
                                      {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <small class="text-muted">Wajib Kembali</small>
                                  <div class="fw-semibold">
                                      {{ \Carbon\Carbon::parse($peminjaman->wajib_kembali)->translatedFormat('d F Y') }}
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <small class="text-muted">Tanggal Kembali</small>
                                  <div class="fw-semibold">
                                      {{ optional($peminjaman->pengembalian)->tanggal_kembali
                                          ? \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->translatedFormat('d F Y')
                                          : '-' }}
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <small class="text-muted">Denda</small>
                                  <div class="fw-semibold">
                                      {{ optional($peminjaman->pengembalian)->denda
                                          ? 'Rp ' . number_format($peminjaman->pengembalian->denda, 0, ',', '.')
                                          : '-' }}
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <small class="text-muted">Petugas</small>
                                  <div class="fw-semibold">
                                      {{ $peminjaman->petugas->nama_petugas ?? '-' }}
                                  </div>
                              </div>

                          </div>

                      </div>
                  </div>

                  {{-- TIMELINE --}}
                  <div class="card shadow-sm border-0 mb-4">
                      <div class="card-header">
                          <h5 class="mb-0">Timeline</h5>
                      </div>

                      <div class="card-body">

                          <ul class="list-unstyled">

                              <li class="mb-3">
                                  <strong>Diajukan</strong><br>
                                  <small class="text-muted">
                                      {{ \Carbon\Carbon::parse($peminjaman->created_at)->translatedFormat('d F Y H:i') }}
                                  </small>
                              </li>

                              @php
                                  $timelineStatus = $peminjaman->status;

                                  if ($peminjaman->pengembalian && $peminjaman->pengembalian->denda > 0) {
                                      $timelineStatus = 'terlambat';
                                  }
                              @endphp

                              <li class="mb-3">
                                  <strong>
                                      @switch($timelineStatus)
                                          @case('dipinjam')
                                              Disetujui
                                          @break

                                          @case('ditolak')
                                              Ditolak
                                          @break

                                          @case('menunggu')
                                              Menunggu Persetujuan
                                          @break

                                          @case('terlambat')
                                              Terlambat
                                          @break

                                          @case('dikembalikan')
                                              Dikembalikan
                                          @break

                                          @default
                                              -
                                      @endswitch
                                  </strong><br>
                                  <small class="text-muted">
                                      {{ $peminjaman->updated_at
                                          ? \Carbon\Carbon::parse($peminjaman->updated_at)->translatedFormat('d F Y H:i')
                                          : '-' }}
                                  </small>
                              </li>

                              <li>
                                  <strong>Pengembalian</strong><br>
                                  <small class="text-muted">
                                      {{ optional($peminjaman->pengembalian)->tanggal_kembali
                                          ? \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->translatedFormat('d F Y H:i')
                                          : '-' }}
                                  </small>
                              </li>

                          </ul>

                      </div>
                  </div>

                  {{-- BACK --}}
                  <a href="/petugas/peminjaman" class="btn btn-secondary btn-sm">
                      ← Kembali
                  </a>

              </div>
          </section>
      </div>
  @endsection
