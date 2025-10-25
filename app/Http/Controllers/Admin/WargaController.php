<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query()->where('role', 'warga');

        if ($request->filled('blok')) {
            $query->where('blok', $request->blok);
        }
        if ($request->filled('kamar')) {
            $query->where('kamar', $request->kamar);
        }

        $warga = $query->get();

        return view('admin.warga.index', compact('warga'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'blok' => 'nullable|string',
            'kamar' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'warga';

        Pengguna::create($validated);

        return redirect()->route('admin.warga.index')->with('success', 'Warga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $warga = Pengguna::findOrFail($id);
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = Pengguna::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email,' . $warga->id_user . ',id_user',
            'blok' => 'nullable|string',
            'kamar' => 'nullable|string',
        ]);

        $warga->update($validated);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warga = Pengguna::findOrFail($id);
        $warga->delete();

        return redirect()->route('admin.warga.index')->with('success', 'Warga berhasil dihapus.');
    }

    public function show($id)
    {
        $warga = Pengguna::with(['pelanggaran', 'penghargaan'])->findOrFail($id);
        return view('admin.warga.show', compact('warga'));
    }
}
