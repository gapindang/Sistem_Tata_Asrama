<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghargaan;
use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    public function index()
    {
        $penghargaan = Penghargaan::all();
        return view('admin.penghargaan.index', compact('penghargaan'));
    }

    public function create()
    {
        return view('admin.penghargaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'poin_reward' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Penghargaan::create($validated);

        return redirect()->route('admin.penghargaan.index')->with('success', 'Data penghargaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        return view('admin.penghargaan.edit', compact('penghargaan'));
    }

    public function update(Request $request, $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'poin_reward' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $penghargaan->update($validated);

        return redirect()->route('admin.penghargaan.index')->with('success', 'Data penghargaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->delete();

        return redirect()->route('admin.penghargaan.index')->with('success', 'Data penghargaan berhasil dihapus.');
    }

    public function show($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        return view('admin.penghargaan.show', compact('penghargaan'));
    }
}
