<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prodi;
use App\Models\Angkatan;
use App\Models\Penilaian;
use App\Models\HasilObe;

class Mahasiswa extends Model
{
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nim', 'nama', 'email', 'kode_prodi', 'kode_angkatan'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'nim', 'nim');
    }

    public function hasilObes()
    {
        return $this->hasMany(HasilObe::class, 'nim', 'nim');
    }
}
