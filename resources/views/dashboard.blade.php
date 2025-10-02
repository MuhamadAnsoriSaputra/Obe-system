@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold mb-4">Dashboard</h2>

        {{-- Cards Statistik --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h6>Total Users</h6>
                    <h3>{{ $stats['users'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-user-tie fa-2x mb-2"></i>
                    <h6>Total Dosen</h6>
                    <h3>{{ $stats['dosens'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-user-graduate fa-2x mb-2"></i>
                    <h6>Total Mahasiswa</h6>
                    <h3>{{ $stats['mahasiswas'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-book fa-2x mb-2"></i>
                    <h6>Total Mata Kuliah</h6>
                    <h3>{{ $stats['mata_kuliahs'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        {{-- Menu Cepat --}}
        <div class="row g-4">
            <div class="col-md-3">
                <a href="{{ url('/users') }}" class="menu-card">
                    <i class="fas fa-users"></i>
                    <span>Kelola Users</span>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/dosens') }}" class="menu-card">
                    <i class="fas fa-user-tie"></i>
                    <span>Kelola Dosen</span>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/mahasiswas') }}" class="menu-card">
                    <i class="fas fa-user-graduate"></i>
                    <span>Kelola Mahasiswa</span>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/mata-kuliahs') }}" class="menu-card">
                    <i class="fas fa-book"></i>
                    <span>Kelola Mata Kuliah</span>
                </a>
            </div>
        </div>
    </div>
@endsection