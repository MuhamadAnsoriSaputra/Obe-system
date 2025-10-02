@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Daftar Mahasiswa</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('mahasiswas.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah Mahasiswa
        </a>

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
                                <td>{{ $mhs->angkatan->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $mhs->angkatan->tahun ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('mahasiswas.edit', $mhs->nim) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('mahasiswas.destroy', $mhs->nim) }}" method="POST" class="d-inline"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus mahasiswa ini?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data mahasiswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
@endsection