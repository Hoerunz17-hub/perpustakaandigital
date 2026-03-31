@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Table Anggota</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Table Anggota
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Email</th>
                                    <th class="text-nowrap">Jenis Kelamin</th>
                                    <th class="text-nowrap">Tanggal Lahir</th>

                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-nowrap">1</td>
                                    <td class="text-nowrap">Foto</td>
                                    <td class="text-nowrap">17-05026</td>
                                    <td class="text-nowrap"> tere liye</td>
                                    <td class="text-nowrap"> tere liye</td>
                                    <td class="text-center align-middle">
                                        <a href="#" class="text-primary fs-5">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>


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
    </style>
@endsection
