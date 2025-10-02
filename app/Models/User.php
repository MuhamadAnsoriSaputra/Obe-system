<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Dosen;

class User extends Authenticatable
{
    protected $primaryKey = 'id_user';
    protected $fillable = ['google_id', 'password', 'role', 'nama', 'email', 'foto'];

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user', 'id_user');
    }
}