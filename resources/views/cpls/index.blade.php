@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPL</h2>

        <a href="{{ route('cpls.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah CPL
        </a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode CPL</th>
                            <th>Deskripsi</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpls as $cpl)
                            <tr>
                                <td>{{ $cpl->kode_cpl }}</td>
                                <td>{{ $cpl->deskripsi }}</td>
                                <td>{{ $cpl->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $cpl->angkatan->tahun ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('cpls.edit', $cpl->kode_cpl) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('cpls.destroy', $cpl->kode_cpl) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus CPL ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-light">Belum ada CPL</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $cpls->links() }}
            </div>
        </div>
    </div>
@endsection