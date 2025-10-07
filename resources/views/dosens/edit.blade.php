@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Data Dosen</h2>

    <a href="{{ route('dosens.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dosens.update', $dosen->nip) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip', $dosen->nip) }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $dosen->nama) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $dosen->email) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" class="form-select" required>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ $dosen->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="gelar" class="form-label">Gelar</label>
                <input type="text" name="gelar" class="form-control" value="{{ old('gelar', $dosen->gelar) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $dosen->jabatan) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Perbarui</button>
    </form>
</div>
@endsection
