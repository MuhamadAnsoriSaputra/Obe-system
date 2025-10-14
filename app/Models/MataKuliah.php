<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_mk',
        'kode_prodi',
        'kode_angkatan',
        'nama_mk',
        'sks',
    ];

    /** =======================
     *  RELASI
     *  ======================= */

    // Setiap mata kuliah milik satu prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    // Setiap mata kuliah bisa dipakai di satu angkatan
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    // Relasi ke CPMK (many-to-many)
    public function cpmks()
    {
        return $this->belongsToMany(Cpmk::class, 'cpmk_mata_kuliah', 'kode_mk', 'kode_cpmk')
            ->withPivot('kode_angkatan', 'bobot')
            ->withTimestamps();
    }

    // Relasi ke dosen pengampu (many-to-many)
    public function dosens()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mata_kuliah', 'kode_mk', 'nip')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }

    public function cpls()
    {
        return $this->belongsToMany(Cpl::class, 'cpl_mata_kuliah', 'kode_mk', 'kode_cpl')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }
}
