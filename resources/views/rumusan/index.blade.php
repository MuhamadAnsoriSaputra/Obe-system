@extends('layouts.app')

@section('title', 'Rumusan')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-4">Pilih Jenis Rumusan</h3>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm text-center p-4">
                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    <h5>Rumusan Akhir Mata Kuliah</h5>
                    <p class="text-muted">Lihat hasil akhir tiap mata kuliah berdasarkan CPMK</p>
                    <a href="{{ route('rumusan.mata_kuliah') }}" class="btn btn-primary">Lihat Rumusan</a>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card shadow-sm text-center p-4">
                    <i class="fas fa-bullseye fa-3x text-success mb-3"></i>
                    <h5>Rumusan Akhir CPL</h5>
                    <p class="text-muted">Lihat hasil capaian pembelajaran lulusan (CPL)</p>
                    <a href="{{ route('rumusan.cpl') }}" class="btn btn-success mt-2">Lihat Rumusan</a>
                </div>
            </div>
        </div>
    </div>
@endsection