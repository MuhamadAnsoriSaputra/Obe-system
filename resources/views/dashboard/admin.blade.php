@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .dashboard-container {
            padding: 30px;
        }

        h2.title {
            font-weight: 700;
            margin-bottom: 30px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .card-stat {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .card-stat:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, 0.15);
        }

        .card-stat i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #00d4ff;
        }

        .card-stat .number {
            font-size: 28px;
            font-weight: 700;
        }

        .card-stat .label {
            font-size: 14px;
            opacity: 0.8;
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 20px;
            margin-top: 40px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
        }

        .quick-links {
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .quick-links a {
            background: linear-gradient(135deg, #00d4ff, #0077ff);
            color: white;
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .quick-links a:hover {
            background: linear-gradient(135deg, #0099ff, #005cff);
            transform: scale(1.05);
        }

        canvas {
            width: 100% !important;
            height: 320px !important;
        }
    </style>

    <div class="dashboard-container">
        <h2 class="title">Dashboard Admin</h2>

        <div class="stats">
            <div class="card-stat">
                <i class="fas fa-building-columns"></i>
                <div class="number">{{ $jumlahProdi }}</div>
                <div class="label">Program Studi</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-calendar-alt"></i>
                <div class="number">{{ $jumlahAngkatan }}</div>
                <div class="label">Tahun Angkatan</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-user-tie"></i>
                <div class="number">{{ $jumlahDosen }}</div>
                <div class="label">Dosen</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-user-graduate"></i>
                <div class="number">{{ $jumlahMahasiswa }}</div>
                <div class="label">Mahasiswa</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-book"></i>
                <div class="number">{{ $jumlahMataKuliah }}</div>
                <div class="label">Mata Kuliah</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-bullseye"></i>
                <div class="number">{{ $jumlahCPL }}</div>
                <div class="label">CPL</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-tasks"></i>
                <div class="number">{{ $jumlahCPMK }}</div>
                <div class="label">CPMK</div>
            </div>
            <div class="card-stat">
                <i class="fas fa-clipboard-check"></i>
                <div class="number">{{ $jumlahPenilaian }}</div>
                <div class="label">Penilaian</div>
            </div>
        </div>

        <div class="chart-container mt-5">
            <h5 class="fw-semibold mb-3">Rata-rata Capaian CPL</h5>
            <canvas id="chartCPL"></canvas>
        </div>

        <div class="quick-links">
            <a href="{{ url('/users') }}"><i class="fas fa-users me-1"></i> Kelola Pengguna</a>
            <a href="{{ url('/prodis') }}"><i class="fas fa-building-columns me-1"></i> Kelola Prodi</a>
            <a href="{{ url('/angkatans') }}"><i class="fas fa-calendar-plus me-1"></i> Tambah Angkatan</a>
            <a href="{{ url('/mata_kuliahs') }}"><i class="fas fa-book me-1"></i> Mata Kuliah</a>
            <a href="{{ url('/penilaian') }}"><i class="fas fa-chart-line me-1"></i> Penilaian</a>
            <a href="{{ url('/hasil') }}"><i class="fas fa-chart-pie me-1"></i> Hasil OBE</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartCPL');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($capaianCPL->pluck('kode_cpl')) !!},
                datasets: [{
                    label: 'Rata-rata Capaian (%)',
                    data: {!! json_encode($capaianCPL->pluck('rata')) !!},
                    borderWidth: 1,
                    backgroundColor: 'rgba(0,212,255,0.7)',
                    borderColor: '#00d4ff'
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    </script>
@endsection