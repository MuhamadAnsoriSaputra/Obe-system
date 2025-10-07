@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Tambah Dosen</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('dosens.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip"
                        class="form-control @error('nip') is-invalid @enderror"
                        value="{{ old('nip') }}">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_user" class="form-label">User</label>
                    <select name="id_user" id="id_user"
                        class="form-select @error('id_user') is-invalid @enderror">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Dosen</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gelar" class="form-label">Gelar</label>
                    <input type="text" name="gelar" id="gelar"
                        class="form-control @error('gelar') is-invalid @enderror"
                        value="{{ old('gelar') }}">
                    @error('gelar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan"
                        class="form-control @error('jabatan') is-invalid @enderror"
                        value="{{ old('jabatan') }}">
                    @error('jabatan')
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
