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

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function cpmks()
    {
        return $this->belongsToMany(Cpmk::class, 'cpmk_mata_kuliah', 'kode_mk', 'kode_cpmk')
            ->withPivot('kode_angkatan', 'bobot')
            ->withTimestamps();
    }


    public function dosens()
    {
        return $this->belongsToMany(
            Dosen::class,
            'dosen_mata_kuliah',
            'kode_mk',
            'nip'
        );
    }
}
