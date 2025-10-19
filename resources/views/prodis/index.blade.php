@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fw-bold mb-4">Manajemen Prodi</h2>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('prodis.create') }}" class="btn btn-light fw-bold">
                <i class="fas fa-plus me-2"></i> Tambah Prodi
            </a>

            {{-- Search --}}
            <form action="{{ route('prodis.index') }}" method="GET" class="d-flex align-items-center" role="search">
                <div class="d-flex align-items-center"
                    style="background: #ffffff; padding:2px 10px; border-radius: 25px; max-width:250px; height:32px;">
                    <i class="fas fa-search me-2 text-dark" style="font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control border-0 bg-transparent text-dark"
                        placeholder="Cari Prodi..." style="box-shadow:none; height:28px; padding:0; font-size: 14px;"
                        value="{{ request('search') }}">
                </div>

                <button type="submit"
                    class="btn ms-2 px-4 rounded-pill fw-semibold d-flex align-items-center justify-content-center"
                    style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white; transition:0.3s;">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('prodis.index') }}" class="btn ms-2 px-3 rounded-pill fw-semibold"
                        style="height:32px; line-height: 1; border:1px solid rgba(255,255,255,0.6); background:transparent; color:white;">
                        Reset
                    </a>
                @endif

                <style>
                    button[type="submit"]:hover,
                    a[href="{{ route('prodis.index') }}"]:hover {
                        background: rgba(255, 255, 255, 0.2);
                        border-color: white;
                    }
                </style>
            </form>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-hover text-white">
                    <thead>
                        <tr>
                            <th>Kode Prodi</th>
                            <th>Nama Prodi</th>
                            <th>Jenjang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prodis as $prodi)
                            <tr>
                                <td>{{ $prodi->kode_prodi }}</td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td>{{ $prodi->jenjang }}</td>
                                <td>
                                    <a href="{{ route('prodis.edit', $prodi->kode_prodi) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('prodis.destroy', $prodi->kode_prodi) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus prodi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada Prodi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $prodis->links() }}
            </div>
        </div>
    </div>
@endsection