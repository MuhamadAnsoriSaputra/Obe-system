@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Mahasiswa</h2>

        <a href="{{ route('mahasiswas.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah Mahasiswa
        </a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $mhs)
                            <tr>
                                <td>{{ $mhs->nim }}</td>
                                <td>{{ $mhs->nama }}</td>
                                <td>{{ $mhs->email }}</td>
                                <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $mhs->angkatan->tahun ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('mahasiswas.show', $mhs->nim) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('mahasiswas.edit', $mhs->nim) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('mahasiswas.destroy', $mhs->nim) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada mahasiswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
@endsection