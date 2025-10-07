<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_mk',
        'kode_prodi',
        'kode_angkatan',
        'nama_mk',
        'sks',
        'nip_dosen' 
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function dosens()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_mata_kuliah', 'kode_mk', 'nip')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip_dosen', 'nip');
    }

    public function cpls()
    {
        return $this->belongsToMany(Cpl::class, 'cpl_mata_kuliah', 'kode_mk', 'kode_cpl')
            ->withPivot('kode_angkatan', 'bobot')
            ->withTimestamps();
    }

    public function cpmks()
    {
        return $this->hasMany(Cpmk::class, 'kode_mk', 'kode_mk');
    }

}
