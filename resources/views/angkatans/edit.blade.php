@push('styles')
    <link href="{{ asset('css/edit.css') }}" rel="stylesheet">
@endpush

@section('title', 'Kurikulum | Edit')

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Edit Angkatan</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('angkatans.update', $angkatan->kode_angkatan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun"
                        class="form-control @error('tahun') is-invalid @enderror"
                        value="{{ old('tahun', $angkatan->tahun) }}">
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kode_prodi" class="form-label">Program Studi</label>
                    <select name="kode_prodi" id="kode_prodi"
                        class="form-select @error('kode_prodi') is-invalid @enderror">
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->kode_prodi }}"
                                {{ old('kode_prodi', $angkatan->kode_prodi) == $prodi->kode_prodi ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                            </option>
                        @endforeach
                    </select>
                    @error('kode_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('angkatans.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-light fw-bold px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
