<header id="header">
    <div class="container-fluid">
        <div class="row" style="min-height: 80px;">

            <div class="col-md-3 d-flex align-items-center">
                <div class="main-logo">
                    <a href="/" style="text-decoration: none;">
                        <h1 style="font-family: 'Playfair Display', serif; color: #222; font-size: 42px; letter-spacing: 1px; margin: 0;">
                            <strong style="font-weight: 800;">RAK</strong><span style="font-weight: 400;">BUKU</span>
                        </h1>
                    </a>
                </div>
            </div>

            <div class="col-md-9 d-flex align-items-center justify-content-end">

                <nav id="navbar" class="w-100">
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

    <style>
    /* Styling khusus Navbar agar terlihat lebih premium & estetis */
    @media (min-width: 992px) {
        .stellarnav > ul.menu-list {
            display: flex !important;
            justify-content: flex-end;
            align-items: center;
            gap: 35px;
            margin: 0;
        }
        
        .stellarnav > ul.menu-list > li.menu-item {
            margin: 0 !important;
        }

        .stellarnav > ul.menu-list > li.menu-item > a {
            font-family: 'Raleway', sans-serif;
            font-weight: 600 !important;
            font-size: 14px !important;
            letter-spacing: 1.5px;
            color: #444 !important;
            text-transform: uppercase;
            position: relative;
            padding: 8px 0 !important;
            background: transparent !important;
            transition: all 0.3s ease !important;
        }

        .stellarnav > ul.menu-list > li.menu-item.active > a,
        .stellarnav > ul.menu-list > li.menu-item > a:hover {
            color: #c59d5f !important;
        }

        /* Micro-animation (Underline Slide) ala modern web */
        .stellarnav > ul.menu-list > li.menu-item > a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #c59d5f;
            transition: width 0.3s ease;
        }

        .stellarnav > ul.menu-list > li.menu-item.active > a::after,
        .stellarnav > ul.menu-list > li.menu-item > a:hover::after {
            width: 100%;
        }
    }
    </style>
</header>
