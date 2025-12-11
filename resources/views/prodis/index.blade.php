@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('title', 'Manajemen Prodi')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Prodi</h2>

        <div class="top-actions">
            <a href="{{ route('prodis.create') }}" class="btn-tambah">
                <i class="fas fa-plus me-2"></i> Tambah Prodi
            </a>

            {{-- Search --}}
            <form action="{{ route('prodis.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari Prodi..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('prodis.index') }}" class="btn-cari ms-2" style="background:#6c757d;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-wrapper">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode Prodi</th>
                        <th>Nama Prodi</th>
                        <th>Jenjang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prodis as $prodi)
                        <tr>
                            <td>{{ $prodi->kode_prodi }}</td>
                            <td>{{ $prodi->nama_prodi }}</td>
                            <td>{{ $prodi->jenjang }}</td>
                            <td>
                                <a href="{{ route('prodis.edit', $prodi->kode_prodi) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('prodis.destroy', $prodi->kode_prodi) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus prodi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada Prodi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $prodis->links() }}
            </div>
        </div>
    </div>
@endsection