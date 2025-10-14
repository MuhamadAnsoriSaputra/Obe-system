@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Input Nilai - {{ $matakuliah->nama_mk }}</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('penilaian.store', $matakuliah->kode_mk) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nim" class="form-label">NIM Mahasiswa</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kode_angkatan" class="form-label">Kode Angkatan</label>
                <input type="text" name="kode_angkatan" class="form-control" value="{{ $kode_angkatan }}" readonly>
            </div>

            <table class="table table-bordered text-center align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>MK</th>
                        <th>CPL</th>
                        <th>CPMK</th>
                        <th>Skor Maks (Bobot)</th>
                        <th>Nilai Perkuliahan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cpl as $itemCpl)
                        @php
                            $relatedCpmk = $cpmk->where('kode_cpl', $itemCpl->kode_cpl);
                        @endphp

                        @foreach($relatedCpmk as $itemCpmk)
                            <tr>
                                <td>{{ $matakuliah->kode_mk }}</td>

                                <td>
                                    <input type="hidden" name="kode_cpl[]" value="{{ $itemCpl->kode_cpl }}">
                                    {{ $itemCpl->kode_cpl }}
                                </td>

                                <td>
                                    <input type="hidden" name="kode_cpmk[]" value="{{ $itemCpmk->kode_cpmk }}">
                                    {{ $itemCpmk->kode_cpmk }}
                                </td>

                                {{-- Skor Maks diambil dari bobot CPMK-MK --}}
                                <td>
                                    <input type="number" name="skor_maks[]" class="form-control text-center" step="0.01"
                                        value="{{ $itemCpmk->skor_maks }}" readonly>
                                </td>

                                <td>
                                    <input type="number" name="nilai_perkuliahan[]" class="form-control text-center" step="0.01"
                                        required>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Simpan Nilai</button>
        </form>
    </div>
@endsection