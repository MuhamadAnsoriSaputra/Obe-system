@extends('layouts.app')

@section('title', 'Perangkingan')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold mb-4">Perangkingan Mahasiswa</h2>

        {{-- Dropdown Angkatan --}}
        <form method="GET" action="{{ route('perangkingan.index') }}" class="mb-4">
            <label class="fw-bold">Pilih Tahun Angkatan</label>
            <select name="kode_angkatan" class="form-select w-25" onchange="this.form.submit()">
                <option value="">-- Pilih Angkatan --</option>
                @foreach ($angkatans as $a)
                    <option value="{{ $a->kode_angkatan }}" {{ isset($kode_angkatan) && $kode_angkatan == $a->kode_angkatan ? 'selected' : '' }}>
                        {{ $a->kode_angkatan }}
                    </option>
                @endforeach
            </select>
        </form>

        @isset($hasil)
            <h4 class="fw-bold">Hasil Perangkingan</h4>

            <table class="table table-bordered mt-3">
                <thead class="table-warning">
                    <tr>
                        <th>Ranking</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @foreach ($hasil as $row)
                        <tr>
                            <td>{{ $rank++ }}</td>
                            <td>{{ $row['nim'] }}</td>
                            <td>{{ $row['nama'] }}</td>
                            <td>{{ $row['skor'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
    </div>
@endsection