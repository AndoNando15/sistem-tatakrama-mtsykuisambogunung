<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
});

// Guest Routes (Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

    // Group Admin (Bisa diakses user dengan role Admin)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Master Data Routes
        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);
        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('mata-pelajaran', \App\Http\Controllers\Admin\MataPelajaranController::class);
        Route::resource('tahun-ajaran', \App\Http\Controllers\Admin\TahunAjaranController::class);
        Route::post('tahun-ajaran/{id}/set-aktif', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'setAktif'])->name('tahun-ajaran.set-aktif');

        // Pelanggaran & Sanksi Master Routes
        Route::resource('kategori-pelanggaran', \App\Http\Controllers\Admin\KategoriPelanggaranController::class);
        Route::resource('jenis-pelanggaran', \App\Http\Controllers\Admin\JenisPelanggaranController::class);
        Route::resource('aturan-sanksi', \App\Http\Controllers\Admin\AturanSanksiController::class);

        // Transaksi Input Poin & Rekapitulasi
        Route::resource('poin', \App\Http\Controllers\Admin\PoinSiswaController::class)->except(['edit', 'update']);
        Route::resource('rekap', \App\Http\Controllers\Admin\RekapPoinController::class)->only(['index', 'show']);

        // Laporan & Cetak Dokumen
        Route::get('laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cetak-pelanggaran', [\App\Http\Controllers\Admin\LaporanController::class, 'cetakPelanggaran'])->name('laporan.cetak-pelanggaran');
        Route::get('laporan/cetak-sp/{siswaId}', [\App\Http\Controllers\Admin\LaporanController::class, 'cetakSp'])->name('laporan.cetak-sp');

        // Pengaturan Sistem
        Route::get('settings', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('settings.update');
    });

    // Group Guru / Wali Kelas
    Route::prefix('guru')->name('guru.')->middleware('role:guru,wali_kelas')->group(function () {
        Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
        Route::get('/poin/create', [GuruDashboard::class, 'createPoin'])->name('poin.create');
        Route::post('/poin/store', [GuruDashboard::class, 'storePoin'])->name('poin.store');
        Route::get('/poin/riwayat', [GuruDashboard::class, 'riwayatPoin'])->name('poin.index');
        Route::get('/kelas', [GuruDashboard::class, 'kelasSaya'])->name('kelas.index');
    });

    // Profile — semua user authenticated dapat edit data sendiri
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});