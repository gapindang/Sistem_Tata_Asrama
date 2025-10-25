<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::prefix('admin')->middleware('auth:admin')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    });

    Route::prefix('petugas')->middleware('auth:petugas')->group(function () {
        Route::get('/dashboard', fn() => view('petugas.dashboard'))->name('petugas.dashboard');
    });

    Route::prefix('warga')->middleware('auth:warga')->group(function () {
        Route::get('/dashboard', fn() => view('warga.dashboard'))->name('warga.dashboard');
    });
});
