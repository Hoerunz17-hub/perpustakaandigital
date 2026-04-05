<header id="header">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2">
                <div class="main-logo">
                    <a href="index.html"><img src="{{ asset('assetsfrontend/images/main-logo.png') }}" alt="logo"></a>
                </div>

            </div>

            <div class="col-md-10">

                <nav id="navbar">
                    <div class="main-menu stellarnav">
                        <ul class="menu-list">

                            <li
                                class="menu-item {{ request()->is('/') || request()->is('buku/show/*') ? 'active' : '' }}">
                                <a href="/">Home</a>
                            </li>

                            <li class="menu-item {{ request()->is('anggota/peminjaman') ? 'active' : '' }}">
                                <a href="/anggota/peminjaman">Peminjaman</a>
                            </li>

                            <li
                                class="menu-item {{ request()->is('bukusaya*') || request()->is('anggota/pengembalian*') ? 'active' : '' }}">
                                <a href="/bukusaya">Buku Saya</a>
                            </li>

                        </ul>

                        <div class="hamburger">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </div>

                    </div>
                </nav>

            </div>

        </div>
    </div>
</header>
