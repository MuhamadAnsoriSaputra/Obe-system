@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush

@section('title', 'Dosen | Tambah')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Dosen</h2>

        <div class="card shadow-lg border-0 custom-form">
            <div class="card-body p-4">

                <form action="{{ route('dosens.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_user" class="form-label">User</label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                    {{ $user->nama }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gelar" class="form-label">Gelar</label>
                        <input type="text" name="gelar" class="form-control @error('gelar') is-invalid @enderror" value="{{ old('gelar') }}">
                        @error('gelar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" class="form-select @error('kode_prodi') is-invalid @enderror" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('dosens.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
