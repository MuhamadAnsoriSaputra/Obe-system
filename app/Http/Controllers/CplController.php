<?php

namespace App\Http\Controllers;

use App\Models\Cpl;
use App\Models\Prodi;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class CplController extends Controller
{
    public function index()
    {
        $cpls = Cpl::with(['prodi', 'angkatan'])->paginate(10);
        return view('cpls.index', compact('cpls'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        return view('cpls.create', compact('prodis', 'angkatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpl' => 'required|unique:cpls,kode_cpl',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'deskripsi' => 'required|string',
        ]);

        Cpl::create($request->all());

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil ditambahkan');
    }

    public function edit($kode_cpl)
    {
        $cpl = Cpl::findOrFail($kode_cpl);
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        return view('cpls.edit', compact('cpl', 'prodis', 'angkatans'));
    }

    public function update(Request $request, $kode_cpl)
    {
        $cpl = Cpl::findOrFail($kode_cpl);

        $request->validate([
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'deskripsi' => 'required|string',
        ]);

        $cpl->update($request->all());

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil diperbarui');
    }

    public function destroy($kode_cpl)
    {
        $cpl = Cpl::findOrFail($kode_cpl);
        $cpl->delete();

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil dihapus');
    }
}