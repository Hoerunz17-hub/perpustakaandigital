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
                                          <small class="text-muted d-block">Email</small>
                                          <div class="fw-semibold fs-5">
                                              {{ $peminjaman->anggota->email ?? '-' }}
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

                                              @case('menunggu_pengembalian')
                                                  <span class="badge bg-info px-2 py-1">Menunggu Konfirmasi Pengembalian</span>
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
                                  {{-- ✅ KONFIRMASI PEMINJAMAN --}}
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
                                  {{-- 🔁 KONFIRMASI PENGEMBALIAN --}}
                                  @if ($peminjaman->status == 'menunggu_pengembalian')
                                      <div class="d-flex justify-content-md-end gap-2">

                                          <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                              data-bs-target="#modalKembaliDetail{{ $peminjaman->id_peminjaman }}">
                                              Konfirmasi
                                          </button>

                                          <a href="{{ route('peminjaman.tolakKembali', $peminjaman->id_peminjaman) }}"
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
                          @php
                              use Carbon\Carbon;

                              $wajib = Carbon::parse($peminjaman->wajib_kembali);
                              $kembali = optional($peminjaman->pengembalian)->tanggal_kembali
                                  ? Carbon::parse($peminjaman->pengembalian->tanggal_kembali)
                                  : Carbon::today();

                              // 🔥 TELAT HARI
                              $telatHari = $kembali->gt($wajib) ? (int) $wajib->diffInDays($kembali) : 0;

                              // 🔥 DENDA TELAT (misal 1000/hari)
                              $dendaPerHari = 1000;
                              $dendaTelat = $telatHari * $dendaPerHari;

                              // 🔥 DENDA RUSAK / HILANG
                              $kondisi = optional($peminjaman->pengembalian)->kondisi_buku;

                              $dendaRusak = 0;

                              if ($kondisi == 'rusak') {
                                  $dendaRusak = 50000;
                              } elseif ($kondisi == 'hilang') {
                                  $dendaRusak = 100000;
                              }

                              // 🔥 TOTAL DENDA
                              $totalDenda = $dendaTelat + $dendaRusak;
                          @endphp
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

                              @if ($telatHari > 0 || $dendaRusak > 0)
                                  <div class="col-12">
                                      <small class="text-muted d-block mb-2">Rincian Denda</small>

                                      <div class="row g-3">

                                          {{-- TELAT --}}
                                          <div class="col-md-4">
                                              <div class="p-3 border rounded bg-light h-100">
                                                  <small class="text-muted">Keterlambatan</small>
                                                  <div class="fw-bold text-danger">
                                                      {{ $telatHari }} hari
                                                  </div>
                                                  <div>
                                                      Rp {{ number_format($dendaTelat, 0, ',', '.') }}
                                                  </div>
                                              </div>
                                          </div>

                                          {{-- RUSAK / HILANG --}}
                                          <div class="col-md-4">
                                              <div class="p-3 border rounded bg-light h-100">
                                                  <small class="text-muted">Kerusakan</small>
                                                  <div class="fw-bold text-danger">
                                                      @if ($kondisi == 'rusak')
                                                          Rusak
                                                      @elseif ($kondisi == 'hilang')
                                                          Hilang
                                                      @else
                                                          -
                                                      @endif
                                                  </div>
                                                  <div>
                                                      Rp {{ number_format($dendaRusak, 0, ',', '.') }}
                                                  </div>
                                              </div>
                                          </div>

                                          {{-- TOTAL --}}
                                          <div class="col-md-4">
                                              <div class="p-3 border rounded bg-danger text-white h-100">
                                                  <small>Total Denda</small>
                                                  <div class="fw-bold fs-5">
                                                      Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                                  </div>
                                              </div>
                                          </div>

                                      </div>
                                  </div>
                              @endif
                              <div class="col-md-4">
                                  <small class="text-muted">Kondisi Buku</small>
                                  <div class="fw-semibold">
                                      @php
                                          $kondisi = optional($peminjaman->pengembalian)->kondisi_buku;
                                      @endphp

                                      @if (!$kondisi)
                                          -
                                      @elseif ($kondisi == 'normal')
                                          <span class="badge bg-success">Normal</span>
                                      @elseif ($kondisi == 'rusak')
                                          <span class="badge bg-warning text-dark">Rusak</span>
                                      @elseif ($kondisi == 'hilang')
                                          <span class="badge bg-danger">Hilang</span>
                                      @endif
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

                                          @case('menunggu_pengembalian')
                                              Menunggu Konfirmasi Pengembalian
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
                  <div class="modal fade" id="modalKembaliDetail{{ $peminjaman->id_peminjaman }}" tabindex="-1">
                      <div class="modal-dialog">
                          <form action="{{ route('peminjaman.konfirmasiKembali', $peminjaman->id_peminjaman) }}"
                              method="POST">
                              @csrf

                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>

                                  <div class="modal-body">

                                      <p>
                                          Buku <b>{{ $peminjaman->buku->judul_buku ?? '-' }}</b> sudah dikembalikan?
                                      </p>

                                      {{-- KONDISI --}}
                                      <div class="mb-3">
                                          <label class="form-label">Kondisi Buku</label>
                                          <select name="kondisi_buku" id="kondisiDetail{{ $peminjaman->id_peminjaman }}"
                                              class="form-control kondisi-detail-select" required>
                                              <option value="normal">Normal</option>
                                              <option value="rusak">Rusak (50.000)</option>
                                              <option value="hilang">Hilang (100.000)</option>
                                          </select>
                                      </div>

                                      {{-- DENDA --}}
                                      <div class="mb-3">
                                          <label class="form-label">Denda</label>
                                          <input type="text" id="dendaDetail{{ $peminjaman->id_peminjaman }}"
                                              class="form-control" value="Rp 0" readonly>
                                      </div>

                                  </div>

                                  <div class="modal-footer">
                                      <a href="{{ route('peminjaman.tolakKembali', $peminjaman->id_peminjaman) }}"
                                          class="btn btn-danger">
                                          Tolak
                                      </a>

                                      <button type="submit" class="btn btn-success">
                                          Konfirmasi
                                      </button>
                                  </div>

                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </section>
      </div>

      <script>
          document.addEventListener('DOMContentLoaded', function() {

              document.querySelectorAll('.kondisi-detail-select').forEach(function(select) {

                  select.addEventListener('change', function() {

                      let id = this.id.replace('kondisiDetail', '');
                      let dendaInput = document.getElementById('dendaDetail' + id);

                      let denda = 0;

                      if (this.value === 'rusak') {
                          denda = 50000;
                      } else if (this.value === 'hilang') {
                          denda = 100000;
                      }

                      dendaInput.value = 'Rp ' + denda.toLocaleString('id-ID');
                  });

              });

          });
      </script>
  @endsection
