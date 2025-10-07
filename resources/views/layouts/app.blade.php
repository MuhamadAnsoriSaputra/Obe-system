<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark fixed-top shadow custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">KOMPAS</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/prodis') }}" class="nav-link {{ request()->is('prodis*') ? 'active' : '' }}">
                    <i class="fas fa-building-columns"></i> Prodi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('angkatans.index') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Tahun Angkatan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cpls.index') }}" class="nav-link {{ request()->is('cpls*') ? 'active' : '' }}">
                    <i class="fas fa-bullseye"></i> CPL
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/cpmks') }}" class="nav-link {{ request()->is('cpmks*') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> CPMK
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dosens') }}" class="nav-link {{ request()->is('dosens*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i> Dosen
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/mahasiswas') }}" class="nav-link {{ request()->is('mahasiswas*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Mahasiswa
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/mata_kuliahs') }}"
                    class="nav-link {{ request()->is('mata_kuliahs*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Mata Kuliah
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('toggle-password')) {
            const input = e.target.closest('.input-group').querySelector('input');
            input.type = input.type === 'password' ? 'text' : 'password';
            e.target.classList.toggle('fa-eye');
            e.target.classList.toggle('fa-eye-slash');
        }
    });
</script>

</html>