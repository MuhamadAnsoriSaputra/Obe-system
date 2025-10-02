@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Manajemen Prodi</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('prodis.create') }}" class="btn btn-light fw-bold">
            <i class="fas fa-plus me-2"></i> Tambah Prodi
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover text-white">
                <thead>
                    <tr>
                        <th>Kode Prodi</th>
                        <th>Nama Prodi</th>
                        <th>Jenjang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prodis as $prodi)
                        <tr>
                            <td>{{ $prodi->kode_prodi }}</td>
                            <td>{{ $prodi->nama_prodi }}</td>
                            <td>{{ $prodi->jenjang }}</td>
                            <td>
                                <a href="{{ route('prodis.edit', $prodi->kode_prodi) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('prodis.destroy', $prodi->kode_prodi) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus prodi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada Prodi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $prodis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection