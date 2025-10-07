@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Manajemen Mata Kuliah</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('mata-kuliahs.create') }}" class="btn btn-light fw-bold">
            <i class="fas fa-plus me-2"></i> Tambah Mata Kuliah
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>Tahun Kurikulum</th>
                            <th>Dosen Pengampu</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataKuliahs as $mk)
                            <tr>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $mk->angkatan->tahun ?? '-' }}</td>
                                <td>{{ $mk->dosen->nama_dosen ?? '-' }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>
                                    <a href="{{ route('mata-kuliahs.edit', $mk->kode_mk) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('mata-kuliahs.destroy', $mk->kode_mk) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus mata kuliah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada Mata Kuliah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Jika ingin pagination, aktifkan paginate() di controller
            <div class="mt-3">
                {{ $mataKuliahs->links() }}
            </div>
            --}}
        </div>
    </div>
</div>
@endsection
