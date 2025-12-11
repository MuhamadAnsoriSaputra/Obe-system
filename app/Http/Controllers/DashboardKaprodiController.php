<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardKaprodiController extends Controller
{
    public function index()
    {
        //  Hitung jumlah entitas penting
        $jumlahKurikulum = DB::table('angkatans')->count(); // Kurikulum = Angkatan
        $jumlahDosen = DB::table('dosens')->count();
        $jumlahMataKuliah = DB::table('mata_kuliahs')->count();
        $jumlahCPL = DB::table('cpls')->count();
        $jumlahCPMK = DB::table('cpmks')->count();

        // 🔹Hitung rata-rata capaian per kurikulum (angkatan)
        $capaianPerKurikulum = DB::table('hasil_obes')
            ->join('mahasiswas', 'hasil_obes.nim', '=', 'mahasiswas.nim')
            ->join('angkatans', 'mahasiswas.kode_angkatan', '=', 'angkatans.kode_angkatan')
            ->select(
                'angkatans.tahun as kurikulum',
                DB::raw('ROUND(AVG(hasil_obes.capaian_persentase), 2) as rata_rata')
            )
            ->groupBy('angkatans.tahun')
            ->orderBy('angkatans.tahun')
            ->get();

        return view('dashboard.kaprodi', compact(
            'jumlahKurikulum',
            'jumlahDosen',
            'jumlahMataKuliah',
            'jumlahCPL',
            'jumlahCPMK',
            'capaianPerKurikulum'
        ));
    }
}
