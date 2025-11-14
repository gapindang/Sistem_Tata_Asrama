<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;


class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::all();
        return view('petugas.pelanggaran.index', compact('pelanggarans'));
    }

    public function create()
    {
        return view('petugas.pelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'poin' => 'required|integer',
            'denda' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $pelanggaran = Pelanggaran::create($validated);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'pelanggaran' => $pelanggaran]);
        }

        return redirect()->route('petugas.pelanggaran.index')->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return view('petugas.pelanggaran.edit', compact('pelanggaran'));
    }

    public function update(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'poin' => 'required|integer',
            'denda' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $pelanggaran->update($validated);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'pelanggaran' => $pelanggaran]);
        }

        return redirect()->route('petugas.pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function show($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($pelanggaran);
        }

        return view('petugas.pelanggaran.show', compact('pelanggaran'));
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data pelanggaran berhasil dihapus.']);
        }

        return redirect()->route('petugas.pelanggaran.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
