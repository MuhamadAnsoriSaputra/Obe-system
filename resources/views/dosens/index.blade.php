@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Dosen</h2>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol Tambah + Search --}}
        <div class="top-actions">
            @if(auth()->user()->role === 'akademik')
                <a href="{{ route('dosens.create') }}" class="btn-tambah">
                    <i class="fas fa-plus me-2"></i> Tambah Dosen
                </a>
            @endif

            <form action="{{ route('dosens.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari Dosen..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('dosens.index') }}" class="btn-cari ms-2" style="background:#ccc; color:#000;">
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Gelar</th>
                        <th>Jabatan</th>
                        <th>Prodi</th>
                        @if(auth()->user()->role === 'akademik')
                            <th class="text-center">Aksi</th>
                        @endif
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

                            @if(auth()->user()->role === 'akademik')
                                <td class="text-center">
                                    <a href="{{ route('dosens.edit', $dosen->nip) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosens.destroy', $dosen->nip) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus dosen ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'akademik' ? 6 : 5 }}" class="text-center">
                                Belum ada data dosen
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $dosens->links() }}
            </div>
        </div>
    </div>
@endsection