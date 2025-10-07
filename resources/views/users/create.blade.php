@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Pengguna</h2>

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body p-4">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror">
                            <span class="input-group-text bg-transparent text-white">
                                <i class="fa-solid fa-eye toggle-password" style="cursor:pointer;"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="akademik" {{ old('role') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                            <option value="wadir1" {{ old('role') == 'wadir1' ? 'selected' : '' }}>Wadir 1</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Field Prodi (muncul hanya untuk akademik & kaprodi) --}}
                    <div class="mb-3" id="prodiField" style="display: none;">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" id="kode_prodi"
                            class="form-select @error('kode_prodi') is-invalid @enderror">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($prodis as $prodi)
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
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script untuk toggle Prodi dan password --}}
    <script>
        const roleSelect = document.getElementById('role');
        const prodiField = document.getElementById('prodiField');

        function toggleProdiField() {
            const selectedRole = roleSelect.value;
            if (selectedRole === 'akademik' || selectedRole === 'kaprodi') {
                prodiField.style.display = 'block';
            } else {
                prodiField.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', toggleProdiField);
        document.addEventListener('DOMContentLoaded', toggleProdiField);
    </script>
@endsection