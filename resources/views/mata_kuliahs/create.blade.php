@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Tambah Mata Kuliah</h3>
        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <form action="{{ route('mata_kuliahs.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kode MK</label>
                        <input type="text" name="kode_mk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Prodi</label>
                        <input type="text" name="kode_prodi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Angkatan</label>
                        <input type="text" name="kode_angkatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" class="form-control" value="2" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('mata_kuliahs.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection