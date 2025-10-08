@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Detail Mata Kuliah --}}
        <div class="card mb-4">
            <div class="card-header">
                Detail Mata Kuliah
            </div>
            <div class="card-body">
                <p><strong>Kode MK:</strong> {{ $mk->kode_mk }}</p>
                <p><strong>Nama MK:</strong> {{ $mk->nama_mk }}</p>
                <p><strong>Prodi:</strong> {{ $mk->prodi->nama_prodi ?? '-' }}</p>
                <p><strong>Dosens:</strong>
                    @foreach($mk->dosens as $dosen)
                        {{ $dosen->nama_dosen }}@if(!$loop->last), @endif
                    @endforeach
                </p>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form Update CPMK --}}
        <form action="{{ route('mata_kuliahs.updateCpmk', $mk->kode_mk) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Dropdown Angkatan --}}
            <div class="mb-3">
                <label for="kode_angkatan" class="form-label">Angkatan</label>
                <select name="kode_angkatan" id="kode_angkatan" class="form-select" required>
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown CPL --}}
            <div class="mb-3">
                <label for="kode_cpl" class="form-label">CPL</label>
                <select name="kode_cpl" id="kode_cpl" class="form-select" required>
                    <option value="">-- Pilih CPL --</option>
                    @foreach($cpls as $cpl)
                        <option value="{{ $cpl->kode_cpl }}">{{ $cpl->kode_cpl }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Container CPMK + Bobot --}}
            <div id="cpmk-container" class="mb-3">
                {{-- CPMK akan muncul disini via JS --}}
            </div>

            <button type="submit" class="btn btn-primary">Simpan Bobot</button>
        </form>

    </div>

    {{-- Script untuk menampilkan CPMK saat CPL dipilih --}}
    <script>
        const cpls = @json($cpls->keyBy('kode_cpl')->map(fn($cpl) => $cpl->cpmks));

        document.getElementById('kode_cpl').addEventListener('change', function () {
            const selectedCpl = this.value;
            const container = document.getElementById('cpmk-container');
            container.innerHTML = '';

            if (selectedCpl && cpls[selectedCpl]) {
                cpls[selectedCpl].forEach(cpmk => {
                    const div = document.createElement('div');
                    div.classList.add('mb-2', 'd-flex', 'align-items-center');
                    div.innerHTML = `
                    <input type="text" class="form-control me-2" value="${cpmk.kode_cpmk}" readonly>
                    <input type="number" name="cpmks[${cpmk.kode_cpmk}]" class="form-control" placeholder="Bobot %" required>
                `;
                    container.appendChild(div);
                });
            }
        });
    </script>

@endsection