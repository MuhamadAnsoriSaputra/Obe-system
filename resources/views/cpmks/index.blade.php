@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen CPMK</h2>

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('cpmks.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus"></i> Tambah CPMK
            </a>

            <form action="{{ route('cpmks.index') }}" method="GET" class="d-flex" role="search">
                <input type="text" name="search" class="form-control me-2"
                       placeholder="Cari kode CPMK / CPL / deskripsi..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </form>
        </div>

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
                            <th>Kode CPMK</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpmks as $cpmk)
                            <tr>
                                <td>{{ $cpmk->kode_cpl }}</td>
                                <td>{{ $cpmk->kode_cpmk }}</td>
                                <td>{{ $cpmk->deskripsi_cpmk }}</td>
                                <td>
                                    <a href="{{ route('cpmks.edit', $cpmk->kode_cpmk) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('cpmks.destroy', $cpmk->kode_cpmk) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus CPMK ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-light">Belum ada CPMK</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination tetap membawa parameter search --}}
                {{ $cpmks->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
@endsection
