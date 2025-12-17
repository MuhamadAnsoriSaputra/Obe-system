<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark fixed-top shadow custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">KOMPAS</a>
            <div>
                <span class="text-white me-3">{{ Auth::user()->nama ?? 'Guest' }}
                    ({{ Auth::user()->role ?? '' }})</span>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h5>Menu</h5>
        <ul class="nav flex-column">

            {{-- DASHBOARD --}}
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>

            {{-- ===================================== --}}
            {{-- ADMIN (SEMUA MENU) --}}
            {{-- ===================================== --}}
            @if (Auth::user()->role === 'admin')
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
                    <a href="{{ url('/angkatans') }}" class="nav-link {{ request()->is('angkatans*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Kurikulum
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mahasiswas') }}" class="nav-link {{ request()->is('mahasiswas*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cpls') }}" class="nav-link {{ request()->is('cpls*') ? 'active' : '' }}">
                        <i class="fas fa-bullseye"></i> CPL
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cpmks') }}" class="nav-link {{ request()->is('cpmks*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i> CPMK
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/rumusan') }}" class="nav-link {{ request()->is('rumusan*') ? 'active' : '' }}">
                        <i class="fas fa-diagram-project"></i> Rumusan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mata_kuliahs') }}"
                        class="nav-link {{ request()->is('mata_kuliahs*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Mata Kuliah
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/dosens') }}" class="nav-link {{ request()->is('dosens*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Dosen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/perangkingan') }}"
                        class="nav-link {{ request()->is('perangkingan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Perangkingan SAW
                    </a>
                </li>
            @endif

            {{-- ===================================== --}}
            {{-- AKADEMIK --}}
            {{-- ===================================== --}}
            @if (Auth::user()->role === 'akademik')
                <li class="nav-item">
                    <a href="{{ url('/mahasiswas') }}" class="nav-link {{ request()->is('mahasiswas*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cpls') }}" class="nav-link {{ request()->is('cpls*') ? 'active' : '' }}">
                        <i class="fas fa-bullseye"></i> CPL
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cpmks') }}" class="nav-link {{ request()->is('cpmks*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i> CPMK
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/rumusan') }}" class="nav-link {{ request()->is('rumusan*') ? 'active' : '' }}">
                        <i class="fas fa-diagram-project"></i> Rumusan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mata_kuliahs') }}"
                        class="nav-link {{ request()->is('mata_kuliahs*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Mata Kuliah
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/dosens') }}" class="nav-link {{ request()->is('dosens*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Dosen
                    </a>
                </li>
            @endif

            {{-- ===================================== --}}
            {{-- DOSEN --}}
            {{-- ===================================== --}}
            @if (Auth::user()->role === 'dosen')
                <li class="nav-item">
                    <a href="{{ url('/mata_kuliahs') }}"
                        class="nav-link {{ request()->is('mata_kuliahs*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Mata Kuliah
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/penilaian') }}" class="nav-link {{ request()->is('penilaian*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i> Penilaian
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/perangkingan') }}"
                        class="nav-link {{ request()->is('perangkingan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Perangkingan SAW
                    </a>
                </li>
            @endif

            {{-- ===================================== --}}
            {{-- KAPRODI --}}
            {{-- ===================================== --}}
            @if (Auth::user()->role === 'kaprodi')
                <li class="nav-item">
                    <a href="{{ url('/rumusan') }}" class="nav-link {{ request()->is('rumusan*') ? 'active' : '' }}">
                        <i class="fas fa-diagram-project"></i> Rumusan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mahasiswas') }}" class="nav-link {{ request()->is('mahasiswas*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Mahasiswa
                    </a>
                </li>
            @endif

            {{-- ===================================== --}}
            {{-- WADIR 1 --}}
            {{-- ===================================== --}}
            @if (Auth::user()->role === 'wadir1')
                <li class="nav-item">
                    <a href="{{ url('/mahasiswas') }}" class="nav-link {{ request()->is('mahasiswas*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Mahasiswa
                    </a>
                </li>
            @endif

        </ul>
    </div>

    <!-- CONTENT -->
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