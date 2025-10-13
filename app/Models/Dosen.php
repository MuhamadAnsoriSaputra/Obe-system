<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'id_user',
        'nama',
        'gelar',
        'jabatan',
        'kode_prodi',
    ];

    /** =======================
     *  RELASI
     *  ======================= */

    // Setiap dosen memiliki 1 user (akun login)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Setiap dosen milik satu prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    // Relasi ke mata kuliah yang diampu (many-to-many)
    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliah', 'nip', 'kode_mk')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }
}
