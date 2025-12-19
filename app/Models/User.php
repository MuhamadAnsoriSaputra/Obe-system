<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    //  pakai kolom id_user
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'google_id',
        'password',
        'role',
        'nama',
        'email',
        'foto',
        'kode_prodi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kolom yang otomatis dianggap tanggal
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user', 'id_user');
    }
}