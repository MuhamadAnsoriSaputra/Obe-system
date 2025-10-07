@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Edit Dosen</h2>

        <form action="{{ route('dosens.update', $dosen->nip) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" id="nip" class="form-control" value="{{ $dosen->nip }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $dosen->nama }}" required>
            </div>

            <div class="mb-3">
                <label for="gelar" class="form-label">Gelar</label>
                <input type="text" name="gelar" id="gelar" class="form-control" value="{{ $dosen->gelar }}">
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ $dosen->jabatan }}">
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" id="kode_prodi" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ $prodi->kode_prodi == $dosen->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $dosen->email }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('dosens.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
