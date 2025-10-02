<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MataKuliah;

class Dosen extends Model
{
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nip', 'id_user', 'nama', 'gelar', 'jabatan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliah', 'nip', 'kode_mk')
            ->withPivot('kode_angkatan')
            ->withTimestamps();
    }
}