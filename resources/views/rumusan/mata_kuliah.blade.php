@extends('layouts.app')

@section('title', 'Rumusan Per MK')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header fw-bold" style="background: #f5f5f5;">
            <h4 class="mb-0"> Rumusan Akhir Mata Kuliah</h4>
        </div>
        <div class="card-body p-4">
            <table class="table table-hover table-bordered text-center align-middle" style="border-radius: 10px; overflow: hidden;">
                <thead style="background: #fafafa; font-weight: 600;">
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
                                    <td rowspan="{{ $rowspan }}" class="fw-semibold" style="background: #fcfcfc;">{{ $mk->kode_mk }}</td>
                                @endif

                                <td>
                                    <span class="badge px-3 py-2" style="background: #e8f1f5; color: #556b7a; font-weight: 500;">
                                        {{ $cpmk->cpl->kode_cpl ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge px-3 py-2" style="background: #f0e8d8; color: #6d5b3e; font-weight: 500;">
                                        {{ $cpmk->kode_cpmk }}
                                    </span>
                                </td>

                                <td class="fw-semibold">{{ $cpmk->pivot->bobot }}</td>

                                @if($index == 0)
                                    <td rowspan="{{ $rowspan }}" class="fw-semibold" style="background: #fcfcfc;">
                                        {{ $totalBobot }}
                                    </td>
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
