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

        if ($user->role === 'akademik') {
            $mahasiswas = Mahasiswa::where('kode_prodi', $user->kode_prodi)->paginate(10);
        } else {
            $mahasiswas = Mahasiswa::paginate(10);
        }

        return view('mahasiswas.index', compact('mahasiswas'));
    }

    public function create()
    {
        $user = Auth::user();
        $angkatans = Angkatan::all();

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
                ? $user->kode_prodi
                : $request->kode_prodi,
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

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $nim . ',nim',
            'kode_angkatan' => 'required|exists:angkatans,kode_angkatan',
        ]);

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
        $mahasiswa = Mahasiswa::with(['prodi', 'angkatan'])->where('nim', $nim)->firstOrFail();

        // Tabel Nilai per Mata Kuliah
        $nilai = \DB::table('penilaians')
            ->join('mata_kuliahs', 'penilaians.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->join('cpls', 'penilaians.kode_cpl', '=', 'cpls.kode_cpl')
            ->join('cpmks', 'penilaians.kode_cpmk', '=', 'cpmks.kode_cpmk')
            ->select(
                'mata_kuliahs.nama_mk',
                'penilaians.kode_mk',
                'cpls.kode_cpl',
                'cpmks.kode_cpmk',
                'penilaians.skor_maks',
                'penilaians.nilai_perkuliahan'
            )
            ->where('penilaians.nim', $nim)
            ->get();

        // Group by CPL dan hitung persentase
        $nilai_per_cpl = $nilai->groupBy('kode_cpl');
        $capaian_cpl = [];

        foreach ($nilai_per_cpl as $cpl => $items) {
            $total_skor = $items->sum('skor_maks');
            $total_nilai = $items->sum('nilai_perkuliahan');
            $capaian_cpl[$cpl] = $total_skor > 0 ? round(($total_nilai / $total_skor) * 100, 2) : 0;
        }

        return view('mahasiswas.show', compact('mahasiswa', 'nilai', 'nilai_per_cpl', 'capaian_cpl'));
    }
}
