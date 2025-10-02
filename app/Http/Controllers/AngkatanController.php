<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angkatan;
use App\Models\Prodi;

class AngkatanController extends Controller
{
    public function index()
    {
        $angkatans = Angkatan::with('prodi')->latest()->paginate(10);
        return view('angkatans.index', compact('angkatans'));
    }

    public function getByProdi($kode_prodi)
    {
        $angkatans = Angkatan::where('kode_prodi', $kode_prodi)
            ->select('kode_angkatan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        return response()->json($angkatans);
    }


    public function create()
    {
        $prodis = Prodi::all(); // ambil semua prodi untuk dropdown
        return view('angkatans.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_angkatan' => 'required|unique:angkatans,kode_angkatan',
            'tahun' => 'required|integer',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
        ]);

        Angkatan::create($request->all());
        return redirect()->route('angkatans.index')->with('success', 'Angkatan berhasil ditambahkan');
    }

    public function edit(Angkatan $angkatan)
    {
        $prodis = Prodi::all();
        return view('angkatans.edit', compact('angkatan', 'prodis'));
    }

    public function update(Request $request, Angkatan $angkatan)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
        ]);

        $angkatan->update($request->all());
        return redirect()->route('angkatans.index')->with('success', 'Angkatan berhasil diperbarui');
    }

    public function destroy($kode_angkatan)
    {
        $angkatan = Angkatan::where('kode_angkatan', $kode_angkatan)->firstOrFail();
        $angkatan->delete();

        return redirect()->route('angkatans.index')->with('success', 'Data Angkatan berhasil dihapus.');
    }

}
