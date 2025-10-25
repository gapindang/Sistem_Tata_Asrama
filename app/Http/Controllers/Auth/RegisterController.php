<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga',
            'is_verified' => false,
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
        ]);

        session([
            'otp' => $otp,
            'otp_email' => $request->email,
            'otp_expires_at' => $expiresAt,
            'otp_last_sent' => Carbon::now(),
        ]);

        Mail::raw("Kode OTP kamu adalah: $otp (berlaku 5 menit).", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Kode OTP Verifikasi Akun');
        });

        return redirect()->route('auth.verify-otp')->with('email', $request->email);
    }

    public function verifyForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        if (
            $request->email === session('otp_email') &&
            $request->otp == session('otp') &&
            Carbon::now()->lt(session('otp_expires_at'))
        ) {
            $pengguna = Pengguna::where('email', $request->email)->first();
            if ($pengguna) {
                $pengguna->is_verified = true;
                $pengguna->save();
            }

            session()->forget(['otp', 'otp_email', 'otp_expires_at', 'otp_last_sent']);
            return redirect()->route('login')->with('success', 'Verifikasi berhasil! Silakan login.');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }

    public function resendOtp(Request $request)
    {
        $lastSent = session('otp_last_sent');

        if ($lastSent && Carbon::parse($lastSent)->diffInSeconds(Carbon::now()) < 15) {
            $remaining = 15 - Carbon::parse($lastSent)->diffInSeconds(Carbon::now());
            return back()->withErrors(['otp' => "Tunggu $remaining detik sebelum mengirim ulang OTP."]);
        }

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi OTP tidak ditemukan. Silakan daftar ulang.']);
        }

        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'otp_last_sent' => Carbon::now(),
        ]);

        Mail::raw("Kode OTP baru kamu adalah: $otp (berlaku 5 menit).", function ($message) use ($email) {
            $message->to($email)
                ->subject('Kode OTP Baru Verifikasi Akun');
        });

        return back()->with('success', 'Kode OTP baru telah dikirim ke email.');
    }
}
