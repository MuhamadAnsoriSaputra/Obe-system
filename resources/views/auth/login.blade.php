<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg p-4 border-0" style="width: 400px; background-color: #2b2b2b;">
        <h3 class="text-center fw-bold mb-4 text-light">Login Sistem</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-light">Email</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-light">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
            </div>

            <button type="submit" class="btn btn-light w-100 fw-bold">Login</button>
        </form>
    </div>
</div>

</body>
</html>
