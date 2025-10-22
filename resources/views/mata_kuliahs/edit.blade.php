@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Edit Mata Kuliah</h2>

    <div class="card shadow-lg border-0 custom-form">
        <div class="card-body p-4">
            <form action="{{ route('mata_kuliahs.update', $mataKuliah->kode_mk) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode MK --}}
                <div class="mb-3">
                    <label for="kode_mk" class="form-label">Kode MK</label>
                    <input type="text" id="kode_mk" class="form-control" value="{{ $mataKuliah->kode_mk }}" readonly>
                </div>

                {{-- Nama MK --}}
                <div class="mb-3">
                    <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" id="nama_mk"
                        class="form-control @error('nama_mk') is-invalid @enderror"
                        value="{{ old('nama_mk', $mataKuliah->nama_mk) }}">
                    @error('nama_mk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SKS --}}
                <div class="mb-3">
                    <label for="sks" class="form-label">Jumlah SKS</label>
                    <input type="number" name="sks" id="sks"
                        class="form-control @error('sks') is-invalid @enderror"
                        value="{{ old('sks', $mataKuliah->sks) }}">
                    @error('sks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Program Studi --}}
                <div class="mb-3">
                    <label for="kode_prodi" class="form-label">Program Studi</label>
                    <select name="kode_prodi" id="kode_prodi"
                        class="form-select @error('kode_prodi') is-invalid @enderror" required>
                        <option value="">-- Pilih Prodi --</option>
                        @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->kode_prodi }}"
                                {{ old('kode_prodi', $mataKuliah->kode_prodi) == $prodi->kode_prodi ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tahun Angkatan --}}
                <div class="mb-3">
                    <label for="kode_angkatan" class="form-label">Tahun Angkatan</label>
                    <select name="kode_angkatan" id="kode_angkatan"
                        class="form-select @error('kode_angkatan') is-invalid @enderror" required>
                        @foreach ($angkatans as $angkatan)
                            <option value="{{ $angkatan->kode_angkatan }}"
                                {{ old('kode_angkatan', $mataKuliah->kode_angkatan) == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                {{ $angkatan->tahun }}
                            </option>
                        @endforeach
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
                                    value="{{ $dosen->nip }}" id="dosen{{ $loop->index }}"
                                    {{ isset($selectedDosens) && in_array($dosen->nip, $selectedDosens) ? 'checked' : '' }}>
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
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
