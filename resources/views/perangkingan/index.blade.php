@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-4 text-primary">📊 Perangkingan Mahasiswa (Metode SAW)</h3>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                    {{ $err }}<br>
                @endforeach
            </div>
        @endif

        {{-- 🔽 Filter dan tombol hitung --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('perangkingan.hitung') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="angkatan" class="form-label fw-bold">Pilih Tahun Angkatan</label>
                        <select name="angkatan" id="angkatan" class="form-select" required>
                            <option value="">-- Pilih Angkatan --</option>
                            @foreach($angkatans as $item)
                                <option value="{{ $item->kode_angkatan }}" {{ request('angkatan') == $item->kode_angkatan ? 'selected' : '' }}>
                                    {{ $item->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            🔍 Hitung Ranking
                        </button>
                    </div>
                    @if(isset($hasilSaw))
                        <div class="col-md-2">
                            <a href="{{ route('perangkingan.export', ['angkatan' => request('angkatan')]) }}"
                                class="btn btn-outline-primary w-100">
                                ⬇️ Export Excel
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- 📈 Tabel Hasil Perangkingan --}}
        @if(isset($hasilSaw) && count($hasilSaw) > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Hasil Perangkingan Mahasiswa Tahun {{ $tahun ?? '' }}
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-warning">
                            <tr>
                                <th>Ranking</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th colspan="9">Nilai Mata Kuliah</th>
                                <th>Skor Akhir (SAW)</th>
                            </tr>
                            <tr class="table-light">
                                <th></th>
                                <th></th>
                                <th></th>
                                @foreach($namaMatakuliah as $mk)
                                    <th>{{ $mk }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilSaw as $index => $item)
                                <tr>
                                    <td><span class="badge bg-success">{{ $index + 1 }}</span></td>
                                    <td>{{ $item['nim'] }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    @foreach($item['nilai'] as $n)
                                        <td>{{ number_format($n, 2) }}</td>
                                    @endforeach
                                    <td class="fw-bold text-primary">{{ number_format($item['skor_akhir'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 📊 Grafik Hasil Ranking --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white fw-bold">
                    Visualisasi Skor Akhir Mahasiswa
                </div>
                <div class="card-body">
                    <canvas id="rankingChart"></canvas>
                </div>
            </div>

            {{-- Chart.js --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('rankingChart').getContext('2d');
                const rankingChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json(array_column($hasilSaw, 'nama')),
                        datasets: [{
                            label: 'Skor Akhir (SAW)',
                            data: @json(array_column($hasilSaw, 'skor_akhir')),
                            borderWidth: 1,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true },
                        },
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Skor Akhir' } },
                            x: { title: { display: true, text: 'Nama Mahasiswa' } }
                        }
                    }
                });
            </script>
        @else
            <div class="alert alert-info">
                Silakan pilih tahun angkatan dan klik <b>Hitung Ranking</b> untuk menampilkan hasil perangkingan.
            </div>
        @endif
    </div>
@endsection