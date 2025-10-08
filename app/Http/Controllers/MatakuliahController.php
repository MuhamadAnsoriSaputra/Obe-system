<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Cpl;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{

    public function index()
    {
        $mataKuliahs = MataKuliah::with(['prodi', 'angkatan', 'dosens'])->paginate(10);
        return view('mata_kuliahs.index', compact('mataKuliahs'));
    }

    public function show($kode_mk)
    {
        $mk = MataKuliah::with(['prodi', 'angkatan', 'dosens'])->findOrFail($kode_mk);
        $angkatans = Angkatan::all();
        $cpls = Cpl::where('kode_prodi', $mk->kode_prodi)->with('cpmks')->get();

        // Ambil CPMK existing per mata kuliah
        $cpmksExisting = $mk->cpmks()->get()->keyBy('kode_cpmk');

        return view('mata_kuliahs.show', compact('mk', 'angkatans', 'cpls', 'cpmksExisting'));
    }

    public function updateCpmk(Request $request, $kode_mk)
    {
        $request->validate([
            'kode_angkatan' => 'required',
            'cpmks' => 'required|array',
        ]);

        $totalBobot = array_sum($request->bobot);
        if ($totalBobot != 100) {
            return back()->with('error', 'Total bobot CPMK harus 100%');
        }

        $mataKuliah = MataKuliah::findOrFail($kode_mk);
        $kode_angkatan = $request->kode_angkatan;

        // Hapus dulu bobot lama untuk mata kuliah + angkatan
        $mataKuliah->cpmks()->wherePivot('kode_angkatan', $kode_angkatan)->detach();

        // Simpan bobot baru
        foreach ($request->cpmks as $kode_cpmk => $bobot) {
            $mataKuliah->cpmks()->attach($kode_cpmk, [
                'kode_angkatan' => $kode_angkatan,
                'bobot' => $bobot
            ]);
        }

        return redirect()->route('mata_kuliahs.show', $kode_mk)
            ->with('success', 'Bobot CPMK berhasil disimpan.');
    }
}
