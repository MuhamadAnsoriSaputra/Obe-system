@extends('layouts.app')

@section('title', 'Detail Matakuliah')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-4">Detail Mata Kuliah: {{ $mataKuliah->nama_mk }}</h3>

        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <p><strong>Kode MK:</strong> {{ $mataKuliah->kode_mk }}</p>
                <p><strong>Program Studi:</strong> {{ $mataKuliah->prodi->nama_prodi ?? '-' }}</p>
                <p><strong>SKS:</strong> {{ $mataKuliah->sks }}</p>
            </div>
        </div>

        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">CPMK & Bobot</h5>


                @if ($errors->has('bobot'))
                    <div class="alert alert-danger">
                        {{ $errors->first('bobot') }}
                    </div>
                @endif

                {{-- Form tambah/ubah bobot --}}
                <form id="formBobot" action="{{ route('mata_kuliahs.simpanBobot', $mataKuliah->kode_mk) }}" method="POST">
                    @csrf

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tahun Kurikulum</label>
                        <select name="kode_angkatan" id="angkatan" class="form-select" required>
                            <option value="">-- Pilih Kurikulum --</option>
                            @foreach($angkatans as $angkatan)
                                <option value="{{ $angkatan->kode_angkatan }}">{{ $angkatan->tahun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">CPL</label>
                        <select name="kode_cpl" id="cpl" class="form-select" required>
                            <option value="">-- Pilih CPL --</option>
                        </select>
                    </div>

                    <div class="col-md-5 mb-3">
                        <label class="form-label">CPMK</label>
                        <select name="kode_cpmk" id="cpmk" class="form-select" required>
                            <option value="">-- Pilih CPMK --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bobot (%)</label>
                        <input type="number" name="bobot" class="form-control" placeholder="Contoh: 25" required min="0"
                            max="100">
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold">Simpan Bobot</button>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {

                // Ketika Tahun Angkatan dipilih → update CPL
                $('#angkatan').change(function () {
                    var kodeAngkatan = $(this).val();
                    var kodeProdi = '{{ $mataKuliah->kode_prodi }}'; // Prodi MK saat ini

                    $('#cpl').html('<option value="">Loading...</option>');
                    $('#cpmk').html('<option value="">-- Pilih CPMK --</option>');

                    if (kodeAngkatan) {
                        $.get('/api/cpl/by-angkatan/' + kodeAngkatan + '/' + kodeProdi, function (data) {
                            var options = '<option value="">-- Pilih CPL --</option>';
                            data.forEach(function (cpl) {
                                options += '<option value="' + cpl.kode_cpl + '">' + cpl.kode_cpl + '</option>';
                            });
                            $('#cpl').html(options);
                        }).fail(function () {
                            $('#cpl').html('<option value="">-- Pilih CPL --</option>');
                        });
                    } else {
                        $('#cpl').html('<option value="">-- Pilih CPL --</option>');
                    }
                });

                // Ketika CPL dipilih → update CPMK
                $('#cpl').change(function () {
                    var kodeCpl = $(this).val();
                    var kodeMk = '{{ $mataKuliah->kode_mk }}';

                    $('#cpmk').html('<option value="">Loading...</option>');

                    if (kodeCpl) {
                        $.get('/api/cpmks/' + kodeCpl + '/' + kodeMk, function (data) {
                            var options = '<option value="">-- Pilih CPMK --</option>';
                            data.forEach(function (cpmk) {
                                options += '<option value="' + cpmk.kode_cpmk + '">' + cpmk.kode_cpmk + '</option>';
                            });
                            $('#cpmk').html(options);
                        }).fail(function () {
                            $('#cpmk').html('<option value="">-- Pilih CPMK --</option>');
                        });
                    } else {
                        $('#cpmk').html('<option value="">-- Pilih CPMK --</option>');
                    }
                });

                // Cek bobot total sebelum submit
                $('#formBobot').submit(function (e) {
                    e.preventDefault();
                    var kodeAngkatan = $('#angkatan').val();
                    var bobot = parseFloat($('input[name="bobot"]').val());

                    if (!kodeAngkatan) { alert('Pilih angkatan dulu!'); return; }

                    $.get('/api/cpmk-mk-total/{{ $mataKuliah->kode_mk }}/' + kodeAngkatan, function (total) {
                        if (total + bobot > 100) {
                            alert('Total bobot CPMK untuk angkatan ini sudah mencapai 100%!');
                        } else {
                            e.currentTarget.submit(); // lanjut submit
                        }
                    });
                });

            });
        </script>

        {{-- Tabel CPMK yang sudah ada --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Daftar CPMK Mata Kuliah</h5>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Angkatan</th>
                            <th>CPMK</th>
                            <th>Bobot (%)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cpmkMataKuliah as $item)
                            <tr>
                                <td>{{ $item->kode_angkatan }}</td>
                                <td>{{ $item->kode_cpmk }}</td>
                                <td>{{ $item->bobot }}</td>
                                <td>
    <div class="d-flex align-items-center gap-1">
        <button type="button"
            class="btn btn-sm btn-warning btn-edit-bobot"
            data-bs-toggle="modal"
            data-bs-target="#editBobotModal"
            data-id="{{ $item->id }}"
            data-bobot="{{ $item->bobot }}">
            <i class="fas fa-edit"></i>
        </button>

        <form action="{{ route('mata_kuliahs.removeCpmk', $item->id) }}"
              method="POST"
              class="m-0 d-inline-flex">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin ingin menghapus CPMK ini dari mata kuliah?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>

                            </tr>
                            <!-- Modal Edit Bobot -->
                            <div class="modal fade" id="editBobotModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('mata_kuliahs.updateBobot', $item->id) }}" method="POST"
                                        class="modal-content">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Bobot CPMK</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Bobot (%)</label>
                                                <input type="number" name="bobot" class="form-control"
                                                    value="{{ $item->bobot }}" min="1" max="100" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada CPMK</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="modal fade" id="editBobotModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <form id="formEditBobot" method="POST" class="modal-content">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Bobot CPMK</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <label class="form-label">Bobot (%)</label>
                                <input type="number" name="bobot" id="inputBobot" class="form-control" min="1" max="100"
                                    required>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.getElementById('editBobotModal');
        const inputBobot = document.getElementById('inputBobot');
        const form = document.getElementById('formEditBobot');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const bobot = button.getAttribute('data-bobot');

            inputBobot.value = bobot;
            form.action = `/mata-kuliahs/update-bobot/${id}`;
        });

    });
</script>