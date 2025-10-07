@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4 text-white">Daftar Dosen</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tombol tambah --}}
        <a href="{{ route('dosens.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah Dosen
        </a>

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body">
                <table class="table table-hover text-white align-middle">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Gelar</th>
                            <th>Jabatan</th>
                            <th>Prodi</th>
                            <th>Email</th>
                            <th>Aksi</th>
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
                                <td>{{ $dosen->email ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('dosens.edit', $dosen->nip) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosens.destroy', $dosen->nip) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus dosen ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data dosen</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $dosens->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection