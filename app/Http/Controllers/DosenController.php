<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        // Ambil data dosen beserta prodi-nya
        $dosens = Dosen::with('prodi')->paginate(10);
        return view('dosens.index', compact('dosens'));
    }

    public function create()
    {
        // Ambil data user & prodi untuk dropdown
        $users = User::all();
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
        $users = User::all();
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
