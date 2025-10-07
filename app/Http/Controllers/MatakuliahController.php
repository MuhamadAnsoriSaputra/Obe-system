<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Angkatan;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::with(['angkatan', 'dosen'])->get();
        return view('mata-kuliahs.index', compact('mataKuliahs'));
    }

    public function create()
    {
        $angkatans = Angkatan::all();
        $dosens = Dosen::all();
        return view('mata-kuliahs.create', compact('angkatans', 'dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required|string|max:255',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'nip_dosen' => 'required|exists:dosens,nip',
            'sks' => 'required|integer|min:1',
        ]);

        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'kode_angkatan' => $request->kode_angkatan,
            'nip_dosen' => $request->nip_dosen,
            'sks' => $request->sks,
        ]);

        return redirect()->route('mata-kuliahs.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        $angkatans = Angkatan::all();
        $dosens = Dosen::all();
        return view('mata-kuliahs.edit', compact('mataKuliah', 'angkatans', 'dosens'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $request->validate([
            'nama_mk' => 'required|string|max:255',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'nip_dosen' => 'required|exists:dosens,nip',
            'sks' => 'required|integer|min:1',
        ]);

        $mataKuliah->update([
            'nama_mk' => $request->nama_mk,
            'kode_angkatan' => $request->kode_angkatan,
            'nip_dosen' => $request->nip_dosen,
            'sks' => $request->sks,
        ]);

        return redirect()->route('mata-kuliahs.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->route('mata-kuliahs.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
