@extends('layouts.app')

@section('title', 'Manajemen Angkatan')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Kurikulum</h2>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3">
            <a href="{{ route('angkatans.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Kurikulum
            </a>
        </div>

        {{-- Card --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode Kurikulum</th>
                            <th>Tahun</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($angkatans as $angkatan)
                            <tr>
                                <td>{{ $angkatan->kode_angkatan }}</td>
                                <td>{{ $angkatan->tahun }}</td>
                                <td>{{ $angkatan->prodi->nama_prodi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('angkatans.edit', $angkatan->kode_angkatan) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('angkatans.destroy', $angkatan->kode_angkatan) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus angkatan ini?')">
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
                                <td colspan="4" class="text-center">Belum ada Kurikulum</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $angkatans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection