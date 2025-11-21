<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
use App\Http\Controllers\Admin\PetugasController;
use App\Models\Pelanggaran;

use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PelanggaranController as PetugasPelanggaranController;

use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\ProfilController as WargaProfilController;

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

    Route::get('/password/forgot', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
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

            Route::get('/warga/filter', [WargaController::class, 'filter'])->name('admin.warga.filter');
            Route::get('/warga', [WargaController::class, 'index'])->name('admin.warga.index');
            Route::get('/warga/create', [WargaController::class, 'create'])->name('admin.warga.create');
            Route::post('/warga', [WargaController::class, 'store'])->name('admin.warga.store');
            Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])->name('admin.warga.edit');
            Route::get('/warga/{id}', [WargaController::class, 'show'])->name('admin.warga.show');
            Route::put('/warga/{id}', [WargaController::class, 'update'])->name('admin.warga.update');
            Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('admin.warga.destroy');
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
            Route::get('/penghargaan/leaderboard', [PenghargaanController::class, 'leaderboard'])
                ->name('admin.penghargaan.leaderboard');
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

            Route::get('/denda', [DendaController::class, 'index'])->name('admin.denda.index');
            Route::post('/denda', [DendaController::class, 'store'])->name('admin.denda.store');
            Route::put('/denda/{id}', [DendaController::class, 'update'])->name('admin.denda.update');
            Route::delete('/denda/{id}', [DendaController::class, 'destroy'])->name('admin.denda.destroy');
            Route::post('/denda/{id}/confirm', [DendaController::class, 'confirmPayment'])->name('admin.denda.confirm');

            Route::get('/kalender', [KalenderController::class, 'index'])
                ->name('admin.kalender.index');

            Route::get('/laporan', [LaporanController::class, 'index'])
                ->name('admin.laporan.index');
            Route::get('/laporan/export', [LaporanController::class, 'export'])
                ->name('admin.laporan.export');

            Route::get('/pengaturan', [PengaturanController::class, 'index'])
                ->name('admin.pengaturan.index');
            Route::put('/pengaturan/update', [PengaturanController::class, 'update'])
                ->name('admin.pengaturan.update');
            Route::post('/pengaturan/kategori', [PengaturanController::class, 'storeKategori'])
                ->name('admin.pengaturan.kategori.store');
            Route::put('/pengaturan/kategori', [PengaturanController::class, 'updateKategori'])
                ->name('admin.pengaturan.kategori.update');
            Route::delete('/pengaturan/kategori/{id}', [PengaturanController::class, 'deleteKategori'])
                ->name('admin.pengaturan.kategori.delete');

            Route::get('/petugas', [PetugasController::class, 'index'])->name('admin.petugas.index');
            Route::get('/petugas/create', [PetugasController::class, 'create'])->name('admin.petugas.create');
            Route::post('/petugas', [PetugasController::class, 'store'])->name('admin.petugas.store');
            Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('admin.petugas.edit');
            Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('admin.petugas.update');
            Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('admin.petugas.destroy');

            Route::get('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil.index');
            Route::put('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('admin.profil.update');

            Route::get('/berita', [\App\Http\Controllers\Admin\BeritaController::class, 'index'])->name('admin.berita.index');
            Route::get('/berita/create', [\App\Http\Controllers\Admin\BeritaController::class, 'create'])->name('admin.berita.create');
            Route::post('/berita', [\App\Http\Controllers\Admin\BeritaController::class, 'store'])->name('admin.berita.store');
            Route::get('/berita/{id}', [\App\Http\Controllers\Admin\BeritaController::class, 'show'])->name('admin.berita.show');
            Route::get('/berita/{id}/edit', [\App\Http\Controllers\Admin\BeritaController::class, 'edit'])->name('admin.berita.edit');
            Route::put('/berita/{id}', [\App\Http\Controllers\Admin\BeritaController::class, 'update'])->name('admin.berita.update');
            Route::delete('/berita/{id}', [\App\Http\Controllers\Admin\BeritaController::class, 'destroy'])->name('admin.berita.destroy');
        });

    Route::prefix('petugas')->middleware('auth:petugas')->group(function () {
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');
        Route::resource('/pelanggaran', PetugasPelanggaranController::class, ['as' => 'petugas']);
        Route::get('/notifikasi', [\App\Http\Controllers\Petugas\NotifikasiController::class, 'index'])->name('petugas.notifikasi.index');
        Route::get('/notifikasi/{id}/read', [\App\Http\Controllers\Petugas\NotifikasiController::class, 'markAsRead'])->name('petugas.notifikasi.read');
        Route::delete('/notifikasi/{id}', [\App\Http\Controllers\Petugas\NotifikasiController::class, 'destroy'])->name('petugas.notifikasi.destroy');
        Route::get('/riwayat-pelanggaran/create', [\App\Http\Controllers\Petugas\RiwayatPelanggaranController::class, 'create'])->name('petugas.riwayat_pelanggaran.create');
        Route::post('/riwayat-pelanggaran', [\App\Http\Controllers\Petugas\RiwayatPelanggaranController::class, 'store'])->name('petugas.riwayat_pelanggaran.store');
        Route::post('/riwayat-pelanggaran/{id}/done', [\App\Http\Controllers\Petugas\RiwayatPelanggaranController::class, 'markAsDone'])->name('petugas.riwayat_pelanggaran.done');
        Route::resource('/warga', \App\Http\Controllers\Petugas\WargaController::class, ['as' => 'petugas']);
        Route::get('/warga/filter/kamar', [\App\Http\Controllers\Petugas\WargaController::class, 'getKamarByBlok'])->name('petugas.warga.getKamar');
        Route::get('/denda', [\App\Http\Controllers\Petugas\DendaController::class, 'index'])->name('petugas.denda.index');
        Route::post('/denda', [\App\Http\Controllers\Petugas\DendaController::class, 'store'])->name('petugas.denda.store');
        Route::put('/denda/{id}', [\App\Http\Controllers\Petugas\DendaController::class, 'update'])->name('petugas.denda.update');
        Route::post('/denda/{id}/approve', [\App\Http\Controllers\Petugas\DendaController::class, 'approve'])->name('petugas.denda.approve');
        Route::post('/denda/{id}/reject', [\App\Http\Controllers\Petugas\DendaController::class, 'reject'])->name('petugas.denda.reject');
        Route::delete('/denda/{id}', [\App\Http\Controllers\Petugas\DendaController::class, 'destroy'])->name('petugas.denda.destroy');
        Route::get('/riwayat-penghargaan', [\App\Http\Controllers\Petugas\RiwayatPenghargaanController::class, 'index'])->name('petugas.riwayat-penghargaan.index');
        Route::get('/riwayat-penghargaan/create', [\App\Http\Controllers\Petugas\RiwayatPenghargaanController::class, 'create'])->name('petugas.riwayat-penghargaan.create');
        Route::post('/riwayat-penghargaan', [\App\Http\Controllers\Petugas\RiwayatPenghargaanController::class, 'store'])->name('petugas.riwayat-penghargaan.store');
        Route::delete('/riwayat-penghargaan/{id}', [\App\Http\Controllers\Petugas\RiwayatPenghargaanController::class, 'destroy'])->name('petugas.riwayat-penghargaan.destroy');
        Route::resource('/penghargaan', \App\Http\Controllers\Petugas\PenghargaanController::class, ['as' => 'petugas']);
        Route::get('/laporan', [\App\Http\Controllers\Petugas\LaporanController::class, 'index'])->name('petugas.laporan.index');
        Route::get('/laporan/export', [\App\Http\Controllers\Petugas\LaporanController::class, 'export'])->name('petugas.laporan.export');
        Route::get('/profil', [\App\Http\Controllers\Petugas\ProfilController::class, 'index'])->name('petugas.profil.index');
        Route::put('/profil', [\App\Http\Controllers\Petugas\ProfilController::class, 'update'])->name('petugas.profil.update');
    });


    Route::prefix('warga')->middleware('auth:warga')->group(function () {
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('warga.dashboard');
        Route::get('/profil', [WargaProfilController::class, 'index'])->name('warga.profil.index');
        Route::put('/profil', [\App\Http\Controllers\Warga\ProfilController::class, 'update'])->name('warga.profil.update');

        Route::get('/pelanggaran/riwayat', [\App\Http\Controllers\Warga\PelanggaranController::class, 'riwayat'])->name('warga.pelanggaran.riwayat');
        Route::get('/denda/riwayat', [\App\Http\Controllers\Warga\DendaController::class, 'riwayat'])->name('warga.denda.riwayat');
        Route::post('/denda/{id}/upload', [\App\Http\Controllers\Warga\DendaController::class, 'uploadBukti'])->name('warga.denda.upload');
        Route::get('/penghargaan/riwayat', [\App\Http\Controllers\Warga\PenghargaanController::class, 'riwayat'])->name('warga.penghargaan.riwayat');
        Route::get('/statistik', [\App\Http\Controllers\Warga\StatistikController::class, 'index'])->name('warga.statistik.index');
        Route::get('/statistik/data', [\App\Http\Controllers\Warga\StatistikController::class, 'data'])->name('warga.statistik.data');
        Route::get('/pesan', [\App\Http\Controllers\Warga\PesanController::class, 'index'])->name('warga.pesan.index');
        Route::post('/pesan', [\App\Http\Controllers\Warga\PesanController::class, 'store'])->name('warga.pesan.store');
        Route::get('/notifikasi', [\App\Http\Controllers\Warga\NotifikasiController::class, 'index'])->name('warga.notifikasi.index');
        Route::get('/notifikasi/{id}/read', [\App\Http\Controllers\Warga\NotifikasiController::class, 'markAsRead'])->name('warga.notifikasi.read');
        Route::delete('/notifikasi/{id}', [\App\Http\Controllers\Warga\NotifikasiController::class, 'destroy'])->name('warga.notifikasi.destroy');

        Route::resource('/warga', \App\Http\Controllers\Warga\WargaController::class);
        Route::resource('/pelanggaran', \App\Http\Controllers\Warga\PelanggaranController::class);
        Route::resource('/penghargaan', \App\Http\Controllers\Warga\PenghargaanController::class);
        Route::resource('/denda', \App\Http\Controllers\Warga\DendaController::class);
    });
});
