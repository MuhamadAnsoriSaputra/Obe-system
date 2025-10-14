<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpmkMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'cpmk_mata_kuliah';

    protected $fillable = [
        'kode_cpmk',
        'kode_mk',
        'kode_angkatan',
        'bobot', // nilai skor maks atau bobot
    ];

    /** =======================
     *  RELASI
     *  ======================= */

    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class, 'kode_cpmk', 'kode_cpmk');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }
}
