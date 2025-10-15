<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dosens = Dosen::with(['prodi', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('gelar', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        $dosens->appends(['search' => $search]);

        return view('dosens.index', compact('dosens', 'search'));
    }

    public function create()
    {
        // Hanya user dengan role 'dosen' yang belum punya relasi dosen
        $users = User::where('role', 'dosen')
            ->whereDoesntHave('dosen')
            ->get();

        $prodis = Prodi::all();

        return view('dosens.create', compact('users', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:dosens,nip',
            'id_user' => 'required|exists:users,id_user',
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
        ]);

        Dosen::create($request->all());
        return redirect()->route('dosens.index')->with('success', 'Data dosen berhasil ditambahkan!');
    }

    public function edit($nip)
    {
        $dosen = Dosen::findOrFail($nip);

        // Semua user role 'dosen' (agar bisa ubah usernya jika perlu)
        $users = User::where('role', 'dosen')->get();
        $prodis = Prodi::all();

        return view('dosens.edit', compact('dosen', 'users', 'prodis'));
    }

    public function update(Request $request, $nip)
    {
        $dosen = Dosen::findOrFail($nip);

        $request->validate([
            'nip' => 'required|unique:dosens,nip,' . $nip . ',nip',
            'id_user' => 'required|exists:users,id_user',
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
        ]);

        $dosen->update($request->all());
        return redirect()->route('dosens.index')->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy($nip)
    {
        $dosen = Dosen::findOrFail($nip);
        $dosen->delete();

        return redirect()->route('dosens.index')->with('success', 'Data dosen berhasil dihapus!');
    }
}
