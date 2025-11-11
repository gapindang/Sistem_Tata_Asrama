<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('petugas.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $model = Pengguna::findOrFail($user->id_user);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $model->update($validated);

        return redirect()->route('petugas.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
