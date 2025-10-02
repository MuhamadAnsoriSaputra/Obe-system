@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Edit CPL</h2>

        <form action="{{ route('cpls.update', $cpl->kode_cpl) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kode_cpl" class="form-label">Kode CPL</label>
                <input type="text" class="form-control" value="{{ $cpl->kode_cpl }}" disabled>
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" class="form-select" required>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ $cpl->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_angkatan" class="form-label">Angkatan</label>
                <select name="kode_angkatan" class="form-select" required>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->kode_angkatan }}" {{ $cpl->kode_angkatan == $angkatan->kode_angkatan ? 'selected' : '' }}>
                            {{ $angkatan->tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi CPL</label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ $cpl->deskripsi }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('cpls.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection