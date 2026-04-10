<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RakBuku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="shortcut icon" href="{{ asset('assetsbackend/compiled/png/real.png') }}" type="image/x-icon">

    <link rel="stylesheet"
        href="{{ asset('assetsbackend/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/iconly.css') }}">


    <link rel="stylesheet" href="{{ asset('assetsbackend/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
</head>

<body>
    <script src="{{ asset('assetsbackend/static/js/initTheme.js') }}"></script>

    <div id="app">
        {{-- sidebar --}}
        @include('layout.backend.sidebar')
        {{-- endsidbar --}}

        <div id="main" class='layout-navbar navbar-fixed'>
            {{-- navbar --}}
            @include('layout.backend.navbar')
            {{-- endnavbar --}}

            <div id="main-content">
                @yield('content')

                {{-- footer --}}
                @include('layout.backend.footer')
                {{-- endfooter --}}

            </div>

        </div>
    </div>

    <script src="{{ asset('assetsbackend/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assetsbackend/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assetsbackend/compiled/js/app.js') }}"></script>

    {{-- datatables --}}
    <script src="{{ asset('assetsbackend/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/static/js/pages/datatables.js') }}"></script>

    {{-- form parsley --}}

    <script src="{{ asset('assetsbackend/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/static/js/pages/parsley.js') }}"></script>

    {{-- icon --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>


    {{-- sweet allert --}}
    <script src="{{ asset('assetsbackend/extensions/sweetalert2/sweetalert2.min.js') }}"></script>


    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif


</body>

</html>
