@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Tambah Mata Kuliah</h2>

        <form action="{{ route('mata_kuliahs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kode MK</label>
                <input type="text" name="kode_mk" class="form-control" value="{{ old('kode_mk') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Mata Kuliah</label>
                <input type="text" name="nama_mk" class="form-control" value="{{ old('nama_mk') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prodi</label>
                <select name="kode_prodi" id="prodi" class="form-select" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Angkatan</label>
                <select name="kode_angkatan" id="angkatan" class="form-select" required>
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $angkatan)
                        <option value="{{ $angkatan->kode_angkatan }}" data-prodi="{{ $angkatan->kode_prodi }}">
                            {{ $angkatan->tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Dosen Pengampu (max 2)</label>
                <div class="border rounded bg-white text-dark p-2"
                    style="max-height: 300px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px;">
                    @foreach($dosens as $dosen)
                        <label class="d-flex justify-content-between align-items-center border-bottom pb-1">
                            <span>{{ $dosen->nama }}</span>
                            <input class="form-check-input dosen-checkbox" type="checkbox" name="dosens[]"
                                id="dosen-{{ $dosen->nip }}" value="{{ $dosen->nip }}">
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">SKS</label>
                <input type="number" name="sks" class="form-control" value="{{ old('sks', 2) }}" required>
            </div>

            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        // Filter angkatan sesuai prodi
        document.getElementById('prodi').addEventListener('change', function () {
            const prodi = this.value;
            const angkatan = document.getElementById('angkatan');
            Array.from(angkatan.options).forEach(opt => {
                if (opt.value === '' || opt.dataset.prodi === prodi) {
                    opt.style.display = '';
                } else {
                    opt.style.display = 'none';
                }
            });
            angkatan.value = '';
        });

        // Batasi maksimum 2 dosen
        const dosenCheckboxes = document.querySelectorAll('.dosen-checkbox');
        dosenCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const checked = document.querySelectorAll('.dosen-checkbox:checked');
                if (checked.length > 2) {
                    cb.checked = false;
                    alert('Maksimal 2 dosen pengampu!');
                }
            });
        });
    </script>
@endsection