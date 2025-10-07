<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliah', 'nip', 'kode_mk')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }
}
