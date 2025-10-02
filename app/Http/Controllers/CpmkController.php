<?php

namespace App\Http\Controllers;

use App\Models\Cpmk;
use App\Models\Cpl;
use App\Models\MataKuliah;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class CpmkController extends Controller
{
    public function index()
    {
        $cpmks = Cpmk::with(['cpl', 'mataKuliah'])->paginate(10);
        return view('cpmks.index', compact('cpmks'));
    }

    public function create()
    {
        $angkatans = Angkatan::all();
        return view('cpmks.create', compact('angkatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpmk' => 'required|unique:cpmks,kode_cpmk',
            'kode_cpl' => 'required|exists:cpls,kode_cpl',
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'deskripsi_cpmk' => 'required|string',
        ]);

        Cpmk::create($request->all());

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil ditambahkan.');
    }

    public function edit($kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);
        $angkatans = Angkatan::all();
        return view('cpmks.edit', compact('cpmk', 'angkatans'));
    }

    public function update(Request $request, $kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);

        $request->validate([
            'kode_cpl' => 'required|exists:cpls,kode_cpl',
            'kode_mk' => 'required|exists:mata_kuliahs,kode_mk',
            'deskripsi_cpmk' => 'required|string',
        ]);

        $cpmk->update($request->all());

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil diperbarui.');
    }

    public function destroy($kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);
        $cpmk->delete();

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil dihapus.');
    }

    // 🔹 API untuk filter CPL berdasarkan angkatan
    public function getCplByAngkatan($kode_angkatan)
    {
        $cpls = Cpl::where('kode_angkatan', $kode_angkatan)->get();
        return response()->json($cpls);
    }

    // 🔹 API untuk filter Mata Kuliah berdasarkan Prodi + Angkatan
    public function getMkByAngkatan($kode_angkatan)
    {
        $mataKuliahs = MataKuliah::where('kode_angkatan', $kode_angkatan)->get();
        return response()->json($mataKuliahs);
    }
}
