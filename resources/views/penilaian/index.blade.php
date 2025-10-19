@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">📊 Penilaian Per Mata Kuliah</h2>

        {{-- Alert sukses jika ada --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Card tabel mata kuliah --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataKuliahs as $index => $mk)
                            <tr>
                                {{-- Nomor urut berdasarkan pagination --}}
                                <td>{{ $loop->iteration + ($mataKuliahs->firstItem() - 1) }}</td>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>{{ $mk->prodi->nama_prodi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('penilaian.input', ['kode_mk' => $mk->kode_mk]) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i> Input Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data mata kuliah tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $mataKuliahs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
