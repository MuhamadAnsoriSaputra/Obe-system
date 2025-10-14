<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode_cpl';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_cpl',
        'kode_prodi',
        'kode_angkatan',
        'deskripsi', // nama kolom sesuai DB
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    // Tambahkan relasi ke CPMK
    public function cpmks()
    {
        return $this->hasMany(Cpmk::class, 'kode_cpl', 'kode_cpl');
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'cpl_mata_kuliah', 'kode_cpl', 'kode_mk')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }
}
