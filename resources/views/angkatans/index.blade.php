@extends('layouts.app')

@section('title', 'Manajemen Angkatan')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Kurikulum</h2>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('angkatans.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Kurikulum
            </a>

            {{-- Search --}}
            <form action="{{ route('angkatans.index') }}" method="GET" class="d-flex align-items-center" role="search">
                <div class="d-flex align-items-center"
                    style="background: #ffffff; padding:2px 10px; border-radius: 25px; max-width:250px; height:32px;">
                    <i class="fas fa-search me-2 text-dark" style="font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-dark"
                        placeholder="Cari kurikulum..." style="box-shadow:none; height:28px; padding:0; font-size: 14px;"
                        value="{{ request('search') }}">
                </div>

                <button type="submit"
                    class="btn ms-2 px-4 rounded-pill fw-semibold d-flex align-items-center justify-content-center"
                    style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white; transition:0.3s;">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('angkatans.index') }}" class="btn ms-2 px-3 rounded-pill fw-semibold"
                        style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Card --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
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
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $angkatans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection