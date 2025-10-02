<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['nim', 'teknik_id', 'nilai'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function teknik()
    {
        return $this->belongsTo(TeknikPenilaian::class, 'teknik_id', 'id');
    }
}