@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Edit Mahasiswa</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('mahasiswas.update', $mahasiswa->nim) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mahasiswa</label>
                    <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required>
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" class="form-select" required>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}"
                                    {{ $mahasiswa->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="kode_angkatan" class="form-label">Angkatan</label>
                    <select name="kode_angkatan" class="form-select" required>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->kode_angkatan }}"
                                {{ $mahasiswa->kode_angkatan == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                {{ $angkatan->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('mahasiswas.index') }}" class="btn btn-secondary me-2 px-4">Batal</a>
                    <button type="submit" class="btn btn-light fw-bold px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
