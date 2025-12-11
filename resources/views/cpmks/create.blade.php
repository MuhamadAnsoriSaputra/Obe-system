@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush

@section('title', 'CPMK | Tambah')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah CPMK</h2>

        <div class="card shadow-lg border-0 custom-form">
            <div class="card-body p-4">
                <form action="{{ route('cpmks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_cpmk" class="form-label">Kode CPMK</label>
                        <input type="text" name="kode_cpmk" id="kode_cpmk"
                            class="form-control @error('kode_cpmk') is-invalid @enderror" value="{{ old('kode_cpmk') }}">
                        @error('kode_cpmk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_cpmk" class="form-label">Deskripsi CPMK</label>
                        <textarea name="deskripsi_cpmk" id="deskripsi_cpmk" rows="3"
                            class="form-control @error('deskripsi_cpmk') is-invalid @enderror">{{ old('deskripsi_cpmk') }}</textarea>
                        @error('deskripsi_cpmk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_cpl" class="form-label">Pilih CPL</label>
                        <select name="kode_cpl" id="kode_cpl" class="form-select @error('kode_cpl') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih CPL --</option>
                            @foreach($cpls as $cpl)
                                <option value="{{ $cpl->kode_cpl }}" {{ old('kode_cpl') == $cpl->kode_cpl ? 'selected' : '' }}>
                                    {{ $cpl->kode_cpl }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_cpl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('cpmks.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection