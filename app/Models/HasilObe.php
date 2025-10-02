<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilObe extends Model
{
    protected $primaryKey = 'id_hasil';
    protected $fillable = ['nim', 'kode_cpl', 'capaian_persentase'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function cpl()
    {
        return $this->belongsTo(Cpl::class, 'kode_cpl', 'kode_cpl');
    }
}