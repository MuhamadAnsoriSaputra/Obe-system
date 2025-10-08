<?php

namespace App\Http\Controllers;

use App\Models\Cpmk;
use App\Models\Cpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpmkController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Filter CPMK berdasarkan prodi akademik
        if ($user->role === 'akademik' && $user->kode_prodi) {
            $cpmks = Cpmk::whereHas('cpl', function ($query) use ($user) {
                $query->where('kode_prodi', $user->kode_prodi);
            })->with('cpl')->paginate(10);
        } else {
            $cpmks = Cpmk::with('cpl')->paginate(10);
        }

        return view('cpmks.index', compact('cpmks'));
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

    public function destroy($kode_cpmk)
    {
        $cpmk = Cpmk::findOrFail($kode_cpmk);
        $cpmk->delete();

        return redirect()->route('cpmks.index')->with('success', 'CPMK berhasil dihapus.');
    }
}
