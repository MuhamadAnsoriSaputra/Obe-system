@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Dosen</h2>

        {{-- Tombol Tambah + Search --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('dosens.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Dosen
            </a>

            <form action="{{ route('dosens.index') }}" method="GET" class="d-flex align-items-center" role="search">
                <div class="d-flex align-items-center"
                    style="background: #ffffff; padding:2px 10px; border-radius: 25px; max-width:250px; height:32px;">
                    <i class="fas fa-search me-2 text-dark" style="font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-dark"
                        placeholder="Cari Dosen..." style="box-shadow:none; height:28px; padding:0; font-size: 14px;"
                        value="{{ request('search') }}">
                </div>
                <button type="submit"
                    class="btn ms-2 px-4 rounded-pill fw-semibold d-flex align-items-center justify-content-center"
                    style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white; transition:0.3s;">
                    Cari
                </button>
            </form>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Card Table --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white align-middle">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Gelar</th>
                            <th>Jabatan</th>
                            <th>Prodi</th>
                            <th class="text-center">Aksi</th>
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
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('dosens.edit', $dosen->nip) }}"
                                            class="btn btn-sm btn-warning px-2 py-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dosens.destroy', $dosen->nip) }}" method="POST"
                                            class="d-inline-flex" onsubmit="return confirm('Yakin hapus dosen ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger px-2 py-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data dosen</td>
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
    </div>
@endsection