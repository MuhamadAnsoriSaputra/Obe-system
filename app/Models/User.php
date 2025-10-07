<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';
    protected $fillable = [
        'google_id',
        'password',
        'role',
        'nama',
        'email',
        'foto',
        'kode_prodi',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }


    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user', 'id_user');
    }
}
