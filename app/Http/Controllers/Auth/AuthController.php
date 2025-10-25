<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function index()
    {
        if (session()->has('role')) {
            return $this->redirectByRole(session('role'));
        }

        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $pengguna = Pengguna::where('email', $request->email)->first();

    //     if ($pengguna && Hash::check($request->password, $pengguna->password)) {
    //         session([
    //             'id_user' => $pengguna->id_user,
    //             'nama' => $pengguna->nama,
    //             'email' => $pengguna->email,
    //             'role' => $pengguna->role
    //         ]);

    //         return $this->redirectByRole($pengguna->role)
    //             ->with('success', 'Selamat datang, ' . ucfirst($pengguna->role) . '!');
    //     }

    //     return back()->with('error', 'Email atau password salah.');
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            Auth::guard('web')->login($pengguna);
            // dd(Auth::guard('web')->user());
            return $this->redirectByRole($pengguna->role)
                ->with('success', 'Selamat datang, ' . ucfirst($pengguna->role) . '!');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // public function logout()
    // {
    //     session()->flush();
    //     return redirect()->route('login')->with('success', 'Anda telah logout.');
    // }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'warga':
                return redirect()->route('warga.dashboard');
            default:
                return redirect('/')->with('error', 'Role tidak dikenali.');
        }
    }
}
