@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Mahasiswa</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="top-actions">
            @if(auth()->user()->role === 'akademik')
                <a href="{{ route('mahasiswas.create') }}" class="btn-tambah">
                    <i class="fas fa-plus me-2"></i> Tambah Mahasiswa
                </a>
            @endif

            <form action="{{ route('mahasiswas.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari Mahasiswa..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th class="text-center">Aksi</th>
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
                            <td class="text-nowrap text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- Semua role bisa lihat --}}
                                    <a href="{{ route('mahasiswas.show', $mhs->nim) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Hanya akademik yang bisa edit & hapus --}}
                                    @if(auth()->user()->role === 'akademik')
                                        <a href="{{ route('mahasiswas.edit', $mhs->nim) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('mahasiswas.destroy', $mhs->nim) }}" method="POST"
                                            class="d-inline-flex" onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data mahasiswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
@endsection