@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Edit Mata Kuliah</h2>

    <form action="{{ route('mata_kuliahs.update', $mataKuliah->kode_mk) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kode MK</label>
            <input type="text" class="form-control" value="{{ $mataKuliah->kode_mk }}" disabled>
        </div>

        <div class="mb-3">
            <label>Nama Mata Kuliah</label>
            <input type="text" name="nama_mk" class="form-control" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required>
        </div>

        <div class="mb-3">
            <label>Prodi</label>
            <select name="kode_prodi" id="prodi" class="form-select" required>
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->kode_prodi }}" {{ $mataKuliah->kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Angkatan</label>
            <select name="kode_angkatan" id="angkatan" class="form-select" required>
                <option value="">-- Pilih Angkatan --</option>
                @foreach($angkatans as $angkatan)
                    <option value="{{ $angkatan->kode_angkatan }}" 
                        data-prodi="{{ $angkatan->kode_prodi }}"
                        {{ $mataKuliah->kode_angkatan == $angkatan->kode_angkatan ? 'selected' : '' }}>
                        {{ $angkatan->tahun }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 bg-white p-3" style="max-height:200px; overflow-y:auto;">
            <label>Dosen Pengampu (max 2)</label>
            @foreach($dosens as $dosen)
                <div class="form-check d-flex justify-content-between">
                    <span>{{ $dosen->nama }}</span>
                    <input class="form-check-input" type="checkbox" name="dosens[]" value="{{ $dosen->nip }}"
                        {{ $mataKuliah->dosens->contains('nip', $dosen->nip) ? 'checked' : '' }}>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label>SKS</label>
            <input type="number" name="sks" class="form-control" value="{{ old('sks', $mataKuliah->sks) }}" required>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<script>
document.getElementById('prodi').addEventListener('change', function() {
    const prodi = this.value;
    const angkatan = document.getElementById('angkatan');
    Array.from(angkatan.options).forEach(opt => {
        if(opt.value === '' || opt.dataset.prodi === prodi) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });
});
</script>
@endsection
