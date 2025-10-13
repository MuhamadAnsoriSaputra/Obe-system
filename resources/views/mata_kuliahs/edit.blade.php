@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Edit Mata Kuliah</h2>

        <div class="card shadow-lg border-0 bg-light">
            <div class="card-body p-4">
                <form action="{{ route('mata_kuliahs.update', $mataKuliah->kode_mk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kode_mk" class="form-label">Kode MK</label>
                        <input type="text" class="form-control" value="{{ $mataKuliah->kode_mk }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" id="nama_mk" class="form-control"
                            value="{{ old('nama_mk', $mataKuliah->nama_mk) }}">
                    </div>

                    <div class="mb-3">
                        <label for="sks" class="form-label">Jumlah SKS</label>
                        <input type="number" name="sks" id="sks" class="form-control"
                            value="{{ old('sks', $mataKuliah->sks) }}">
                    </div>

                    <div class="mb-3">
                        <label for="kode_prodi" class="form-label">Program Studi</label>
                        <select name="kode_prodi" id="kode_prodi" class="form-select">
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi', $mataKuliah->kode_prodi) == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="kode_angkatan" class="form-label">Tahun Angkatan</label>
                        <select name="kode_angkatan" id="kode_angkatan" class="form-select" required>
                            <option value="">-- Pilih Tahun Angkatan --</option>
                            @foreach ($angkatans as $angkatan)
                                <option value="{{ $angkatan->kode_angkatan }}" {{ old('kode_angkatan', $mataKuliah->kode_angkatan ?? '') == $angkatan->kode_angkatan ? 'selected' : '' }}>
                                    {{ $angkatan->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Dosen Pengampu</label>
                        <div class="bg-white border rounded shadow-sm p-3" style="max-height:300px;overflow-y:auto;">
                            @foreach($dosens as $dosen)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="dosens[]" value="{{ $dosen->nip }}"
                                        id="dosen{{ $loop->index }}" {{ isset($selectedDosens) && in_array($dosen->nip, $selectedDosens) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark"
                                        for="dosen{{ $loop->index }}">{{ $dosen->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mata_kuliahs.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection