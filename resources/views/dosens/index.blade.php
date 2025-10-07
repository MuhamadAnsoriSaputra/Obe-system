@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Manajemen Dosen</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tombol Tambah Dosen --}}
    <div class="mb-3">
        <a href="{{ route('dosens.create') }}" class="btn btn-light fw-bold">
            <i class="fas fa-plus me-2"></i> Tambah Dosen
        </a>
    </div>

    {{-- Tabel Dosen --}}
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover text-white align-middle">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Gelar</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosens as $dosen)
                        <tr>
                            <td>{{ $dosen->nip }}</td>
                            <td>{{ $dosen->nama }}</td>
                            <td>{{ $dosen->email }}</td>
                            <td>{{ $dosen->prodi->nama_prodi ?? '-' }}</td>
                            <td>{{ $dosen->gelar ?? '-' }}</td>
                            <td>{{ $dosen->jabatan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('dosen.edit', $dosen->nip) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dosen.destroy', $dosen->nip) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus dosen ini?')">
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
                            <td colspan="7" class="text-center">Belum ada Dosen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination (kalau pakai paginate di controller) --}}
            @if(method_exists($dosens, 'links'))
                <div class="mt-3">
                    {{ $dosens->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
