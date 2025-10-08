@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Edit CPMK</h2>

        <div class="card shadow-lg border-0"
            style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
            <div class="card-body p-4">
                <form action="{{ route('cpmks.update', $cpmk->kode_cpmk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kode_cpmk" class="form-label">Kode CPMK</label>
                        <input type="text" name="kode_cpmk" id="kode_cpmk" class="form-control"
                            value="{{ $cpmk->kode_cpmk }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_cpmk" class="form-label">Deskripsi CPMK</label>
                        <textarea name="deskripsi_cpmk" id="deskripsi_cpmk" rows="3"
                            class="form-control @error('deskripsi_cpmk') is-invalid @enderror">{{ old('deskripsi_cpmk', $cpmk->deskripsi_cpmk) }}</textarea>
                        @error('deskripsi_cpmk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_cpl" class="form-label">Pilih CPL</label>
                        <select name="kode_cpl" id="kode_cpl" class="form-select" required>
                            @foreach($cpls as $cpl)
                                <option value="{{ $cpl->kode_cpl }}" {{ $cpmk->kode_cpl == $cpl->kode_cpl ? 'selected' : '' }}>
                                    {{ $cpl->kode_cpl }} - {{ $cpl->deskripsi_cpl }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('cpmks.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-light fw-bold px-4">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection