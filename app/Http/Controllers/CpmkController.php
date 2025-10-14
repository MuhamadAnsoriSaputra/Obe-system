<?php

namespace App\Http\Controllers;

use App\Models\Cpmk;
use App\Models\Cpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpmkController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->input('search'); // ambil input pencarian

    // Query dasar CPMK + relasi CPL
    $query = Cpmk::with('cpl');

    // Filter prodi akademik
    if ($user->role === 'akademik' && $user->kode_prodi) {
        $query->whereHas('cpl', function ($q) use ($user) {
            $q->where('kode_prodi', $user->kode_prodi);
        });
    }

    // Filter berdasarkan kata kunci
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('kode_cpmk', 'like', "%{$search}%")
              ->orWhere('deskripsi_cpmk', 'like', "%{$search}%")
              ->orWhereHas('cpl', function ($sub) use ($search) {
                  $sub->where('kode_cpl', 'like', "%{$search}%");
              });
        });
    }

    $cpmks = $query->paginate(10);

    return view('cpmks.index', compact('cpmks', 'search'));
}


    public function create()
    {
        $user = Auth::user();

        // Hanya tampilkan CPL sesuai prodi akademik
        if ($user->role === 'akademik' && $user->kode_prodi) {
            $cpls = Cpl::where('kode_prodi', $user->kode_prodi)->get();
        } else {
            $cpls = Cpl::all();
        }

        return view('cpmks.create', compact('cpls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_cpmk' => 'required|unique:cpmks,kode_cpmk',
            'kode_cpl' => 'required|exists:cpls,kode_cpl',
            'deskripsi_cpmk' => 'required|string',
        ]);

        Cpmk::create($request->only(['kode_cpmk', 'kode_cpl', 'deskripsi_cpmk']));

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil ditambahkan.');
    }

    public function edit($kode_cpmk)
    {
        $user = Auth::user();
        $cpmk = Cpmk::findOrFail($kode_cpmk);

        // Filter CPL sesuai prodi akademik
        if ($user->role === 'akademik' && $user->kode_prodi) {
            $cpls = Cpl::where('kode_prodi', $user->kode_prodi)->get();
        } else {
            $cpls = Cpl::all();
        }

        return view('cpmks.edit', compact('cpmk', 'cpls'));
    }

    public function update(Request $request, $kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);

        $request->validate([
            'kode_cpl' => 'required|exists:cpls,kode_cpl',
            'deskripsi_cpmk' => 'required|string',
        ]);

        $cpmk->update($request->only(['kode_cpl', 'deskripsi_cpmk']));

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil diperbarui.');
    }

    public function getCplByAngkatan($kode_angkatan, $kode_prodi)
    {
        $cpls = Cpl::where('kode_prodi', $kode_prodi)
            ->where('kode_angkatan', $kode_angkatan)
            ->get(['kode_cpl', 'deskripsi']);

        return response()->json($cpls);
    }


    public function destroy($kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);
        $cpmk->delete();

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil dihapus.');
    }
}
