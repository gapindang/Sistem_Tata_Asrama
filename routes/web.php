<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PenghargaanController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\WargaController;
use App\Models\Pelanggaran;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $role = $user->role ?? session('role');

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'warga':
                return redirect()->route('warga.dashboard');
            default:
                return redirect('/login');
        }
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/verify-otp', [RegisterController::class, 'verifyForm'])->name('auth.verify-otp');
    Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('auth.resend-otp');

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = $user->role ?? session('role');

        dd($user);

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'warga':
                return redirect()->route('warga.dashboard');
            default:
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    })->name('dashboard');

    Route::prefix('admin')
        ->middleware(['auth:admin'])
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('admin.dashboard');

            Route::get('/notifikasi', [NotifikasiController::class, 'index'])
                ->name('admin.notifikasi.index');
            Route::get('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])
                ->name('admin.notifikasi.read');
            Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])
                ->name('admin.notifikasi.destroy');

            Route::get('/search', [SearchController::class, 'index'])
                ->name('admin.search');
            Route::get('/search/results', [SearchController::class, 'search'])
                ->name('admin.search.results');

            Route::get('/warga', [WargaController::class, 'index'])
                ->name('admin.warga.index');
            Route::get('/warga/create', [WargaController::class, 'create'])
                ->name('admin.warga.create');
            Route::post('/warga', [WargaController::class, 'store'])
                ->name('admin.warga.store');
            Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])
                ->name('admin.warga.edit');
            Route::put('/warga/{id}', [WargaController::class, 'update'])
                ->name('admin.warga.update');
            Route::delete('/warga/{id}', [WargaController::class, 'destroy'])
                ->name('admin.warga.destroy');
            Route::get('/warga/{id}', [WargaController::class, 'show'])
                ->name('admin.warga.show');
            Route::get('/warga/filter', [WargaController::class, 'filter'])
                ->name('admin.warga.filter');
            Route::get('/warga/{id}/riwayat', [RiwayatController::class, 'index'])
                ->name('admin.warga.riwayat');

            Route::get('/pelanggaran', [PelanggaranController::class, 'index'])
                ->name('admin.pelanggaran.index');
            Route::get('/pelanggaran/create', [PelanggaranController::class, 'create'])
                ->name('admin.pelanggaran.create');
            Route::post('/pelanggaran', [PelanggaranController::class, 'store'])
                ->name('admin.pelanggaran.store');
            Route::get('/pelanggaran/{id}/edit', [PelanggaranController::class, 'edit'])
                ->name('admin.pelanggaran.edit');
            Route::put('/pelanggaran/{id}', [PelanggaranController::class, 'update'])
                ->name('admin.pelanggaran.update');
            Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])
                ->name('admin.pelanggaran.destroy');
            Route::get('/pelanggaran/{id}', [PelanggaranController::class, 'show'])
                ->name('admin.pelanggaran.show');

            Route::get('/penghargaan', [PenghargaanController::class, 'index'])
                ->name('admin.penghargaan.index');
            Route::get('/penghargaan/create', [PenghargaanController::class, 'create'])
                ->name('admin.penghargaan.create');
            Route::post('/penghargaan', [PenghargaanController::class, 'store'])
                ->name('admin.penghargaan.store');
            Route::get('/penghargaan/{id}/edit', [PenghargaanController::class, 'edit'])
                ->name('admin.penghargaan.edit');
            Route::put('/penghargaan/{id}', [PenghargaanController::class, 'update'])
                ->name('admin.penghargaan.update');
            Route::delete('/penghargaan/{id}', [PenghargaanController::class, 'destroy'])
                ->name('admin.penghargaan.destroy');
            Route::get('/penghargaan/{id}', [PenghargaanController::class, 'show'])
                ->name('admin.penghargaan.show');

            Route::get('/denda', [DendaController::class, 'index'])
                ->name('admin.denda.index');
            Route::get('/denda/create', [DendaController::class, 'create'])
                ->name('admin.denda.create');
            Route::post('/denda', [DendaController::class, 'store'])
                ->name('admin.denda.store');
            Route::get('/denda/{id}/edit', [DendaController::class, 'edit'])
                ->name('admin.denda.edit');
            Route::put('/denda/{id}', [DendaController::class, 'update'])
                ->name('admin.denda.update');
            Route::delete('/denda/{id}', [DendaController::class, 'destroy'])
                ->name('admin.denda.destroy');

            Route::get('/kalender', [KalenderController::class, 'index'])
                ->name('admin.kalender.index');

            Route::get('/laporan', [LaporanController::class, 'index'])
                ->name('admin.laporan.index');
            Route::get('/laporan/export', [LaporanController::class, 'export'])
                ->name('admin.laporan.export');

            Route::get('/pengaturan', [PengaturanController::class, 'index'])
                ->name('admin.pengaturan.index');
            Route::post('/pengaturan/update', [PengaturanController::class, 'update'])
                ->name('admin.pengaturan.update');
        });

    Route::prefix('petugas')->middleware('auth:petugas')->group(function () {
        Route::get('/dashboard', fn() => view('petugas.dashboard'))->name('petugas.dashboard');
    });

    Route::prefix('warga')->middleware('auth:warga')->group(function () {
        Route::get('/dashboard', fn() => view('warga.dashboard'))->name('warga.dashboard');
    });
});
