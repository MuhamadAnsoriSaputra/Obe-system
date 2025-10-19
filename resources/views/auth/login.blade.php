<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | KOMPAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="login-wrapper">
        <!-- SISI KIRI -->
        <div class="left-side">
            <h1>Sistem cerdas untuk hasil pembelajaran yang terarah</h1>
            <p>Sistem Akademik Politeknik Negeri Tanah Laut membantu mempermudah proses akademik dan kolaborasi kampus.
            </p>
        </div>

        <!-- SISI KANAN -->
        <div class="right-side">
            <div class="card-login">
                <h3>Masuk ke KOMPAS</h3>

                @if($errors->any())
                    <div class="alert alert-danger text-center py-2">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh: user@politala.ac.id"
                            value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi"
                            required>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>

                    <div class="divider">atau</div>

                    <a href="{{ route('google.redirect') }}" class="btn btn-google w-100">
                        <img src="https://developers.google.com/identity/images/g-logo.png" class="google-icon"
                            alt="Google">
                        Masuk dengan Google
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>