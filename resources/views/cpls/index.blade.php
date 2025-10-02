@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Daftar CPL</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('cpls.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah CPL
            </a>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode CPL</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpls as $cpl)
                            <tr>
                                <td>{{ $cpl->kode_cpl }}</td>
                                <td>{{ $cpl->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $cpl->angkatan->tahun ?? '-' }}</td>
                                <td>{{ $cpl->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('cpls.edit', $cpl->kode_cpl) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cpls.destroy', $cpl->kode_cpl) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus CPL ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada CPL</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $cpls->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection