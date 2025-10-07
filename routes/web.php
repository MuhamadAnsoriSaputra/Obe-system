<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\CplController;
use App\Http\Controllers\CpmkController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\DosenController;

// Model
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;

// DASHBOARD
Route::get('/dashboard', function () {
    $stats = [
        'users' => User::count(),
        'dosens' => Dosen::count(),
        'mahasiswas' => Mahasiswa::count(),
        'prodis' => Prodi::count(),
        'mata_kuliahs' => MataKuliah::count(),
    ];
    return view('dashboard', compact('stats'));
})->name('dashboard');

// DEFAULT REDIRECT
Route::get('/', fn() => redirect()->route('dashboard'));

// API
Route::get('/api/cpl/by-angkatan/{kode_angkatan}', [CpmkController::class, 'getCplByAngkatan']);
Route::get('/api/mk/by-angkatan/{kode_angkatan}', [CpmkController::class, 'getMkByAngkatan']);
Route::get('/api/angkatan/by-prodi/{kode_prodi}', [AngkatanController::class, 'getByProdi']);

// CRUD Routes pakai resource
Route::resource('users', UserController::class);
Route::resource('prodis', ProdiController::class);
Route::resource('angkatans', AngkatanController::class);
Route::resource('mahasiswas', MahasiswaController::class);
Route::resource('cpls', CplController::class);
Route::resource('cpmks', CpmkController::class);
Route::resource('mata_kuliahs', MataKuliahController::class);
Route::resource('dosens', DosenController::class);
