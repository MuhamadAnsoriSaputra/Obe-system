<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CplMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'cpl_mata_kuliah';

    protected $fillable = [
        'kode_cpl',
        'kode_mk',
        'kode_angkatan',
    ];

    /** =======================
     *  RELASI
     *  ======================= */

    public function cpl()
    {
        return $this->belongsTo(Cpl::class, 'kode_cpl', 'kode_cpl');
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
