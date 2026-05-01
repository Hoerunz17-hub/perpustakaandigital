@extends('layout.frontend.app')
@section('content')
    <!-- Modern Billboard Carousel -->
    <section id="billboard" class="mb-5 mt-4">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-pause="hover">
            <div class="carousel-indicators mb-4">
                @forelse ($slider_books as $index => $book)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }} bg-dark" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" style="width: 12px; height: 12px; border-radius: 50%;"></button>
                @empty
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active bg-dark" aria-current="true" aria-label="Slide 1"></button>
                @endforelse
            </div>
            
            <div class="carousel-inner shadow-lg rounded-5 overflow-hidden mx-auto" style="max-width: 95%; background: radial-gradient(circle at 80% 50%, #fdfbfb 0%, #e2ebf0 100%); border: 1px solid rgba(255,255,255,0.5);">
                
                @forelse ($slider_books as $index => $book)
                <!-- Slide {{ $index + 1 }} -->
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="5000">
                    <div class="row align-items-center" style="min-height: 480px;">
                        <div class="col-md-6 p-5 px-md-5 text-center text-md-start z-1">
                            <div class="d-inline-flex align-items-center badge bg-dark bg-opacity-10 text-dark px-3 py-2 rounded-pill mb-4 hero-title" style="font-weight: 600;">
                                <span class="bg-warning rounded-circle me-2" style="width: 10px; height: 10px;"></span> Koleksi Terbaru
                            </div>
                            <h1 class="display-4 fw-bold mb-3 hero-title text-dark" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">{{ $book->judul_buku }}</h1>
                            <p class="lead mb-4 hero-subtitle text-secondary" style="max-width: 90%; font-size: 1.15rem;">
                                Karya luar biasa dari <strong class="text-dark">{{ $book->penulis }}</strong>. {{ $book->stock > 0 ? 'Buku ini tersedia dan siap untuk menemani waktu luang Anda.' : 'Sedang ramai dipinjam, nantikan ketersediaannya.' }}
                            </p>
                            <a href="{{ url('/buku/show/' . $book->id_buku) }}" class="btn btn-dark btn-lg rounded-pill fw-bold px-5 py-3 shadow hero-btn transition-hover mt-2">
                                Mulai Membaca <i class="icon icon-ns-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-md-6 text-center position-relative h-100 d-flex justify-content-center align-items-center py-5 d-none d-md-flex">
                            <!-- Artistic Background Element -->
                            <div class="position-absolute bg-primary bg-opacity-10 rounded-circle" style="width: 400px; height: 400px; filter: blur(60px); z-index: 0; right: 10%; top: 10%;"></div>
                            <div class="position-absolute bg-warning bg-opacity-20 rounded-circle" style="width: 300px; height: 300px; filter: blur(60px); z-index: 0; left: 10%; bottom: 10%;"></div>
                            
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul_buku }}" class="img-fluid rounded-3 z-1 book-3d-effect transition-zoom" style="max-height: 380px; object-fit: cover; box-shadow: -20px 20px 40px rgba(0,0,0,0.15);">
                        </div>
                    </div>
                </div>
                @empty
                <!-- Fallback Slide -->
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="row align-items-center" style="min-height: 480px;">
                        <div class="col-12 p-5 text-center z-1">
                            <h1 class="display-4 fw-bold mb-3 hero-title text-dark">Selamat Datang di RakBuku</h1>
                            <p class="lead mb-4 hero-subtitle text-secondary">Temukan ribuan koleksi buku digital bacaan favoritmu.</p>
                        </div>
                    </div>
                </div>
                @endforelse

            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 5%;">
                <span class="carousel-control-prev-icon p-3 rounded-circle bg-dark bg-opacity-25" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 5%;">
                <span class="carousel-control-next-icon p-3 rounded-circle bg-dark bg-opacity-25" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section id="popular-books" class="bookshelf bg-white" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <div class="title">
                            <span>Katalog Buku</span>
                        </div>

                        <h2 class="section-title">Semua Buku</h2>

                        <div class="search-wrapper mt-3">
                            <div class="search-box">
                                <input id="searchInput" type="text" placeholder="Cari buku...">
                            </div>
                        </div>
                    </div>

                    <ul class="tabs">
                        <li class="tab active" data-kategori="all">Semua Buku</li>
                        <li class="tab" data-kategori="fiksi">fiksi</li>
                        <li class="tab" data-kategori="romance">romance</li>
                        <li class="tab" data-kategori="action">action</li>
                        <li class="tab" data-kategori="pendidikan">Pendidikan</li>

                    </ul>

                    <div class="tab-content">
                        <div id="all-genre" data-tab-content class="active">
                            <div class="row">
                                @foreach ($buku as $item)
                                    <div class="col-md-3 book-item" data-kategori="{{ strtolower($item->kategori) }}">
                                        <div class="product-item {{ $item->stock == 0 ? 'out-of-stock' : '' }}">

                                            <figure class="product-style">
                                                <img src="{{ asset('storage/' . $item->cover) }}" alt="Books"
                                                    class="product-item">

                                                @if ($item->stock > 0)
                                                    <button type="button" class="add-to-cart"
                                                        onclick="window.location.href='{{ url('/buku/show/' . $item->id_buku) }}'">
                                                        Lihat detail buku
                                                    </button>
                                                @else
                                                    <button type="button" class="add-to-cart disabled-btn" disabled>
                                                        Stok Habis
                                                    </button>
                                                    <div class="overlay">Habis</div>
                                                @endif
                                            </figure>

                                            <figcaption>
                                                <h3 class="book-title">{{ $item->judul_buku }}</h3>
                                                <span>{{ $item->penulis }}</span>
                                                <div class="item-price">
                                                    Stock {{ $item->stock }}
                                                </div>
                                            </figcaption>

                                        </div>
                                    </div>
                                @endforeach




                            </div>


                        </div>











                    </div>

                </div><!--inner-tabs-->

            </div>
        </div>
    </section>

    <section id="featured-books" class="py-5 my-5 mx-auto" style="max-width: 95%; background-color: #0f172a; border-radius: 2rem;">
		<div class="container-fluid px-md-5 py-5">
			<div class="row align-items-end mb-5">
                <div class="col-md-8">
                    <span class="text-warning fw-bold mb-2 d-inline-block" style="letter-spacing: 3px; text-transform: uppercase; font-size: 0.85rem;"><i class="icon icon-star"></i> Peringkat Teratas Pilihan Pembaca</span>
                    <h2 class="display-4 fw-bold mb-0 text-white" style="font-family: 'Playfair Display', Georgia, serif;">Terpopuler Minggu Ini</h2>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <a href="#popular-books" class="btn btn-outline-light rounded-pill fw-bold px-4 py-2 transition-hover text-uppercase" style="letter-spacing: 1px;">Jelajahi Semua <i class="icon icon-ns-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @forelse ($popular_books as $index => $book)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card border-0 rounded-4 overflow-hidden position-relative group-hover-container shadow-lg h-100 w-100 transition-hover" style="min-height: 400px; background-color: #1e293b;">
                        
                        <!-- Background Cover -->
                        <div class="position-absolute top-0 start-0 w-100 h-100">
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku" class="w-100 h-100 transition-zoom" style="object-fit: cover; filter: brightness(0.65) contrast(1.1);">
                        </div>
                        
                        <!-- Top Badges -->
                        <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between p-3 z-3">
                            <!-- Rank -->
                            <div class="badge bg-danger rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 45px; height: 45px; font-size: 1.2rem; font-family: 'Georgia', serif; font-style: italic;">
                                #{{ $index + 1 }}
                            </div>
                            <!-- Pinjam Count -->
                            <div class="badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-2 d-flex align-items-center" style="backdrop-filter: blur(4px);">
                                <i class="icon icon-star text-warning me-1"></i> {{ $book->peminjaman_count }} Pinjam
                            </div>
                        </div>

                        <!-- Content Overlay -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-4 z-3" style="background: linear-gradient(to top, rgba(15,23,42,1) 0%, rgba(15,23,42,0.85) 50%, transparent 100%);">
                            <h3 class="h4 fw-bold text-white mb-1 text-truncate" title="{{ $book->judul_buku }}">{{ $book->judul_buku }}</h3>
                            <p class="text-light small mb-3 opacity-75 fst-italic">{{ $book->penulis }}</p>
                            
                            <!-- Action Detail Hover/Stock -->
                            <div class="mt-3 action-btn-container transition-hover">
                                @if ($book->stock > 0)
                                    <button type="button" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm" onclick="window.location.href='{{ url('/buku/show/' . $book->id_buku) }}'">
                                        Lihat & Pinjam <i class="icon icon-ns-arrow-right ms-1"></i>
                                    </button>
                                @else
                                    <div class="alert alert-danger mb-0 py-2 text-center rounded-pill fw-bold" style="font-size: 0.85rem;">
                                        Stok Sedang Habis
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-5 text-white">
                    <i class="icon icon-books fs-1 d-block mb-3 text-secondary opacity-50" style="font-size: 4rem;"></i>
                    <h5 class="text-light">Belum ada buku populer saat ini.</h5>
                </div>
                @endforelse
            </div>
		</div>
	</section>
    <style>
        /* Hero Carousel Animations & Styles */
        .hero-title { opacity: 0; transform: translateY(-20px); transition: all 1.2s cubic-bezier(0.165, 0.84, 0.44, 1) 0.3s; }
        .hero-subtitle { opacity: 0; transform: translateY(20px); transition: all 1.2s cubic-bezier(0.165, 0.84, 0.44, 1) 0.5s; }
        .hero-btn { opacity: 0; transform: translateY(15px); transition: all 1s ease 0.7s; }
        .book-3d-effect { transform: perspective(1000px) rotateY(-15deg) translateY(10px); transition: all 1.5s cubic-bezier(0.165, 0.84, 0.44, 1) 0.2s; opacity: 0; }
        
        .carousel-item.active .hero-title,
        .carousel-item.active .hero-subtitle,
        .carousel-item.active .hero-btn {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .carousel-item.active .book-3d-effect {
            opacity: 1;
            transform: perspective(1000px) rotateY(-15deg) translateY(0);
        }
        
        /* Book Cards Modern UI */
        .transition-hover { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); top: 0; }
        .transition-hover:hover { transform: translateY(-10px); }
        .bg-transparent:hover .card-img-top { border-radius: 1rem !important; box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important; }
        
        .transition-zoom { transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .group-hover-container:hover .transition-zoom { transform: scale(1.05); }
        
        .hover-overlay-action {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            opacity: 0;
            backdrop-filter: blur(3px);
            transition: all 0.4s ease;
        }
        .group-hover-container:hover .hover-overlay-action { opacity: 1; }
        
        /* Original Product Overlays fixed */

        .search-wrapper {
            display: flex;
            justify-content: center;
        }

        .search-box {
            width: 500px;
        }

        .search-box input {
            width: 100%;
            height: 45px;
            padding: 0 20px;
            /* gak perlu space kiri lagi */
            border-radius: 50px;
            border: 1px solid #aaa;
            background-color: #f8f8f8;
            outline: none;
            transition: 0.3s;
        }

        .search-box input:focus {
            outline: none;
        }

        .out-of-stock {
            position: relative;
            opacity: 0.6;
        }

        .out-of-stock img {
            filter: grayscale(100%);
        }

        .disabled-btn {
            background: #999 !important;
            cursor: not-allowed;
        }

        .overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const books = document.querySelectorAll('.book-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {

                // hapus active semua
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                let kategori = this.getAttribute('data-kategori');

                books.forEach(book => {
                    let bookKategori = book.getAttribute('data-kategori');

                    if (kategori === 'all' || bookKategori === kategori) {
                        book.style.display = "block";
                    } else {
                        book.style.display = "none";
                    }
                });
            });
        });
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            let activeTab = document.querySelector('.tab.active').getAttribute('data-kategori');

            document.querySelectorAll('.book-item').forEach(function(book) {
                let title = book.querySelector('h3').innerText.toLowerCase();
                let kategori = book.getAttribute('data-kategori');

                let cocokSearch = title.includes(keyword);
                let cocokKategori = (activeTab === 'all' || kategori === activeTab);

                if (cocokSearch && cocokKategori) {
                    book.style.display = "block";
                } else {
                    book.style.display = "none";
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#c59d5f'
            });
        </script>
    @endif
@endsection
