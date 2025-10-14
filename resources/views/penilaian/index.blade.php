@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="fw-bold mb-4 text-primary">Penilaian Per Mata Kuliah</h3>

        <div class="row">
            @forelse ($mataKuliahs as $mk)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="fw-bold text-dark">{{ $mk->nama_mk }}</h5>
                            <p class="mb-1"><strong>Kode:</strong> {{ $mk->kode_mk }}</p>
                            <p class="mb-1"><strong>SKS:</strong> {{ $mk->sks }}</p>
                            <p class="text-muted mb-3"><strong>Prodi:</strong> {{ $mk->prodi->nama_prodi ?? '-' }}</p>

                            <a href="{{ route('penilaian.input', ['kode_mk' => $mk->kode_mk]) }}" class="btn btn-primary w-100">
                                <i class="fas fa-pen me-2"></i>Input Nilai
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">Belum ada data mata kuliah tersedia.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection