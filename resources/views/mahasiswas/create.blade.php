@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Mahasiswa</h2>

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body p-4">

                <form action="{{ route('mahasiswas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim') }}">
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                        <input type="number" name="tahun_masuk" id="tahun_masuk"
                            class="form-control @error('tahun_masuk') is-invalid @enderror" value="{{ old('tahun_masuk') }}"
                            placeholder="Misal: 2022" required>
                        @error('tahun_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus (Opsional)</label>
                        <input type="number" name="tahun_lulus" id="tahun_lulus"
                            class="form-control @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus') }}"
                            placeholder="Kosongkan jika belum lulus">
                        @error('tahun_lulus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <div class="mb-3">
                            <label for="kode_prodi" class="form-label">Program Studi</label>
                            <select name="kode_prodi" id="kode_prodi"
                                class="form-select @error('kode_prodi') is-invalid @enderror" required>
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="kode_angkatan" class="form-label">Kurikulum</label>
                        <select name="kode_angkatan" id="kode_angkatan"
                            class="form-select @error('kode_angkatan') is-invalid @enderror" required>
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan->kode_angkatan }}" {{ old('kode_angkatan') == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                    {{ $angkatan->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mahasiswas.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
