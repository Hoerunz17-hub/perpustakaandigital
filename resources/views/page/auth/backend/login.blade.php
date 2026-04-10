<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dululeeee</title>



    <link rel="shortcut icon" href="{{ asset('assetsbackend/compiled/png/bulatbuku2.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsbackend/compiled/css/auth.css') }}">

    <style>
        .select-xl {
            height: calc(3.5rem + 2px);
            padding-left: 2.5rem;
            font-size: 1.2rem;
        }

        /* WARNA PLACEHOLDER */
        .select-xl:invalid {
            color: #adb5bd;
        }

        /* warna normal saat dipilih */
        .select-xl option {
            color: #000;
        }

        #auth-right {
            background: url('{{ asset('assetsbackend/compiled/jpg/buku.jpg') }}') center center / cover no-repeat;
        }

        #auth #auth-left .auth-logo img {
            height: auto !important;
            width: 220px !important;
        }
    </style>
</head>

<body>
    <script src="{{ asset('assetsbackend/static/js/initTheme.js') }}"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="{{ asset('assetsbackend/compiled/png/real.png') }}"
                                alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Login Dulu Baru Pintar</p>

                    <form action="{{ route('login.proses') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl"
                                placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>


                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>

                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000,

                showClass: {
                    popup: 'animate__animated animate__shakeX animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            });
        </script>
    @endif


    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,

                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            });
        </script>
    @endif
</body>

</html>
