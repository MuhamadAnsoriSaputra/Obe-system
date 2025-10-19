<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'kode_prodi',
        'kode_angkatan',
        'tahun_masuk',
        'tahun_lulus',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'kode_angkatan', 'kode_angkatan');
    }
}
