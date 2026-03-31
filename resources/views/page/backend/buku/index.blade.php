@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Table Buku</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-flex justify-content-between gap-2 flex-wrap">
                        <div>
                            Table Buku
                        </div>
                        <a href="/buku/create" class="btn btn-primary">Tambah Buku</a>

                    </h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Cover</th>
                                    <th class="text-nowrap">Judul Buku</th>
                                    <th class="text-nowrap">Penulis</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $buku)
                                    <tr>
                                        <td class="text-nowrap">{{ $loop->iteration }}</td>

                                        <td class="text-nowrap">
                                            @if ($buku->cover)
                                                <img src="{{ asset('storage/' . $buku->cover) }}" class="img-cover">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>

                                        <td class="text-nowrap">{{ $buku->judul_buku }}</td>
                                        <td class="text-nowrap">{{ $buku->penulis }}</td>

                                        <td class="text-nowrap">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-status" type="checkbox"
                                                    data-id="{{ $buku->id_buku }}"
                                                    {{ $buku->is_active == 'active' ? 'checked' : '' }}>
                                            </div>
                                        </td>

                                        <td class="text-center align-middle action-column">
                                            <div class="dropdown dropstart">
                                                <button class="btn border-0 bg-transparent p-0" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                                </button>

                                                <ul class="dropdown-menu shadow-sm">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="/buku/edit/{{ $buku->id_buku }}">
                                                            <i class="fas fa-edit"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="/buku/show/{{ $buku->id_buku }}">
                                                            <i class="fas fa-eye"></i>
                                                            <span>Detail</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                            href="#"
                                                            onclick="event.preventDefault(); confirmDelete({{ $buku->id_buku }})">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- KOSONGIN aja biar DataTables handle --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <style>
        #table1 th,
        #table1 td {
            vertical-align: middle !important;
        }

        #table1 th:last-child,
        #table1 td:last-child {
            text-align: center;
        }

        #table1 td:last-child {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }

        .img-cover {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
        }

        .swal2-popup {
            border-radius: 10px;
        }

        .swal2-title {
            font-weight: 600;
        }

        .swal2-confirm.btn-danger {
            background-color: #e17055 !important;
            border: none;
            padding: 10px 20px;
        }

        .swal2-cancel.btn-secondary {
            background-color: #b2bec3 !important;
            border: none;
            padding: 10px 20px;
        }

        .swal2-actions {
            gap: 15px;
        }

        .swal2-actions .btn {
            padding: 10px 18px;
            min-width: 130px;
            border-radius: 6px;
        }
    </style>

    <script>
        document.querySelectorAll('.toggle-status').forEach(function(el) {
            el.addEventListener('change', function() {
                let id = this.dataset.id;
                let status = this.checked ? 'active' : 'nonactive';

                fetch(`/buku/update-status/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        is_active: status
                    })
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined') {
                $('#table1').DataTable({
                    destroy: true,
                    language: {
                        emptyTable: "📚 buku masih kosong"
                    }
                });
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apa kamu yakin ingin menghapusnya?',
                text: "Kamu gak akan bisa memulihkannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/buku/delete/' + id;
                }
            });
        }
    </script>
@endsection
