@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Edit Mata Kuliah</h3>
        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <form action="{{ route('mata_kuliahs.update', $mataKuliah->kode_mk) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Kode MK</label>
                        <input type="text" name="kode_mk" value="{{ $mataKuliah->kode_mk }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" value="{{ $mataKuliah->nama_mk }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Prodi</label>
                        <input type="text" name="kode_prodi" value="{{ $mataKuliah->kode_prodi }}" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Angkatan</label>
                        <input type="text" name="kode_angkatan" value="{{ $mataKuliah->kode_angkatan }}"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" value="{{ $mataKuliah->sks }}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('mata_kuliahs.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection