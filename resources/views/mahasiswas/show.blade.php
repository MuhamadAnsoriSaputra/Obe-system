@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Detail Mahasiswa')

@section('content')
    <div class="container">
        <h3 class="mb-3"><strong>Detail Mahasiswa</strong></h3>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
                <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi->nama_prodi }}</p>
                <p><strong>Angkatan:</strong> {{ $mahasiswa->angkatan->nama_angkatan }}</p>
            </div>
        </div>

        <!-- TABEL NILAI PER MATA KULIAH -->

        <div class="card-header text-dark mb-2">
            <strong>Rekap Nilai Per Mata Kuliah</strong>
        </div>
        <div class="card mb-4">
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Kode MK</th>
                            <th>Kode CPL</th>
                            <th>Kode CPMK</th>
                            <th>Bobot CPMK</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai as $n)
                            <tr>
                                <td>{{ $n->nama_mk }}</td>
                                <td>{{ $n->kode_mk }}</td>
                                <td>{{ $n->kode_cpl }}</td>
                                <td>{{ $n->kode_cpmk }}</td>
                                <td>{{ $n->skor_maks }}</td>
                                <td>{{ $n->nilai_perkuliahan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TABEL CAPAIAN CPL -->
        <!-- REKAP PER CPL -->
        <div class="card-header text-dark fw-bold mb-2">
            Tampilan Per CPL
        </div>
        <div class="card mb-4">
            <div class="card-body p-0">
                <table class="table table-bordered text-center align-middle">
                    <thead style="background: #f1c232; font-weight:bold;">
                        <tr>
                            <th style="vertical-align: middle;">CPL</th>
                            <th style="vertical-align: middle;">MK</th>
                            <th style="vertical-align: middle;">CPMK</th>
                            <th style="vertical-align: middle;">Bobot CPMK</th>
                            <th style="vertical-align: middle;">Skor</th>
                            <th style="vertical-align: middle; width: 200px;">
                                Capaian CPL <br> (Total nilai perkuliahan / Total skor Maks) × 100%
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai_per_cpl as $kode_cpl => $items)
                            @php $firstRow = true; @endphp
                            @foreach ($items as $item)
                                <tr>
                                    @if ($firstRow)
                                        <td rowspan="{{ count($items) }}" class="fw-bold">{{ $kode_cpl }}</td>
                                    @endif

                                    <td>{{ $item->kode_mk }}</td>
                                    <td>{{ $item->kode_cpmk }}</td>
                                    <td>{{ $item->skor_maks }}</td>
                                    <td>{{ $item->nilai_perkuliahan }}</td>

                                    @if ($firstRow)
                                        <td rowspan="{{ count($items) }}" class="fw-bold">
                                            {{ $capaian_cpl[$kode_cpl] }}%
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection