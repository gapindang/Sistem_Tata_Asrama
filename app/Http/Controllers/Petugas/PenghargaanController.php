<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penghargaan;

class PenghargaanController extends Controller
{
    public function index()
    {
        $penghargaans = Penghargaan::all();
        return view('petugas.penghargaan.index', compact('penghargaans'));
    }

    public function create()
    {
        return view('petugas.penghargaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'poin_reward' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $penghargaan = Penghargaan::create($validated);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'penghargaan' => $penghargaan]);
        }

        return redirect()->route('petugas.penghargaan.index')->with('success', 'Data penghargaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        return view('petugas.penghargaan.edit', compact('penghargaan'));
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

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'penghargaan' => $penghargaan]);
        }

        return redirect()->route('petugas.penghargaan.index')->with('success', 'Data penghargaan berhasil diperbarui.');
    }

    public function show($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($penghargaan);
        }

        return view('petugas.penghargaan.show', compact('penghargaan'));
    }

    public function destroy($id)
    {
        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data penghargaan berhasil dihapus.']);
        }

        return redirect()->route('petugas.penghargaan.index')->with('success', 'Data penghargaan berhasil dihapus.');
    }
}
