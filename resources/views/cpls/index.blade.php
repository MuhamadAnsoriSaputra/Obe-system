@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPL</h2>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol Tambah + Search --}}
        <div class="top-actions">
            <a href="{{ route('cpls.create') }}" class="btn-tambah">
                <i class="fas fa-plus me-2"></i> Tambah CPL
            </a>

            <form action="{{ route('cpls.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari CPL..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('cpls.index') }}" class="btn-cari ms-2" style="background:#ccc; color:#000;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Wrapper --}}
        <div class="table-wrapper">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Kode CPL</th>
                        <th>Deskripsi</th>
                        <th>Kurikulum</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cpls as $cpl)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($cpls->firstItem() - 1) }}</td>
                            <td>{{ $cpl->kode_cpl }}</td>
                            <td>{{ $cpl->deskripsi }}</td>
                            <td>{{ $cpl->angkatan->tahun ?? '-' }}</td>
                            <td>
                                <a href="{{ route('cpls.edit', $cpl->kode_cpl) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cpls.destroy', $cpl->kode_cpl) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus CPL ini?')">
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
                            <td colspan="5" class="text-center">Belum ada CPL</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $cpls->links() }}
            </div>
        </div>
    </div>
@endsection