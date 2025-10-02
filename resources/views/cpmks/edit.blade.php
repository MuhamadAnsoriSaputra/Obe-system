@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Edit CPMK</h2>

        <form action="{{ route('cpmks.update', $cpmk->kode_cpmk) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kode_cpmk" class="form-label">Kode CPMK</label>
                <input type="text" name="kode_cpmk" class="form-control" value="{{ $cpmk->kode_cpmk }}" readonly>
            </div>

            <div class="mb-3">
                <label for="kode_cpl" class="form-label">CPL</label>
                <select name="kode_cpl" class="form-select" required>
                    <option value="">-- Pilih CPL --</option>
                    @foreach(\App\Models\Cpl::all() as $cpl)
                        <option value="{{ $cpl->kode_cpl }}" {{ $cpmk->kode_cpl == $cpl->kode_cpl ? 'selected' : '' }}>
                            {{ $cpl->kode_cpl }} - {{ $cpl->deskripsi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_mk" class="form-label">Mata Kuliah</label>
                <select name="kode_mk" class="form-select" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach(\App\Models\MataKuliah::all() as $mk)
                        <option value="{{ $mk->kode_mk }}" {{ $cpmk->kode_mk == $mk->kode_mk ? 'selected' : '' }}>
                            {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi_cpmk" class="form-label">Deskripsi CPMK</label>
                <textarea name="deskripsi_cpmk" class="form-control" required>{{ $cpmk->deskripsi_cpmk }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('cpmks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection