<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = Pelanggaran::all();
        return view('admin.pelanggaran.index', compact('pelanggaran'));
    }

    public function create()
    {
        return view('admin.pelanggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'poin' => 'required|integer',
            'denda' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Pelanggaran::create($validated);

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return view('admin.pelanggaran.edit', compact('pelanggaran'));
    }

    public function update(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'poin' => 'required|integer',
            'denda' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $pelanggaran->update($validated);

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    public function show($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return view('admin.pelanggaran.show', compact('pelanggaran'));
    }
}
