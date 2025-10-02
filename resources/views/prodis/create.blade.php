@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Tambah Prodi</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('prodis.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode_prodi" class="form-label">Kode Prodi</label>
                    <input type="text" name="kode_prodi" id="kode_prodi"
                        class="form-control @error('kode_prodi') is-invalid @enderror" value="{{ old('kode_prodi') }}">
                    @error('kode_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_prodi" class="form-label">Nama Prodi</label>
                    <input type="text" name="nama_prodi" id="nama_prodi"
                        class="form-control @error('nama_prodi') is-invalid @enderror" value="{{ old('nama_prodi') }}">
                    @error('nama_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select name="jenjang" id="jenjang" class="form-select @error('jenjang') is-invalid @enderror">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="D3" {{ old('jenjang') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="D4" {{ old('jenjang') == 'D4' ? 'selected' : '' }}>D4</option>
                        <option value="S1" {{ old('jenjang') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('jenjang') == 'S2' ? 'selected' : '' }}>S2</option>
                    </select>
                    @error('jenjang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('prodis.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-light fw-bold px-4">
                        <i class="fas fa-plus me-2"></i> Tambah
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection