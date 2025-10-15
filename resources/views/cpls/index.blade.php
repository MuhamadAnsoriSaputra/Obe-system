@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPL</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('cpls.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah CPL
            </a>

            <form action="{{ route('cpls.index') }}" method="GET" class="d-flex align-items-center" role="search">
                <div class="d-flex align-items-center"
                    style="background: #ffffff; padding:2px 10px; border-radius: 25px; max-width:250px; height:32px;">
                    <i class="fas fa-search me-2 text-dark" style="font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-dark"
                        placeholder="Cari CPL..." style="box-shadow:none; height:28px; padding:0; font-size: 14px;"
                        value="{{ request('search') }}">
                </div>
                <button type="submit"
                    class="btn ms-2 px-4 rounded-pill fw-semibold d-flex align-items-center justify-content-center"
                    style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white; transition:0.3s;">
                    Cari
                </button>

                <style>
                    button[type="submit"]:hover {
                        background: rgba(255, 255, 255, 0.2);
                        border-color: white;
                    }
                </style>
            </form>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode CPL</th>
                            <th>Deskripsi</th>
                            <th>Kurikulum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpls as $index => $cpl)
                            <tr>
                                {{-- Nomor urut otomatis sesuai pagination --}}
                                <td>{{ $loop->iteration + ($cpls->firstItem() - 1) }}</td>
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
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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

                <div class="mt-3">
                    {{ $cpls->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection