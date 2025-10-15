@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Mahasiswa</h2>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tombol tambah + Search Bar --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('mahasiswas.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Mahasiswa
            </a>

            <form action="{{ route('mahasiswas.index') }}" method="GET" class="d-flex align-items-center" role="search">
                <div class="d-flex align-items-center"
                    style="background: #ffffff; padding:2px 10px; border-radius: 25px; max-width:250px; height:32px;">
                    <i class="fas fa-search me-2 text-dark" style="font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-dark"
                        placeholder="Cari Mahasiswa..." style="box-shadow:none; height:28px; padding:0; font-size: 14px;"
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

        {{-- Card Table --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white align-middle">
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
                                        <a href="{{ route('mahasiswas.show', $mhs->nim) }}"
                                            class="btn btn-sm btn-info px-2 py-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswas.edit', $mhs->nim) }}"
                                            class="btn btn-sm btn-warning px-2 py-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('mahasiswas.destroy', $mhs->nim) }}" method="POST"
                                            class="d-inline-flex" onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger px-2 py-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $mahasiswas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection