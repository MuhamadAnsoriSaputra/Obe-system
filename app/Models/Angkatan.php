<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $primaryKey = 'kode_angkatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_angkatan', 'kode_prodi', 'tahun', 'aktif'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function cpls()
    {
        return $this->hasMany(Cpl::class, 'kode_angkatan', 'kode_angkatan');
    }
}