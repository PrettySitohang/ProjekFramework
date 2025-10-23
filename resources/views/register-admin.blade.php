<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Registrasi - Teknologi Sawit</title>
    <style>
        :root {
            --primary-orange: #FF9900;
            --secondary-orange: #cc7a00;
            --background-soft: #f0f7f4;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-soft);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow: auto; /* Mengubah overflow agar bisa scroll jika form panjang */
            padding: 20px 0; /* Menambahkan padding agar tidak menempel di tepi */
        }
        body::before {
            content: "";
            position: fixed; /* Menggunakan fixed agar latar tidak bergeser */
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://png.pngtree.com/thumb_back/fh260/background/20240522/pngtree-aerial-view-oil-palm-estate-in-evening-image_15690592.jpg') no-repeat center center/cover;
            opacity: 0.2;
            z-index: 0;
        }
        .register-card {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }
        .register-card h2 {
            color: #333;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
            border-bottom: 3px solid var(--primary-orange);
            padding-bottom: 10px;
        }
        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        input[type="text"], input[type="password"], input[type="date"], textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
            resize: vertical; /* Izinkan textarea diresize vertikal */
        }
        input:focus, textarea:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.2);
            outline: none;
        }
        button {
            background-color: var(--primary-orange);
            border: none;
            color: white;
            padding: 14px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.1s;
        }
        button:hover {
            background-color: var(--secondary-orange);
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .login-link a {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #d9534f;
            font-size: 0.85rem;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        /* Responsiveness */
        @media (max-width: 500px) {
            .register-card {
                padding: 25px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h2>Pendaftaran Admin</h2>

        @if (session('error'))
            <div class="error-message" style="text-align:center; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register') }}">
            @csrf

            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" placeholder="Nama Anda (tanpa angka)" value="{{ old('name') }}" required autofocus>
            @error('name')<div class="error-message">{{ $message }}</div>@enderror

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" placeholder="Alamat lengkap (maks. 300 karakter)" required>{{ old('alamat') }}</textarea>
            @error('alamat')<div class="error-message">{{ $message }}</div>@enderror

            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            @error('tanggal_lahir')<div class="error-message">{{ $message }}</div>@enderror

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username unik" value="{{ old('username') }}" required>
            @error('username')<div class="error-message">{{ $message }}</div>@enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Harus ada Kapital dan Angka" required>
            @error('password')<div class="error-message">{{ $message }}</div>@enderror

            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi Password" required>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <p class="login-link">
            Sudah punya akun? <a href="{{ route('admin.login') }}">Login di sini</a>.
        </p>
    </div>
</body>
</html>
