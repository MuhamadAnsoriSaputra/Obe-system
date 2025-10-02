@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPMK</h2>

        <a href="{{ route('cpmks.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah CPMK
        </a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode CPMK</th>
                            <th>CPL</th>
                            <th>Mata Kuliah</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpmks as $cpmk)
                            <tr>
                                <td>{{ $cpmk->kode_cpmk }}</td>
                                <td>{{ $cpmk->cpl->kode_cpl ?? '-' }}</td>
                                <td>{{ $cpmk->mataKuliah->nama_mk ?? '-' }}</td>
                                <td>{{ $cpmk->deskripsi_cpmk }}</td>
                                <td>
                                    <a href="{{ route('cpmks.edit', $cpmk->kode_cpmk) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('cpmks.destroy', $cpmk->kode_cpmk) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada CPMK</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $cpmks->links() }}
            </div>
        </div>
    </div>
@endsection