@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Mata Kuliah</h2>

        <a href="{{ route('mata_kuliahs.create') }}" class="btn btn-light fw-bold mb-3">
            <i class="fas fa-plus"></i> Tambah Mata Kuliah
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>SKS</th>
                            <th>Dosen Pengampu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mataKuliahs as $mk)
                            <tr>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->prodi->nama_prodi ?? '-' }}</td>
                                <td>{{ $mk->angkatan->nama_angkatan ?? '-' }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>
                                    @if ($mk->dosens->isNotEmpty())
                                        @foreach ($mk->dosens as $dosen)
                                            <span class="badge bg-info">{{ $dosen->nama }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('mata_kuliahs.show', $mk->kode_mk) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('mata_kuliahs.edit', $mk->kode_mk) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('mata_kuliahs.destroy', $mk->kode_mk) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada mata kuliah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $mataKuliahs->links() }}
            </div>
        </div>
    </div>
@endsection