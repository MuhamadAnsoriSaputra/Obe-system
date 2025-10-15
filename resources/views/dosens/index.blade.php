@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Dosen</h2>

        <a href="{{ route('dosens.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah Dosen
        </a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Gelar</th>
                            <th>Jabatan</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosens as $dosen)
                            <tr>
                                <td>{{ $dosen->nip }}</td>
                                <td>{{ $dosen->nama }}</td>
                                <td>{{ $dosen->gelar ?? '-' }}</td>
                                <td>{{ $dosen->jabatan ?? '-' }}</td>
                                <td>{{ $dosen->prodi->nama_prodi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dosens.edit', $dosen->nip) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosens.destroy', $dosen->nip) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus dosen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data dosen</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $dosens->links() }}
            </div>
        </div>
    </div>
@endsection