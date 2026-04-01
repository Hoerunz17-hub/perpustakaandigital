<div class="top-content">
    <div class="container-fluid">
        <div class="row">

            <!-- Kolom kosong kiri -->
            <div class="col-md-6"></div>

            <!-- Kolom kanan -->
            <div class="col-md-6 text-right">
                <div class="right-element d-flex justify-content-end align-items-center">

                    @auth
                        <!-- SUDAH LOGIN -->
                        <div class="dropdown user-account for-buy">

                            <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->anggota && Auth::user()->anggota->image
                                    ? asset('storage/' . Auth::user()->anggota->image)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) }}"
                                    class="header-profile-img">
                                <span>{{ Auth::user()->username }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <span class="dropdown-item text-muted">
                                        Halo, {{ Auth::user()->username }}
                                    </span>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <form action="{{ route('logout.anggota') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            Logout
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    @else
                        <!-- BELUM LOGIN -->
                        <div class="auth-buttons d-flex align-items-center">

                            <a href="/loginuser" class="btn-login me-2">
                                Login
                            </a>

                            <a href="/registrasiuser" class="btn-register">
                                Daftar
                            </a>

                        </div>
                    @endauth

                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .btn-login {
        padding: 6px 16px;
        border: 1px solid #c59d5f;
        border-radius: 20px;
        color: #c59d5f;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-login:hover {
        background: #c59d5f;
        color: #fff;
    }

    .btn-register {
        padding: 6px 16px;
        background: #c59d5f;
        border-radius: 20px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-register:hover {
        background: #a88245;
    }

    .header-profile-img {
        width: 26px;
        height: 26px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 6px;
        border: 1px solid #eee;
    }

    .username-text {
        font-size: 14px;
        color: #333;
    }

    /* biar hover nya halus ala booksaw */
    .dropdown-toggle:hover .header-profile-img {
        opacity: 0.8;
    }
</style>
