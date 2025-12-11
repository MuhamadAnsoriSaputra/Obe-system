@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush

@section('title', 'Matakuliah | Tambah')

@extends('layouts.app')

@section('content')
    <div class="container">
    <h2 class="fw-bold mb-4">Tambah Matakuliah</h2>

        <div class="card shadow-lg border-0 custom-form">
            <div class="card-body p-4">
                <form action="{{ route('mata_kuliahs.store') }}" method="POST">
                    @csrf

                    {{-- Kode MK --}}
                    <div class="mb-3">
                        <label for="kode_mk" class="form-label">Kode MK</label>
                        <input type="text" name="kode_mk" id="kode_mk"
                            class="form-control @error('kode_mk') is-invalid @enderror"
                            value="{{ old('kode_mk') }}">
                        @error('kode_mk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama MK --}}
                    <div class="mb-3">
                        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" id="nama_mk"
                            class="form-control @error('nama_mk') is-invalid @enderror"
                            value="{{ old('nama_mk') }}">
                        @error('nama_mk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SKS --}}
                    <div class="mb-3">
                        <label for="sks" class="form-label">Jumlah SKS</label>
                        <input type="number" name="sks" id="sks"
                            class="form-control @error('sks') is-invalid @enderror"
                            value="{{ old('sks') }}">
                        @error('sks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Program Studi --}}
                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" id="kode_prodi"
                            class="form-select @error('kode_prodi') is-invalid @enderror">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}"
                                    {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tahun Angkatan (Dinamis) --}}
                    <div class="mb-3">
                        <label for="kode_angkatan" class="form-label">Tahun Angkatan</label>
                        <select name="kode_angkatan" id="kode_angkatan"
                            class="form-select @error('kode_angkatan') is-invalid @enderror">
                            <option value="">-- Pilih Tahun --</option>
                        </select>
                        @error('kode_angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Dosen Pengampu --}}
                    <div class="mb-3">
                        <label class="form-label">Dosen Pengampu</label>
                        <div class="border rounded p-3 custom-checkbox-wrapper">
                            @foreach ($dosens as $dosen)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dosens[]"
                                        value="{{ $dosen->nip }}" id="dosen{{ $loop->index }}">
                                    <label class="form-check-label text-dark"
                                        for="dosen{{ $loop->index }}">{{ $dosen->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('mata_kuliahs.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script AJAX Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const prodiSelect = document.getElementById('kode_prodi');
            const angkatanSelect = document.getElementById('kode_angkatan');

            prodiSelect.addEventListener('change', function () {
                const kodeProdi = this.value;
                angkatanSelect.innerHTML = '<option value="">-- Pilih Tahun --</option>';

                if (kodeProdi) {
                    fetch(`/api/angkatan/by-prodi/${kodeProdi}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(angkatan => {
                                const option = document.createElement('option');
                                option.value = angkatan.kode_angkatan;
                                option.textContent = angkatan.tahun;
                                angkatanSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
@endsection
