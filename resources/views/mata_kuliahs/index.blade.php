@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Mata Kuliah</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol Tambah + Search --}}
        <div class="top-actions">
            @if(auth()->user()->role === 'akademik')
                <a href="{{ route('mata_kuliahs.create') }}" class="btn-tambah">
                    <i class="fas fa-plus me-2"></i> Tambah Mata Kuliah
                </a>
            @endif

            <form action="{{ route('mata_kuliahs.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari Mata Kuliah..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('mata_kuliahs.index') }}" class="btn-cari ms-2" style="background:#ccc; color:#000;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="table-wrapper">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode MK</th>
                        <th>Nama MK</th>
                        <th>SKS</th>
                        <th>Angkatan</th>
                        <th>Dosen Pengampu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataKuliahs as $mk)
                        <tr>
                            <td>{{ $loop->iteration + ($mataKuliahs->firstItem() - 1) }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->angkatan->tahun ?? '-' }}</td>
                            <td>
                                @forelse($mk->dosens as $dosen)
                                    <span class="badge bg-info text-dark">{{ $dosen->nama }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Tombol view hanya untuk dosen --}}
                                    @if(auth()->user()->role === 'dosen')
                                        <a href="{{ route('mata_kuliahs.show', $mk->kode_mk) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    {{-- Tombol CRUD hanya untuk akademik --}}
                                    @if(auth()->user()->role === 'akademik')
                                        <a href="{{ route('mata_kuliahs.edit', $mk->kode_mk) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('mata_kuliahs.destroy', $mk->kode_mk) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $mataKuliahs->links() }}
            </div>
        </div>
    </div>
@endsection