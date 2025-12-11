@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Rumusan Per CPL')

@section('content')
    <div class="card-header fw-bold">
        <h4 class="mb-0">Rumusan Akhir CPL</h4>
    </div>
    <div class="card-body p-4">

        <table class="table table-hover table-bordered text-center align-middle"
            style="border-radius: 10px; overflow: hidden;">
            <thead style="background: #fafafa; font-weight: 600;">
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
                                <td rowspan="{{ $rows->count() }}" class="fw-semibold" style="background: #fcfcfc;">
                                    {{ $cpl->kode_cpl }}
                                </td>
                            @endif

                            <td>
                                <span class="badge px-3 py-2" style="background: #e8f1f5; color: #556b7a; font-weight: 500;">
                                    {{ $row['mk'] }}
                                </span>
                            </td>

                            <td>
                                <span class="badge px-3 py-2" style="background: #f0e8d8; color: #6d5b3e; font-weight: 500;">
                                    {{ $row['cpmk'] }}
                                </span>
                            </td>

                            <td class="fw-semibold">{{ $row['bobot'] }}</td>

                            @if($index == 0)
                                <td rowspan="{{ $rows->count() }}" class="fw-semibold" style="background: #fcfcfc;">
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