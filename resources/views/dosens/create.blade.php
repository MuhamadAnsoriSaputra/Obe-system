@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Dosen</h2>
        <form action="{{ route('dosens.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="id_user" class="form-label">User</label>
                <select name="id_user" class="form-select" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id_user }}">{{ $user->nama }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="gelar" class="form-label">Gelar</label>
                <input type="text" name="gelar" class="form-control">
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control">
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection