@extends('layouts.app')

@section('content')
    <style>
        .dashboard-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
        }

        .dashboard-card i {
            font-size: 32px;
            margin-bottom: 8px;
        }

        body {
            background: #f5f6fa !important;
        }
    </style>

    <div class="container-fluid">
        <h2 class="fw-bold mb-4">Dashboard Akademik</h2>

        {{-- Cards Statistik --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-users"></i>
                    <h6>Total Mahasiswa Terdaftar</h6>
                    <h3>{{ $stats['mahasiswa'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-book"></i>
                    <h6>Program Studi Aktif</h6>
                    <h3>{{ $stats['prodi'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-file-alt"></i>
                    <h6>Mata Kuliah Terdata</h6>
                    <h3>{{ $stats['mk'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card">
                    <i class="fas fa-calendar-check"></i>
                    <h6>Tahun Kurikulum Aktif</h6>
                    <h3>{{ $stats['kurikulum'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection