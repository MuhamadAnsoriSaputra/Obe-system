<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Angkatan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // jika belum login, buat user "dummy" akademik sementara
        if (!$user) {
            $user = (object) [
                'role' => 'akademik',
                'id_prodi' => null, // isi sesuai kebutuhan
            ];
        }

        // logika sesuai role
        if ($user->role == 'akademik') {
            $mahasiswas = Mahasiswa::paginate(10);
        } else {
            $mahasiswas = Mahasiswa::paginate(10);

        }

        return view('mahasiswas.index', compact('mahasiswas'));
    }

    public function create()
    {
        $user = Auth::user();
        $angkatans = Angkatan::all();

        if ($user->role === 'akademik_prodi' && $user->kode_prodi) {
            $prodis = Prodi::where('kode_prodi', $user->kode_prodi)->get();
        } else {
            $prodis = Prodi::all();
        }

        return view('mahasiswas.create', compact('angkatans', 'prodis'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

        $kodeProdi = $user->role === 'akademik_prodi' ? $user->kode_prodi : $request->kode_prodi;

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_prodi' => $kodeProdi,
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $angkatans = Angkatan::all();
        $prodis = Prodi::all();

        return view('mahasiswas.edit', compact('mahasiswa', 'angkatans', 'prodis'));
    }

    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $nim . ',nim',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

        $mahasiswa->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
