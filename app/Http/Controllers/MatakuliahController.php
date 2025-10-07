<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::with(['prodi', 'angkatan'])->get();
        return view('mata_kuliahs.index', compact('mataKuliahs'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        return view('mata_kuliahs.create', compact('prodis', 'angkatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk',
            'kode_prodi' => 'required',
            'kode_angkatan' => 'required',
            'nama_mk' => 'required',
            'sks' => 'required|integer|min:1',
        ]);

        MataKuliah::create($request->all());
        return redirect()->route('mata_kuliahs.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function edit($kode_mk)
    {
        $mataKuliah = MataKuliah::findOrFail($kode_mk);
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        return view('mata_kuliahs.edit', compact('mataKuliah', 'prodis', 'angkatans'));
    }

    public function update(Request $request, $kode_mk)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'kode_angkatan' => 'required',
            'nama_mk' => 'required',
            'sks' => 'required|integer|min:1',
        ]);

        $mataKuliah = MataKuliah::findOrFail($kode_mk);
        $mataKuliah->update($request->all());

        return redirect()->route('mata_kuliahs.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy($kode_mk)
    {
        $mataKuliah = MataKuliah::findOrFail($kode_mk);
        $mataKuliah->delete();

        return redirect()->route('mata_kuliahs.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}
