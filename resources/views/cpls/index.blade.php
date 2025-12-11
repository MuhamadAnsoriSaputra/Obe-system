@section('title', 'Manajemen CPL')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <style>
        /* Tambahan styling khusus tabel CPL */
        .table-wrapper {
            overflow-x: auto;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
        }

        table.table th,
        table.table td {
            vertical-align: middle;
            white-space: nowrap;
            /* agar teks tidak turun ke bawah kecuali kolom deskripsi */
        }

        table.table td.deskripsi {
            white-space: normal;
            /* kolom deskripsi boleh multi-baris */
            width: 50%;
            /* atur lebar deskripsi agak sempit agar kolom lain muat */
        }

        table.table th:nth-child(1) {
            width: 5%;
            text-align: center;
        }

        table.table th:nth-child(2) {
            width: 10%;
        }

        table.table th:nth-child(3) {
            width: 55%;
        }

        table.table th:nth-child(4) {
            width: 15%;
            text-align: center;
        }

        table.table th:nth-child(5) {
            width: 15%;
            text-align: center;
        }

        /* Tombol aksi sejajar */
        .aksi-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .aksi-buttons form {
            display: inline;
        }
    </style>
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
            @if(auth()->user()->role === 'akademik')
                <a href="{{ route('cpls.create') }}" class="btn-tambah">
                    <i class="fas fa-plus me-2"></i> Tambah CPL
                </a>
            @endif

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
                        <th class="text-center">Kurikulum</th>
                        @if(auth()->user()->role === 'akademik')
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($cpls as $cpl)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($cpls->firstItem() - 1) }}</td>
                            <td>{{ $cpl->kode_cpl }}</td>
                            <td class="deskripsi">{{ $cpl->deskripsi }}</td>
                            <td class="text-center">{{ $cpl->angkatan->tahun ?? '-' }}</td>

                            @if(auth()->user()->role === 'akademik')
                                <td class="text-center">
                                    <div class="aksi-buttons">
                                        <a href="{{ route('cpls.edit', $cpl->kode_cpl) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cpls.destroy', $cpl->kode_cpl) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus CPL ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'akademik' ? 5 : 4 }}" class="text-center">
                                Belum ada CPL
                            </td>
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