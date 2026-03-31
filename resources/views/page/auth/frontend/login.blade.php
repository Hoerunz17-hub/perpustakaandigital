<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Booksaw Style</title>

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
            height: 100vh;
            background: #f8f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 420px;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: #2c2c2c;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 13px;
            color: #888;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 13px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            outline: none;
            font-size: 14px;
            transition: 0.2s;
            background: #fafafa;
        }

        .form-group input:focus {
            border-color: #c59d5f;
            background: #fff;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #c59d5f;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #a88245;
        }

        .extra {
            margin-top: 18px;
            font-size: 13px;
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

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            font-size: 12px;
            color: #aaa;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
            margin: 0 10px;
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
    </style>
</head>

<body>

    <div class="container">

        <div class="logo">Perpus</div>
        <div class="subtitle">Digital Library Access</div>

        <form>
            <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Masukkan email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <input id="password" type="password" placeholder="Masukkan password">
                    <iconify-icon onclick="togglePassword('password', this)" class="toggle-icon" icon="mdi:eye-outline"
                        width="20">
                    </iconify-icon>
                </div>
            </div>

            <button class="btn">Login</button>

            <div class="divider">atau</div>

            <div class="extra">
                Belum punya akun? <a href="/registrasiuser">Daftar</a>
            </div>
        </form>

    </div>
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
</body>

</html>
