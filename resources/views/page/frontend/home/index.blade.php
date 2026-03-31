@extends('layout.frontend.app')
@section('content')
    <section id="popular-books" class="bookshelf py-5 my-5">
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
                        <li class="tab" data-kategori="kuliner">kuliner</li>
                        <li class="tab" data-kategori="religion">religion</li>
                        <li class="tab" data-kategori="action">action</li>
                        <li class="tab" data-kategori="sejarah">sejarah</li>
                    </ul>

                    <div class="tab-content">
                        <div id="all-genre" data-tab-content class="active">
                            <div class="row">
                                @foreach ($buku as $item)
                                    <div class="col-md-3 book-item" data-kategori="{{ strtolower($item->kategori) }}">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <img src="{{ asset('storage/' . $item->cover) }}" alt="Books"
                                                    class="product-item">
                                                <button type="button" class="add-to-cart" data-product-tile="add-to-cart"
                                                    onclick="window.location.href='{{ url('/buku/show/' . $item->id_buku) }}'">
                                                    Lihat detail buku
                                                </button>
                                            </figure>
                                            <figcaption>
                                                <h3 class="book-title">{{ $item->judul_buku }}</h3>
                                                <span>{{ $item->penulis }}</span>
                                                <div class="item-price">Stock {{ $item->stock }}</div>
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
    <style>
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
@endsection
