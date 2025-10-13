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
use App\Http\Controllers\LoginController;

// Model
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;

// ----------------------
// Public Routes
// ----------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Default redirect
Route::get('/', fn() => redirect()->route('dashboard'));

// ----------------------
// Protected Routes (auth)
// ----------------------
Route::middleware('auth')->group(function () {

    // Dashboard
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

    // Resource CRUD
    Route::resources([
        'users' => UserController::class,
        'prodis' => ProdiController::class,
        'angkatans' => AngkatanController::class,
        'mahasiswas' => MahasiswaController::class,
        'cpls' => CplController::class,
        'cpmks' => CpmkController::class,
        'mata_kuliahs' => MataKuliahController::class,
        'dosens' => DosenController::class,
    ]);

    // Mata Kuliah Detail / Bobot / CPMK
    Route::prefix('mata_kuliahs')->group(function () {
        Route::get('{kode_mk}', [MataKuliahController::class, 'show'])->name('mata_kuliahs.show');
        Route::post('{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])->name('mata_kuliahs.simpanBobot');
        Route::post('{kode_mk}/detail', [MataKuliahController::class, 'storeDetail'])->name('mata_kuliahs.storeDetail');
        Route::delete('remove-cpmk/{id}', [MataKuliahController::class, 'removeCpmk'])->name('mata_kuliahs.removeCpmk');
        Route::put('{kode_mk}/update-cpmk', [MataKuliahController::class, 'updateCpmk'])->name('mata_kuliahs.updateCpmk');
    });

    // AJAX / API Routes
    Route::prefix('api')->group(function () {
        Route::get('cpl/by-angkatan/{kode_angkatan}/{kode_prodi}', [CpmkController::class, 'getCplByAngkatan']);
        Route::get('cpmks/{kode_cpl}/{kode_mk}', [MataKuliahController::class, 'getCpmkByCpl']);
        Route::get('angkatan/by-prodi/{kode_prodi}', [AngkatanController::class, 'getByProdi']);
        Route::get('cpmk-mk-total/{kode_mk}/{kode_angkatan}', [MataKuliahController::class, 'totalBobot']);
    });

});
