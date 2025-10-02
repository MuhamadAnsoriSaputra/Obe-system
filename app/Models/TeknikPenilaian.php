<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknikPenilaian extends Model
{
    protected $fillable = ['kode_mk', 'kode_angkatan', 'nama_penilaian', 'bobot'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'teknik_id', 'id');
    }
}