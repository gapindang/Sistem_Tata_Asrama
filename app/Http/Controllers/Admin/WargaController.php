<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = WargaAsrama::all();
        return view('admin.warga.index', compact('wargas'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:warga_asrama,nim',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        WargaAsrama::create($validated);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $warga = WargaAsrama::findOrFail($id);
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = WargaAsrama::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:warga_asrama,nim,' . $id . ',id_warga',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $warga->update($validated);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warga = WargaAsrama::findOrFail($id);
        $warga->delete();

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function show($id)
    {
        $warga = WargaAsrama::with(['riwayatPelanggaran', 'riwayatPenghargaan'])->findOrFail($id);
        return view('admin.warga.show', compact('warga'));
    }

    public function filter(Request $request)
    {
        $query = WargaAsrama::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('nim')) {
            $query->where('nim', $request->nim);
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $wargas = $query->get();

        return view('admin.warga.index', compact('wargas'));
    }
}
