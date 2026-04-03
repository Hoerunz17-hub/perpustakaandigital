@extends('layout.frontend.app')
@section('content')
    @auth
        <section class="py-5" style="background: #f8f5f2;">
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
    <section id="featured-books" class="py-5 my-5">
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
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <figure class="product-style">
                                            <img src="{{ asset('storage/' . $pinjam->buku->cover) }}" alt="Books"
                                                class="product-item">
                                            <button type="button" class="add-to-cart" data-product-tile="add-to-cart"
                                                onclick="window.location.href='{{ url('/anggota/pengembalian?id_buku=' . $pinjam->id_buku) }}'">
                                                Kembalikan Buku
                                            </button>
                                        </figure>
                                        <figcaption>
                                            <h3>{{ $pinjam->buku->judul_buku ?? '-' }}</h3>
                                            <span>{{ $pinjam->buku->penulis ?? '-' }}</span>

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
    <style>
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
@endsection
