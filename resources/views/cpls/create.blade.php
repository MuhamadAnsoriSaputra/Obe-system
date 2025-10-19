@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah CPL</h2>

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body p-4">

                <form action="{{ route('cpls.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_cpl" class="form-label">Kode CPL</label>
                        <input type="text" name="kode_cpl" id="kode_cpl"
                            class="form-control @error('kode_cpl') is-invalid @enderror" value="{{ old('kode_cpl') }}">
                        @error('kode_cpl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <div class="mb-3">
                            <label for="kode_prodi" class="form-label">Program Studi</label>
                            <select name="kode_prodi" id="kode_prodi"
                                class="form-select @error('kode_prodi') is-invalid @enderror">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="kode_angkatan" class="form-label">Kurikulum</label>
                        <select name="kode_angkatan" id="kode_angkatan"
                            class="form-select @error('kode_angkatan') is-invalid @enderror" required>
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                            @endforeach
                        </select>
                        @error('kode_angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi CPL</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('cpls.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection