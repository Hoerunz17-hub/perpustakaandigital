<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex align-items-center ms-auto">

                    <!-- 🔔 NOTIF -->
                    @if (auth()->check() && auth()->user()->role == 'petugas')
                        <!-- 🔔 NOTIF -->
                        <div class="dropdown me-3">
                            <a class="nav-link dropdown-toggle text-gray-600 position-relative" href="#"
                                data-bs-toggle="dropdown">
                                <i class='bi bi-bell fs-4'></i>

                                @if (($totalNotif ?? 0) > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 rounded-pill"
                                        style="transform: translate(-70%, -50%);">
                                        {{ $totalNotif }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                                <li class="dropdown-header">
                                    <h6>Notifications</h6>
                                </li>

                                @forelse ($notifData ?? [] as $notif)
                                    <li class="dropdown-item">
                                        <a class="d-flex align-items-center"
                                            href="{{ route('peminjaman.show', $notif->id_peminjaman) }}">

                                            <div
                                                class="notification-icon
                            {{ $notif->status == 'menunggu' ? 'bg-primary' : 'bg-info' }}">

                                                <div
                                                    class="notification-icon
    {{ $notif->status == 'menunggu' ? 'bg-primary' : 'bg-success' }} text-white">

                                                    <i
                                                        class="bi
    {{ $notif->status == 'menunggu' ? 'bi-journal-bookmark-fill' : 'bi-arrow-return-left' }}">
                                                    </i>
                                                </div>
                                            </div>

                                            <div class="ms-3">
                                                <p class="mb-0 fw-bold">
                                                    @if ($notif->status == 'menunggu')
                                                        Peminjaman baru
                                                    @elseif ($notif->status == 'menunggu_pengembalian')
                                                        Pengembalian buku
                                                    @endif
                                                </p>
                                                <small class="text-muted">
                                                    @if ($notif->status == 'menunggu')
                                                        {{ $notif->nama_anggota }} mengajukan peminjaman buku
                                                        "{{ $notif->judul_buku }}"
                                                    @elseif ($notif->status == 'menunggu_pengembalian')
                                                        {{ $notif->nama_anggota }} mengajukan pengembalian buku
                                                        "{{ $notif->judul_buku }}"
                                                    @endif
                                                </small>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-center text-muted">
                                        Tidak ada notifikasi
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                    <div class="dropdown ms-auto">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-menu d-flex">
                                <div class="user-name text-end me-3">
                                    @if (auth()->check())
                                        <h6 class="dropdown-header">
                                            Hallo, {{ auth()->user()->username }}
                                        </h6>
                                        <p class="mb-0 text-sm text-gray-600">
                                            {{ auth()->user()->role }}
                                        </p>
                                    @else
                                        <h6 class="dropdown-header">
                                            Belum Login
                                        </h6>
                                    @endif
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <img
                                            src="{{ auth()->check() && optional(auth()->user()->petugas)->image
                                                ? asset('storage/' . auth()->user()->petugas->image)
                                                : asset('assetsbackend/compiled/jpg/1.jpg') }}">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                            style="min-width: 11rem;">
                            <li>
                                <h6 class="dropdown-header">
                                    @if (auth()->check())
                                        Hello, {{ auth()->user()->username }}!
                                    @else
                                        Hello, Guest!
                                    @endif
                                </h6>
                            </li>
                            @if (auth()->check() && auth()->user()->role == 'petugas')
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="icon-mid bi bi-person me-2"></i> My Profile
                                    </a>
                                </li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
    </nav>
</header>
