<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodis';
    protected $primaryKey = 'kode_prodi';
    public $incrementing = false; // karena kode_prodi string, bukan auto inc
    protected $keyType = 'string';

    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'jenjang',
    ];
}
