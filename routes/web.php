<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\CplController;
use App\Http\Controllers\CpmkController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RumusanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilObeController;

/*
|--------------------------------------------------------------------------
| LOGIN & GOOGLE AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| DEFAULT REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('dashboard'));

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT PER ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('dashboard.admin'),
            'akademik' => redirect()->route('dashboard.akademik'),
            'dosen' => redirect()->route('dashboard.dosen'),
            'kaprodi' => redirect()->route('dashboard.kaprodi'),
            'wadir1' => redirect()->route('dashboard.wadir1'),
            default => abort(403, 'Role tidak dikenali'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN (SEMUA AKSES)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('prodis', ProdiController::class);
        Route::resource('angkatans', AngkatanController::class);
        Route::resource('mahasiswas', MahasiswaController::class);
        Route::resource('cpls', CplController::class);
        Route::resource('cpmks', CpmkController::class);
        Route::resource('mata_kuliahs', MataKuliahController::class);
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])->name('mata_kuliahs.simpanBobot');
        Route::delete('/mata_kuliahs/remove-cpmk/{id}', [MataKuliahController::class, 'removeCpmk'])
            ->name('mata_kuliahs.removeCpmk');
        Route::resource('dosens', DosenController::class);
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{kode_mk}/input', [PenilaianController::class, 'input'])->name('penilaian.input');
        Route::post('/penilaian/{kode_mk}/simpan', [PenilaianController::class, 'store'])->name('penilaian.store');
    });

    Route::prefix('rumusan')->middleware(['role:admin,kaprodi,akademik'])->name('rumusan.')->group(function () {
        Route::get('/', [RumusanController::class, 'index'])->name('index');
        Route::get('/mata_kuliah', [RumusanController::class, 'rumusanMatkul'])->name('mata_kuliah');
        Route::get('/cpl', [RumusanController::class, 'rumusanCpl'])->name('cpl');
    });




    /*
    |--------------------------------------------------------------------------
    | AKADEMIK
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,akademik'])->group(function () {
        Route::resource('mahasiswas', MahasiswaController::class);
        Route::resource('cpls', CplController::class);
        Route::resource('cpmks', CpmkController::class);
        Route::resource('mata_kuliahs', MataKuliahController::class);
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])->name('mata_kuliahs.simpanBobot');
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])
            ->name('mata_kuliahs.simpanBobot');
        Route::delete('/mata_kuliahs/{kode_mk}/remove-cpmk/{kode_cpmk}', [MataKuliahController::class, 'removeCpmk'])
            ->name('mata_kuliahs.removeCpmk');
        Route::resource('dosens', DosenController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | DOSEN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,dosen,akademik'])->group(function () {
        Route::resource('mata_kuliahs', MataKuliahController::class);
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])->name('mata_kuliahs.simpanBobot');
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])
            ->name('mata_kuliahs.simpanBobot');
        Route::delete('/mata_kuliahs/{kode_mk}/remove-cpmk/{kode_cpmk}', [MataKuliahController::class, 'removeCpmk'])
            ->name('mata_kuliahs.removeCpmk');
        Route::resource('penilaian', PenilaianController::class);
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');

        // Halaman input nilai per mata kuliah
        Route::get('/penilaian/{kode_mk}/input', [PenilaianController::class, 'input'])->name('penilaian.input');

        // Simpan nilai
        Route::post('/penilaian/{kode_mk}/simpan', [PenilaianController::class, 'store'])->name('penilaian.store');
    });

    /*
    |--------------------------------------------------------------------------
    | KAPRODI
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,akademik,kaprodi'])->group(function () {
        Route::resource('mahasiswas', MahasiswaController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | WADIR 1
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,wadir1,akademik,kaprodi'])->group(function () {
        Route::resource('mahasiswas', MahasiswaController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | API ROUTES (AJAX)
    |--------------------------------------------------------------------------
    */
    Route::prefix('api')->group(function () {
        Route::get('cpl/by-angkatan/{kode_angkatan}/{kode_prodi}', [CpmkController::class, 'getCplByAngkatan']);
        Route::get('cpmks/{kode_cpl}/{kode_mk}', [MataKuliahController::class, 'getCpmkByCpl']);
        Route::get('angkatan/by-prodi/{kode_prodi}', [AngkatanController::class, 'getByProdi']);
        Route::get('cpmk-mk-total/{kode_mk}/{kode_angkatan}', [MataKuliahController::class, 'totalBobot']);
        Route::post('/mata_kuliahs/{kode_mk}/simpan-bobot', [MataKuliahController::class, 'simpanBobot'])
            ->name('mata_kuliahs.simpanBobot');
        Route::delete('/mata_kuliahs/{kode_mk}/remove-cpmk/{kode_cpmk}', [MataKuliahController::class, 'removeCpmk'])
            ->name('mata_kuliahs.removeCpmk');
    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PER ROLE (VIEW STATIS)
    |--------------------------------------------------------------------------
    */
    Route::view('/dashboard/admin', 'dashboard.admin')->name('dashboard.admin');
    Route::view('/dashboard/akademik', 'dashboard.akademik')->name('dashboard.akademik');
    Route::view('/dashboard/dosen', 'dashboard.dosen')->name('dashboard.dosen');
    Route::view('/dashboard/kaprodi', 'dashboard.kaprodi')->name('dashboard.kaprodi');
    Route::view('/dashboard/wadir1', 'dashboard.wadir1')->name('dashboard.wadir1');
});
