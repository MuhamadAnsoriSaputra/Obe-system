@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Manajemen Kurikulum')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Kurikulum</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="top-actions">
            <a href="{{ route('angkatans.create') }}" class="btn-tambah">
                <i class="fas fa-plus me-2"></i> Tambah Kurikulum
            </a>

            <form action="{{ route('angkatans.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari kurikulum..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('angkatans.index') }}" class="btn-cari ms-2" style="background:#ccc; color:#000;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table table-hover align-middle">
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
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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

            <div class="mt-3">
                {{ $angkatans->links() }}
            </div>
        </div>
    </div>
@endsection