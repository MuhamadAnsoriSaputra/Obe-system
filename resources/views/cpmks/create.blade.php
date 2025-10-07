@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Tambah CPMK</h2>

    <div class="card shadow-lg border-0"
        style="border-radius: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); color:#fff;">
        <div class="card-body p-4">

            <form action="{{ route('cpmks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode_cpmk" class="form-label">Kode CPMK</label>
                    <input type="text" name="kode_cpmk" id="kode_cpmk"
                        class="form-control @error('kode_cpmk') is-invalid @enderror"
                        value="{{ old('kode_cpmk') }}">
                    @error('kode_cpmk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="angkatan" class="form-label">Tahun Angkatan</label>
                    <select id="angkatan" class="form-select @error('angkatan') is-invalid @enderror" required>
                        <option value="">-- Pilih Angkatan --</option>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan->kode_angkatan }}"
                                {{ old('angkatan') == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                {{ $angkatan->tahun }}
                            </option>
                        @endforeach
                    </select>
                    @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kode_cpl" class="form-label">CPL</label>
                    <select name="kode_cpl" id="kode_cpl"
                        class="form-select @error('kode_cpl') is-invalid @enderror" required>
                        <option value="">-- Pilih CPL --</option>
                    </select>
                    @error('kode_cpl')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kode_mk" class="form-label">Mata Kuliah</label>
                    <select name="kode_mk" id="kode_mk"
                        class="form-select @error('kode_mk') is-invalid @enderror" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                    </select>
                    @error('kode_mk')
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

                <div class="d-flex justify-content-end">
                    <a href="{{ route('cpmks.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-light fw-bold px-4">
                        <i class="fas fa-plus me-2"></i> Tambah
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('angkatan').addEventListener('change', function () {
        let angkatanId = this.value;

        // Fetch CPL berdasarkan angkatan
        fetch(`/api/cpl/by-angkatan/${angkatanId}`)
            .then(res => res.json())
            .then(data => {
                let cplSelect = document.getElementById('kode_cpl');
                cplSelect.innerHTML = '<option value="">-- Pilih CPL --</option>';
                data.forEach(cpl => {
                    cplSelect.innerHTML += `<option value="${cpl.kode_cpl}">${cpl.kode_cpl} - ${cpl.deskripsi}</option>`;
                });
            });

        // Fetch MK berdasarkan angkatan
        fetch(`/api/mk/by-angkatan/${angkatanId}`)
            .then(res => res.json())
            .then(data => {
                let mkSelect = document.getElementById('kode_mk');
                mkSelect.innerHTML = '<option value="">-- Pilih Mata Kuliah --</option>';
                data.forEach(mk => {
                    mkSelect.innerHTML += `<option value="${mk.kode_mk}">${mk.nama_mk}</option>`;
                });
            });
    });
</script>
@endsection
