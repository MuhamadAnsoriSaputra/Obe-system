@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Tambah Mata Kuliah</h2>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mata-kuliahs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Kode Mata Kuliah</label>
                    <input type="text" name="kode_mk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Kurikulum</label>
                    <select name="kode_angkatan" class="form-select" required>
                        <option value="">-- Pilih Tahun Kurikulum --</option>
                        @foreach ($angkatans as $angkatan)
                            <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Dosen Pengampu</label>
                    <select name="nip_dosen" class="form-select" required>
                        <option value="">-- Pilih Dosen Pengampu --</option>
                        @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->nip }}">{{ $dosen->nama_dosen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control" value="2" min="1" required>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('mata-kuliahs.index') }}" class="btn btn-light">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
