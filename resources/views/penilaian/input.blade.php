@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Manajemen Penilaian')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Input Nilai Akhir - {{ $matakuliah->nama_mk }}</h3>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('penilaian.import', $matakuliah->kode_mk) }}" method="POST" enctype="multipart/form-data"
            class="mb-4">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-6">
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success w-100">📥 Import Excel</button>
                </div>
            </div>
        </form>

        {{-- Form Input Nilai --}}
        <form action="{{ route('penilaian.store', $matakuliah->kode_mk) }}" method="POST" class="mb-4">
            @csrf

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nim" class="form-label fw-bold">NIM Mahasiswa</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="nama" class="form-label fw-bold">Nama Mahasiswa</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="nilai_akhir" class="form-label fw-bold">Nilai Akhir</label>
                    <input type="number" name="nilai_akhir" class="form-control" step="0.01" min="0" max="100" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </form>

        {{-- Tabel Daftar Mahasiswa yang Sudah Dinilai --}}
        <h5 class="mt-4">Daftar Mahasiswa yang Sudah Dinilai</h5>

        <form action="{{ route('penilaian.destroyAll', $matakuliah->kode_mk) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus semua nilai mahasiswa?')" class="mb-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-light fw-bold px-4">
                <i class="fas fa-trash me-2"></i> Hapus Semua Nilai
            </button>
        </form>

        <table class="table table-bordered text-center align-middle mt-2">
            <thead class="table-warning">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nilai Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($daftarNilai as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nim }}</td>
                        <td>{{ $item->nama ?? '-' }}</td>
                        <td>{{ number_format($item->nilai_akhir, 2) }}</td>
                        <td>
                            {{-- Tombol Edit (dummy / nanti bisa dikembangkan) --}}
                            <a href="#" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('penilaian.destroy', [$matakuliah->kode_mk, $item->nim]) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus nilai mahasiswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">Belum ada mahasiswa yang dinilai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection