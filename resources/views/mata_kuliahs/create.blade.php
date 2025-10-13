@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Mata Kuliah</h2>

        <div class="card shadow-lg border-0 bg-light">
            <div class="card-body p-4">
                <form action="{{ route('mata_kuliahs.store') }}" method="POST">
                    @csrf

                    {{-- Kode MK --}}
                    <div class="mb-3">
                        <label for="kode_mk" class="form-label">Kode MK</label>
                        <input type="text" name="kode_mk" id="kode_mk" class="form-control"
                            value="{{ old('kode_mk') }}">
                    </div>

                    {{-- Nama MK --}}
                    <div class="mb-3">
                        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" id="nama_mk" class="form-control"
                            value="{{ old('nama_mk') }}">
                    </div>

                    {{-- SKS --}}
                    <div class="mb-3">
                        <label for="sks" class="form-label">Jumlah SKS</label>
                        <input type="number" name="sks" id="sks" class="form-control"
                            value="{{ old('sks') }}">
                    </div>

                    {{-- Prodi --}}
                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" id="kode_prodi" class="form-select">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}"
                                    {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun Angkatan (Dinamis) --}}
                    <div class="mb-3">
                        <label for="kode_angkatan" class="form-label">Tahun Angkatan</label>
                        <select name="kode_angkatan" id="kode_angkatan" class="form-select">
                            <option value="">-- Pilih Tahun --</option>
                            {{-- akan diisi lewat JavaScript --}}
                        </select>
                    </div>

                    {{-- Dosen Pengampu --}}
                    <div class="mb-3">
                        <label class="form-label">Dosen Pengampu</label>
                        <div class="bg-white border rounded shadow-sm p-3" style="max-height:300px;overflow-y:auto;">
                            @foreach ($dosens as $dosen)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dosens[]"
                                        value="{{ $dosen->nip }}" id="dosen{{ $loop->index }}">
                                    <label class="form-check-label text-dark"
                                        for="dosen{{ $loop->index }}">{{ $dosen->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mata_kuliahs.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ✅ Script AJAX Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const prodiSelect = document.getElementById('kode_prodi');
            const angkatanSelect = document.getElementById('kode_angkatan');

            prodiSelect.addEventListener('change', function () {
                const kodeProdi = this.value;
                angkatanSelect.innerHTML = '<option value="">-- Pilih Tahun --</option>';

                if (kodeProdi) {
                    fetch(`/api/angkatan/by-prodi/${kodeProdi}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(angkatan => {
                                const option = document.createElement('option');
                                option.value = angkatan.kode_angkatan;
                                option.textContent = angkatan.tahun;
                                angkatanSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
@endsection
