<?php

namespace App\Http\Controllers;

use App\Models\Cpl;
use App\Models\Prodi;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CplController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $cpls = Cpl::with(['prodi', 'angkatan'])
            ->when($user->role === 'akademik' && $user->kode_prodi, function ($query) use ($user) {
                $query->where('kode_prodi', $user->kode_prodi);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('kode_cpl', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('angkatan', function ($q) use ($search) {
                        $q->where('tahun', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        $cpls->appends(['search' => $search]);

        return view('cpls.index', compact('cpls'));
    }


    public function create()
    {
        $user = Auth::user();
        $angkatans = Angkatan::all();

        if ($user->role === 'akademik' && $user->kode_prodi) {
            $prodis = Prodi::where('kode_prodi', $user->kode_prodi)->get();
        } else {
            $prodis = Prodi::all();
        }

        return view('cpls.create', compact('angkatans', 'prodis', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kode_cpl' => 'required|unique:cpls,kode_cpl',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'deskripsi' => 'required|string',
        ]);

        $kodeProdi = ($user->role === 'akademik' && $user->kode_prodi)
            ? $user->kode_prodi
            : $request->kode_prodi;

        Cpl::create([
            'kode_cpl' => $request->kode_cpl,
            'kode_prodi' => $kodeProdi,
            'kode_angkatan' => $request->kode_angkatan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil ditambahkan');
    }

    public function edit($kode_cpl)
    {
        $user = Auth::user();
        $cpl = Cpl::findOrFail($kode_cpl);
        $angkatans = Angkatan::all();
        $prodis = Prodi::all();

        return view('cpls.edit', compact('cpl', 'angkatans', 'prodis', 'user'));
    }

    public function update(Request $request, $kode_cpl)
    {
        $cpl = Cpl::findOrFail($kode_cpl);

        $request->validate([
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
            'deskripsi' => 'required|string',
        ]);

        $cpl->update([
            'deskripsi' => $request->deskripsi,
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil diperbarui');
    }

    public function destroy($kode_cpl)
    {
        $cpl = Cpl::findOrFail($kode_cpl);
        $cpl->delete();

        return redirect()->route('cpls.index')->with('success', 'CPL berhasil dihapus');
    }
}
