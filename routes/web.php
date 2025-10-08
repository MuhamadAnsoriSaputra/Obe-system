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
Route::get('/cpl/{kode_angkatan}', [CpmkController::class, 'getCplByAngkatan']);
Route::get('/cpmk/{kode_cpl}', [MataKuliahController::class, 'getCpmkByCpl']);

// CRUD Routes pakai resource
Route::resource('users', UserController::class);
Route::resource('prodis', ProdiController::class);
Route::resource('angkatans', AngkatanController::class);
Route::resource('mahasiswas', MahasiswaController::class);
Route::resource('cpls', CplController::class);
Route::resource('cpmks', CpmkController::class);
Route::resource('mata_kuliahs', MataKuliahController::class);
Route::resource('dosens', DosenController::class);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/mata_kuliahs/{kode_mk}', [MataKuliahController::class, 'show'])->name('mata_kuliahs.show');
Route::get('/mata_kuliahs/{kode_mk}', [MataKuliahController::class, 'show'])->name('mata_kuliahs.show');
Route::post('/mata_kuliahs/{kode_mk}/add-cpmk', [MataKuliahController::class, 'addCpmk'])->name('mata_kuliahs.addCpmk');
Route::delete('/mata_kuliahs/remove-cpmk/{id}', [MataKuliahController::class, 'removeCpmk'])->name('mata_kuliahs.removeCpmk');
Route::put('/mata_kuliahs/{kode_mk}/update-cpmk', [MataKuliahController::class, 'updateCpmk'])
    ->name('mata_kuliahs.updateCpmk');

Route::get('api/cpmks/{kode_cpl}/{kode_mk}', function ($kode_cpl, $kode_mk) {
    $cpmks = App\Models\Cpmk::where('kode_cpl', $kode_cpl)
        ->with([
            'mataKuliahs' => function ($q) use ($kode_mk) {
                $q->where('kode_mk', $kode_mk);
            }
        ])->get();

    return response()->json($cpmks);
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});