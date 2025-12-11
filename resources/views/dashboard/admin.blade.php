@extends('layouts.app')

@section('title', 'Dashboard | Admin')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f3f6fc, #eaf0ff);
            font-family: 'Poppins', sans-serif;
            color: #1e3c72;
        }

        .dashboard-container {
            padding: 30px;
        }

        h2.title {
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 30px;
        }

        /* === STAT CARDS === */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .card-stat {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #d3dcff;
            box-shadow: 0 6px 12px rgba(30, 60, 114, 0.1);
        }

        .card-stat:hover {
            transform: translateY(-4px);
            background: #f9fbff;
            box-shadow: 0 8px 18px rgba(30, 60, 114, 0.15);
        }

        .card-stat i {
            font-size: 36px;
            margin-bottom: 12px;
            color: #2a5298;
        }

        .card-stat .number {
            font-size: 28px;
            font-weight: 700;
            color: #1e3c72;
        }

        .card-stat .label {
            font-size: 14px;
            color: #5068a9;
            opacity: 0.9;
        }

        /* === CHART === */
        .chart-container {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            margin-top: 40px;
            border: 1px solid #d3dcff;
            box-shadow: 0 6px 12px rgba(30, 60, 114, 0.1);
        }

        h5 {
            color: #1e3c72;
            font-weight: 600;
        }

        canvas {
            width: 100% !important;
            height: 320px !important;
        }

        /* === REMOVE QUICK LINKS === */
        .quick-links {
            display: none;
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
                    backgroundColor: 'rgba(42, 82, 152, 0.7)',
                    borderColor: '#2a5298'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { color: '#1e3c72' },
                        grid: { color: 'rgba(30,60,114,0.1)' }
                    },
                    x: {
                        ticks: { color: '#1e3c72' },
                        grid: { color: 'rgba(30,60,114,0.1)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#1e3c72' }
                    }
                }
            }
        });
    </script>
@endsection