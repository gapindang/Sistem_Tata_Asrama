<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use App\Models\WargaAsrama;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;
        return view('warga.profil.index', compact('user', 'warga'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|string|max:4',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $pengguna = Pengguna::findOrFail($user->id_user);
        $pengguna->update([
            'nama' => $validated['nama'],
        ]);

        if (!empty($validated['password'])) {
            $pengguna->update([
                'password' => bcrypt($validated['password']),
            ]);
        }

        if ($warga) {
            $warga->update([
                'nim' => $validated['nim'],
                'kamar' => $validated['kamar'],
                'angkatan' => $validated['angkatan'],
            ]);
        }

        return redirect()->route('warga.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
