<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $model = Pengguna::findOrFail($user->id_user);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Email tidak dapat diubah - hapus dari validated data
        unset($validated['email']);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $model->update($validated);

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
