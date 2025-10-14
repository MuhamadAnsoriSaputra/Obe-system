@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-3">Detail Nilai Mahasiswa</h3>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
                <p><strong>Prodi:</strong> {{ $mahasiswa->prodi->nama_prodi ?? '-' }}</p>
                <p><strong>Angkatan:</strong> {{ $mahasiswa->angkatan->tahun ?? '-' }}</p>
            </div>
        </div>

        <h5 class="fw-bold mb-3">Nilai Per Mata Kuliah</h5>

        <table class="table table-bordered text-center">
            <thead class="table-warning">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>CPL</th>
                    <th>CPMK</th>
                    <th>Skor Maks</th>
                    <th>Nilai Perkuliahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nilai as $n)
                    <tr>
                        <td>{{ $n->nama_mk }}</td>
                        <td>{{ $n->kode_cpl }}</td>
                        <td>{{ $n->kode_cpmk }}</td>
                        <td>{{ $n->skor_maks }}</td>
                        <td>{{ $n->nilai_perkuliahan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Belum ada nilai untuk mahasiswa ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('mahasiswas.index') }}" class="btn btn-secondary mt-3">⬅ Kembali</a>
    </div>
@endsection