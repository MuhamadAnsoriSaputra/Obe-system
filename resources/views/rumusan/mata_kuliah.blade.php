@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Rumusan Akhir Mata Kuliah</h2>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-warning">
                <tr>
                    <th>MK</th>
                    <th>CPL</th>
                    <th>CPMK</th>
                    <th>Skor Maks</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mataKuliahs as $mk)
                    @php
                        $rowspan = $mk->cpmks->count();
                        $totalBobot = $mk->cpmks->sum('pivot.bobot');
                    @endphp

                    @foreach($mk->cpmks as $index => $cpmk)
                        <tr>
                            @if($index == 0)
                                <td rowspan="{{ $rowspan }}" class="table-light align-middle fw-bold">{{ $mk->kode_mk }}</td>
                            @endif
                            <td>{{ $cpmk->cpl->kode_cpl ?? '-' }}</td>
                            <td>{{ $cpmk->kode_cpmk }}</td>
                            <td>{{ $cpmk->pivot->bobot }}</td>

                            @if($index == 0)
                                <td rowspan="{{ $rowspan }}" class="table-light align-middle fw-bold">{{ $totalBobot }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection