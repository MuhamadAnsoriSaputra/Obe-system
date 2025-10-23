@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <style>
        /* === Perbaikan tampilan tabel CPMK agar rapi seperti CPL === */

        /* Membuat teks panjang di kolom deskripsi turun ke bawah */
        .table td {
            white-space: normal !important;
            word-wrap: break-word;
            vertical-align: top;
        }

        /* Batas lebar maksimal setiap kolom agar tabel proporsional */
        .table th,
        .table td {
            max-width: 350px;
        }

        /* Kolom deskripsi (ke-4) biar bisa multi-line */
        .table td:nth-child(4) {
            white-space: pre-line;
        }

        /* Kolom aksi biar ikon sejajar horizontal */
        .table td:last-child {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        /* Tombol edit dan hapus seragam */
        .table .btn-warning,
        .table .btn-danger {
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
    </style>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPMK</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Top Actions --}}
        <div class="top-actions">
            @if(auth()->user()->role === 'akademik')
                <a href="{{ route('cpmks.create') }}" class="btn-tambah">
                    <i class="fas fa-plus me-2"></i> Tambah CPMK
                </a>
            @endif

            <form action="{{ route('cpmks.index') }}" method="GET" role="search" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari data..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-cari">Cari</button>

                @if(request('search'))
                    <a href="{{ route('cpmks.index') }}" class="btn-cari ms-2" style="background:#ccc; color:#000;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode CPL</th>
                        <th>Kode CPMK</th>
                        <th>Deskripsi</th>
                        @if(auth()->user()->role === 'akademik')
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($cpmks as $cpmk)
                        <tr>
                            <td>{{ $loop->iteration + ($cpmks->firstItem() - 1) }}</td>
                            <td>{{ $cpmk->kode_cpl }}</td>
                            <td>{{ $cpmk->kode_cpmk }}</td>
                            <td>{{ $cpmk->deskripsi_cpmk }}</td>

                            @if(auth()->user()->role === 'akademik')
                                <td>
                                    <a href="{{ route('cpmks.edit', $cpmk->kode_cpmk) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cpmks.destroy', $cpmk->kode_cpmk) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus CPMK ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'akademik' ? 5 : 4 }}" class="text-center">Belum ada CPMK
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $cpmks->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
@endsection