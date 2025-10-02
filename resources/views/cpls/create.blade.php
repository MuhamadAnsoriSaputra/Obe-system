@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah CPL</h2>

        <form action="{{ route('cpls.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kode_cpl" class="form-label">Kode CPL</label>
                <input type="text" name="kode_cpl" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_angkatan" class="form-label">Angkatan</label>
                <select name="kode_angkatan" class="form-select" required>
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi CPL</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('cpls.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection