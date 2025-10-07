@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Data Mata Kuliah</h3>
            <a href="{{ route('mata_kuliahs.create') }}" class="btn btn-primary">+ Tambah Mata Kuliah</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Kode Prodi</th>
                            <th>Kode Angkatan</th>
                            <th>SKS</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mataKuliahs as $mk)
                            <tr>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->kode_prodi }}</td>
                                <td>{{ $mk->kode_angkatan }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>
                                    <a href="{{ route('mata_kuliahs.edit', $mk->kode_mk) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('mata_kuliahs.destroy', $mk->kode_mk) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection