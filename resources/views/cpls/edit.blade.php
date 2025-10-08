@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Edit CPL</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('cpls.update', $cpl->kode_cpl) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode_cpl" class="form-label">Kode CPL</label>
                    <input type="text" name="kode_cpl" id="kode_cpl" class="form-control" value="{{ $cpl->kode_cpl }}" readonly>
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" id="kode_prodi" class="form-select">
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ $cpl->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="kode_angkatan" class="form-label">Tahun Angkatan</label>
                    <select name="kode_angkatan" id="kode_angkatan" class="form-select" required>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->kode_angkatan }}" {{ $cpl->kode_angkatan == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                {{ $angkatan->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi CPL</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" required>{{ $cpl->deskripsi }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('cpls.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-light fw-bold px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
