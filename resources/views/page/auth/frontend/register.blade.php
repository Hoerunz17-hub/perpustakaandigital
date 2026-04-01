<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Booksaw Style</title>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Poppins:wght@300;400;500&display=swap"
        rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f8f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .wrapper {
            width: 100%;
            max-width: 650px;
            /* biar pas di tengah */
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 35px 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            color: #2c2c2c;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #888;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            font-size: 13px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            font-size: 14px;
            background: #fafafa;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #c59d5f;
            background: #fff;
        }

        .btn {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 6px;
            background: #c59d5f;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            margin-top: 8px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #a88245;
        }

        .extra {
            margin-top: 15px;
            font-size: 13px;
            text-align: center;
            color: #777;
        }

        .extra a {
            color: #c59d5f;
            text-decoration: none;
            font-weight: 500;
        }

        .extra a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .wrapper {
                grid-template-columns: 1fr;
                width: 90%;
            }
        }

        .input-wrap {
            position: relative;
        }

        .toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            transition: 0.2s;
        }

        .toggle-icon:hover {
            color: #c59d5f;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* supaya textarea, file, dll bisa full width */
        .full {
            grid-column: span 2;
        }

        /* responsive: balik jadi 1 kolom di HP */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: span 1;
            }
        }

        body {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- REGISTER -->
        <div class="card">
            <div class="logo">Perpus</div>
            <div class="subtitle">Buat akun baru</div>




            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Masukkan email">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            style="width:100%; padding:10px 12px; border:1px solid #e5e5e5; border-radius:6px; background:#fafafa;">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir">
                    </div>

                    <div class="form-group full">
                        <label>Alamat</label>
                        <textarea rows="3" name="alamat" placeholder="Masukkan alamat lengkap"
                            style="width:100%; padding:10px 12px; border:1px solid #e5e5e5; border-radius:6px; background:#fafafa; outline:none;"></textarea>
                    </div>

                    <div class="form-group full">
                        <label>Foto Profil</label>
                        <input type="file" accept="image/*" name="foto" style="background:#fafafa;">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrap">
                            <input id="password" name="password" type="password" placeholder="Masukkan password">
                            <iconify-icon onclick="togglePassword('password', this)" class="toggle-icon"
                                icon="mdi:eye-outline" width="20"></iconify-icon>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password">
                    </div>

                </div>

                <button class="btn">Daftar</button>

                <div class="extra">
                    Sudah punya akun? <a href="/loginuser">Login</a>
                </div>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                el.setAttribute("icon", "mdi:eye-off-outline");
            } else {
                input.type = "password";
                el.setAttribute("icon", "mdi:eye-outline");
            }
        }
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#c59d5f'
            });
        </script>
    @endif

</body>

</html>
