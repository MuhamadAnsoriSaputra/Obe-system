@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Dosen</h2>
        <form action="{{ route('dosens.update', $dosen->nip) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ $dosen->nip }}" required>
            </div>

            <div class="mb-3">
                <label for="id_user" class="form-label">User</label>
                <select name="id_user" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id_user }}" {{ $dosen->id_user == $user->id_user ? 'selected' : '' }}>
                            {{ $user->nama }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ $dosen->nama }}" required>
            </div>

            <div class="mb-3">
                <label for="gelar" class="form-label">Gelar</label>
                <input type="text" name="gelar" class="form-control" value="{{ $dosen->gelar }}">
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ $dosen->jabatan }}">
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" class="form-select" required>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ $dosen->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection