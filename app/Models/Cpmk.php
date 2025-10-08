<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    protected $primaryKey = 'kode_cpmk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_cpmk', 'kode_cpl', 'deskripsi_cpmk'];

    public function cpl()
    {
        return $this->belongsTo(Cpl::class, 'kode_cpl', 'kode_cpl');
    }

    public function mataKuliahs()
{
    return $this->belongsToMany(MataKuliah::class, 'cpmk_mata_kuliah', 'kode_cpmk', 'kode_mk')
                ->withPivot('kode_angkatan', 'bobot')
                ->withTimestamps();
}
}
