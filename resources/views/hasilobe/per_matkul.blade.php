@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">📊 Tampilan Per Matkul</h3>

        @foreach ($grouped as $kode_mk => $items)
            <div class="card mb-4">
                <div class="card-header bg-warning fw-bold">
                    {{ $kode_mk }} - {{ $items->first()->nama_mk }}
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered text-center align-middle m-0">
                        <thead class="table-warning">
                            <tr>
                                <th>MK</th>
                                <th>CPL</th>
                                <th>CPMK</th>
                                <th>Skor Maks</th>
                                <th>Nilai Perkuliahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->kode_mk }}</td>
                                    <td>{{ $item->kode_cpl }}</td>
                                    <td>{{ $item->kode_cpmk }}</td>
                                    <td>{{ $item->skor_maks }}</td>
                                    <td>{{ $item->nilai_perkuliahan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection