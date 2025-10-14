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
        $user = Auth::user();

        // Jika role akademik → hanya tampilkan mahasiswa dari prodi-nya
        if ($user->role === 'akademik') {
            $mahasiswas = Mahasiswa::where('kode_prodi', $user->kode_prodi)->paginate(10);
        } else {
            // Admin bisa lihat semua mahasiswa
            $mahasiswas = Mahasiswa::paginate(10);
        }

        return view('mahasiswas.index', compact('mahasiswas'));
    }

    public function create()
    {
        $user = Auth::user();
        $angkatans = Angkatan::all();

        // Jika akademik → tidak perlu pilih prodi (otomatis)
        if ($user->role === 'akademik') {
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

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_prodi' => $user->role === 'akademik'
                ? $user->kode_prodi  // otomatis isi dari user login
                : $request->kode_prodi, // admin bisa pilih
            'kode_angkatan' => $request->kode_angkatan,
        ]);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($nim)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $angkatans = Angkatan::all();

        if ($user->role === 'akademik') {
            // pastikan hanya bisa edit mahasiswa dari prodi sendiri
            if ($mahasiswa->kode_prodi !== $user->kode_prodi) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit mahasiswa prodi lain.');
            }
            $prodis = Prodi::where('kode_prodi', $user->kode_prodi)->get();
        } else {
            $prodis = Prodi::all();
        }

        return view('mahasiswas.edit', compact('mahasiswa', 'angkatans', 'prodis'));
    }

    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $user = Auth::user();

        // validasi dasar
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $nim . ',nim',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

        // pastikan akademik hanya bisa update prodi-nya sendiri
        if ($user->role === 'akademik' && $mahasiswa->kode_prodi !== $user->kode_prodi) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui mahasiswa prodi lain.');
        }

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
        $user = Auth::user();

        if ($user->role === 'akademik' && $mahasiswa->kode_prodi !== $user->kode_prodi) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus mahasiswa prodi lain.');
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil dihapus');
    }

    public function show($nim)
    {
        // Ambil data mahasiswa berdasarkan NIM
        $mahasiswa = Mahasiswa::with(['prodi', 'angkatan'])->where('nim', $nim)->firstOrFail();

        // Ambil nilai mahasiswa dari tabel penilaians
        $nilai = \DB::table('penilaians')
            ->join('mata_kuliahs', 'penilaians.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('cpls', 'penilaians.kode_cpl', '=', 'cpls.kode_cpl')
            ->join('cpmks', 'penilaians.kode_cpmk', '=', 'cpmks.kode_cpmk')
            ->select(
                'mata_kuliahs.nama_mk',
                'cpls.kode_cpl',
                'cpmks.kode_cpmk',
                'penilaians.skor_maks',
                'penilaians.nilai_perkuliahan'
            )
            ->where('penilaians.nim', $nim)
            ->get();

        return view('mahasiswas.show', compact('mahasiswa', 'nilai'));
    }

}
