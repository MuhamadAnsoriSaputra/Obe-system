@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('title', 'Manajemen Bobot')

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-warning">
                {{ session('info') }}
            </div>
        @endif

        @if ($errors->has('total'))
            <div class="alert alert-danger">
                {{ $errors->first('total') }}
            </div>
        @endif

        <h2 class="fw-bold mb-4">Atur Bobot Kriteria</h2>

        {{-- Tombol Kembali --}}
        <a href="{{ route('perangkingan.index') }}" class="btn-tambah btn-kembali mb-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>

        {{-- Form Simpan Bobot --}}
        <form action="{{ route('perangkingan.bobot.simpan') }}" method="POST" class="mb-4">
            @csrf

            <table class="table table-bordered mt-3">
                <thead class="table-warning">
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matkuls as $mk)
                        <tr>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td>
                                <input type="number" step="0.001" min="0.001" name="bobot[{{ $mk->kode_mk }}]"
                                    value="{{ old('bobot.' . $mk->kode_mk, $bobot[$mk->kode_mk] ?? 1) }}" class="form-control"
                                    required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn-tambah mt-3">
                <i class="fas fa-save me-2"></i> Simpan Bobot
            </button>

        </form>
    </div>
@endsection