@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Mahasiswa</h2>

        <form action="{{ route('mahasiswas.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="kode_prodi" id="prodi" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_angkatan" class="form-label">Angkatan</label>
                <select name="kode_angkatan" id="kode_angkatan" class="form-select" required>
                    <option value="">-- Pilih Angkatan --</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('mahasiswas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        document.getElementById('prodi').addEventListener('change', function () {
            let prodiId = this.value;
            let angkatanSelect = document.getElementById('kode_angkatan');

            angkatanSelect.innerHTML = '<option>Loading...</option>';

            fetch(`/api/angkatan/by-prodi/${prodiId}`)
                .then(res => res.json())
                .then(data => {
                    angkatanSelect.innerHTML = '<option value="">-- Pilih Angkatan --</option>';
                    data.forEach(item => {
                        angkatanSelect.innerHTML += `<option value="${item.kode_angkatan}">${item.tahun}</option>`;
                    });
                });
        });
    </script>
@endsection