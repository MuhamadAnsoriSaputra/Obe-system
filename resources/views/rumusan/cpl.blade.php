@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Rumusan Akhir CPL</h2>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-warning">
                <tr>
                    <th>CPL</th>
                    <th>MK</th>
                    <th>CPMK</th>
                    <th>Skor Maks</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cpls as $cpl)
                    @php
                        $rows = $cpl->cpmks->flatMap(function ($cpmk) {
                            return $cpmk->mataKuliahs->map(function ($mk) use ($cpmk) {
                                return [
                                    'mk' => $mk->kode_mk,
                                    'cpmk' => $cpmk->kode_cpmk,
                                    'bobot' => $mk->pivot->bobot ?? 0,
                                ];
                            });
                        });
                        $totalBobot = $rows->sum('bobot');
                    @endphp

                    @foreach($rows as $index => $row)
                        <tr>
                            @if($index == 0)
                                <td rowspan="{{ $rows->count() }}" class="table-light fw-bold align-middle">
                                    {{ $cpl->kode_cpl }}
                                </td>
                            @endif
                            <td>{{ $row['mk'] }}</td>
                            <td>{{ $row['cpmk'] }}</td>
                            <td>{{ $row['bobot'] }}</td>

                            @if($index == 0)
                                <td rowspan="{{ $rows->count() }}" class="table-light fw-bold align-middle">
                                    {{ number_format($totalBobot, 1) }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection