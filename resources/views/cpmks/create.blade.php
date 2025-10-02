@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah CPMK</h2>

        <form action="{{ route('cpmks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kode_cpmk" class="form-label">Kode CPMK</label>
                <input type="text" name="kode_cpmk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="angkatan" class="form-label">Tahun Angkatan</label>
                <select id="angkatan" class="form-select" required>
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_cpl" class="form-label">CPL</label>
                <select name="kode_cpl" id="kode_cpl" class="form-select" required>
                    <option value="">-- Pilih CPL --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_mk" class="form-label">Mata Kuliah</label>
                <select name="kode_mk" id="kode_mk" class="form-select" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi_cpmk" class="form-label">Deskripsi CPMK</label>
                <textarea name="deskripsi_cpmk" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('cpmks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        document.getElementById('angkatan').addEventListener('change', function () {
            let angkatanId = this.value;

            fetch(`/api/cpl/by-angkatan/${angkatanId}`)
                .then(res => res.json())
                .then(data => {
                    let cplSelect = document.getElementById('kode_cpl');
                    cplSelect.innerHTML = '<option value="">-- Pilih CPL --</option>';
                    data.forEach(cpl => {
                        cplSelect.innerHTML += `<option value="${cpl.kode_cpl}">${cpl.kode_cpl} - ${cpl.deskripsi}</option>`;
                    });
                });

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