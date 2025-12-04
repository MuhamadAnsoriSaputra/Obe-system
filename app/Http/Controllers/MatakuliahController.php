<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Angkatan;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::with(['prodi', 'angkatan', 'dosens']);

        // Jika ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_mk', 'like', '%' . $request->search . '%')
                ->orWhere('kode_mk', 'like', '%' . $request->search . '%');
        }

        $mataKuliahs = $query->paginate(10);

        // Tetap membawa kata kunci pencarian saat pagination
        $mataKuliahs->appends($request->only('search'));

        return view('mata_kuliahs.index', compact('mataKuliahs'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        $dosens = Dosen::all();
        return view('mata_kuliahs.create', compact('prodis', 'angkatans', 'dosens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk|max:20',
            'nama_mk' => 'required|string|max:100',
            'kode_prodi' => 'required',
            'kode_angkatan' => 'required',
            'sks' => 'required|integer|min:1',
            'dosens' => 'array|nullable'
        ]);

        $mataKuliah = MataKuliah::create($validated);

        if ($request->has('dosens')) {
            $mataKuliah->dosens()->attach($request->dosens, [
                'kode_angkatan' => $request->kode_angkatan
            ]);
        }

        return redirect()->route('mata_kuliahs.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit($kode_mk)
    {
        $mataKuliah = MataKuliah::with('dosens')->findOrFail($kode_mk);
        $prodis = Prodi::all();
        $angkatans = Angkatan::all();
        $dosens = Dosen::all();
        $selectedDosens = $mataKuliah->dosens->pluck('nip')->toArray();

        return view('mata_kuliahs.edit', compact('mataKuliah', 'prodis', 'angkatans', 'dosens', 'selectedDosens'));
    }

    public function update(Request $request, $kode_mk)
    {
        $mataKuliah = MataKuliah::findOrFail($kode_mk);

        $validated = $request->validate([
            'nama_mk' => 'required|string|max:100',
            'kode_prodi' => 'required',
            'kode_angkatan' => 'required',
            'sks' => 'required|integer|min:1',
            'dosens' => 'array|nullable'
        ]);

        $mataKuliah->update($validated);

        $mataKuliah->dosens()->detach();
        if ($request->has('dosens')) {
            $mataKuliah->dosens()->attach($request->dosens, [
                'kode_angkatan' => $request->kode_angkatan
            ]);
        }

        return redirect()->route('mata_kuliahs.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function show($kode_mk)
    {
        $mataKuliah = MataKuliah::with(['prodi', 'angkatan', 'dosens', 'cpmks'])->findOrFail($kode_mk);

        $angkatans = Angkatan::all();

        $cpls = \App\Models\Cpl::where('kode_prodi', $mataKuliah->kode_prodi)->get();

        $cpmks = \App\Models\Cpmk::whereHas('cpl', function ($query) use ($mataKuliah) {
            $query->where('kode_prodi', $mataKuliah->kode_prodi);
        })->get();

        $cpmkMataKuliah = \DB::table('cpmk_mata_kuliah')
            ->where('kode_mk', $kode_mk)
            ->get();

        return view('mata_kuliahs.show', compact('mataKuliah', 'angkatans', 'cpls', 'cpmks', 'cpmkMataKuliah'));
    }


    public function destroy($kode_mk)
    {
        $mataKuliah = MataKuliah::findOrFail($kode_mk);
        $mataKuliah->dosens()->detach();
        $mataKuliah->delete();

        return redirect()->route('mata_kuliahs.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    public function getCpmkByCpl($kode_cpl, $kode_mk)
    {
        $cpmks = \App\Models\Cpmk::where('kode_cpl', $kode_cpl)
            ->get(['kode_cpmk']); // Hanya ambil kode_cpmk, tidak perlu deskripsi

        return response()->json($cpmks);
    }


    public function getAngkatanByProdi(Request $request)
    {
        $angkatans = Angkatan::where('kode_prodi', $request->kode_prodi)
            ->select('kode_angkatan', 'tahun')
            ->get();

        return response()->json($angkatans);
    }

    public function simpanBobot(Request $request, $kode_mk)
    {
        $validated = $request->validate([
            'kode_angkatan' => 'required',
            'kode_cpmk' => 'required',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        // ✅ CEGAH BOBOT 0%
        if ($validated['bobot'] == 0) {
            return redirect()->back()->withErrors([
                'bobot' => 'Tidak bisa menambah bobot 0%'
            ]);
        }

        $cpmk = \App\Models\Cpmk::with('cpl')
            ->where('kode_cpmk', $validated['kode_cpmk'])
            ->firstOrFail();

        $kode_cpl = $cpmk->kode_cpl;

        $total = \DB::table('cpmk_mata_kuliah')
            ->where('kode_mk', $kode_mk)
            ->where('kode_angkatan', $validated['kode_angkatan'])
            ->sum('bobot');

        if ($total + $validated['bobot'] > 100) {
            return redirect()->back()->withErrors([
                'bobot' => 'Total bobot CPMK tidak boleh lebih dari 100%'
            ]);
        }

        \DB::table('cpmk_mata_kuliah')->updateOrInsert(
            [
                'kode_mk' => $kode_mk,
                'kode_angkatan' => $validated['kode_angkatan'],
                'kode_cpmk' => $validated['kode_cpmk'],
            ],
            [
                'bobot' => $validated['bobot'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        \DB::table('cpl_mata_kuliah')->updateOrInsert(
            [
                'kode_mk' => $kode_mk,
                'kode_cpl' => $kode_cpl,
                'kode_angkatan' => $validated['kode_angkatan'],
            ],
            [
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Bobot CPMK berhasil disimpan.');
    }


    public function totalBobot($kode_mk, $kode_angkatan)
    {
        $total = \DB::table('cpmk_mata_kuliah')
            ->where('kode_mk', $kode_mk)
            ->where('kode_angkatan', $kode_angkatan)
            ->sum('bobot');

        return response()->json($total);
    }

    public function removeCpmk($id)
    {
        \DB::table('cpmk_mata_kuliah')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Bobot CPMK berhasil dihapus.');
    }

}
