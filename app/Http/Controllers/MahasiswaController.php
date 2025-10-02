<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Angkatan;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('angkatan.prodi')->paginate(10);
        return view('mahasiswas.index', compact('mahasiswas'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('mahasiswas.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_prodi' => $request->kode_prodi,
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $prodis = Prodi::all();
        return view('mahasiswas.edit', compact('mahasiswa', 'prodis'));
    }

    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $nim . ',nim',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

        $mahasiswa->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
