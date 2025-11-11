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
        $warga = $user->warga ?? null;
        return view('warga.profil.index', compact('user', 'warga'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $warga = $user->warga ?? null;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
            'kamar' => 'nullable|string',
            'kontak' => 'nullable|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengguna = Pengguna::findOrFail($user->id_user);
        $pengguna->update($validated);

        if ($warga) {
            $warga->update([
                'kamar' => $validated['kamar'] ?? $warga->kamar,
            ]);
        }

        return redirect()->route('warga.profil.index')->with('success', 'Profil diperbarui.');
    }
}
