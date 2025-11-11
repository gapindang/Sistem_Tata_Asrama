<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = WargaAsrama::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('nim')) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        if ($request->filled('blok')) {
            $query->where('kamar', 'like', $request->blok . '%');
        }

        if ($request->filled('kamar')) {
            $query->where('kamar', $request->kamar);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $warga = $query->orderBy('nama')->paginate(20);

        // Get unique blok and kamar for filter dropdowns
        $bloks = WargaAsrama::distinct()
            ->pluck('kamar')
            ->map(function ($kamar) {
                return explode('-', $kamar)[0] ?? $kamar;
            })
            ->unique()
            ->sort()
            ->values()
            ->all();

        $kamarByBlok = [];
        if ($request->filled('blok')) {
            $kamarByBlok = WargaAsrama::where('kamar', 'like', $request->blok . '%')
                ->distinct()
                ->pluck('kamar')
                ->sort()
                ->values()
                ->all();
        }

        return view('petugas.warga.index', [
            'warga' => $warga,
            'bloks' => $bloks,
            'kamarByBlok' => $kamarByBlok,
        ]);
    }

    public function getKamarByBlok(Request $request)
    {
        $blok = $request->blok;
        $kamar = WargaAsrama::where('kamar', 'like', $blok . '%')
            ->distinct()
            ->pluck('kamar')
            ->sort()
            ->values()
            ->all();

        return response()->json($kamar);
    }

    public function filter(Request $request)
    {
        $query = WargaAsrama::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('nim')) {
            $query->where('nim', 'like', '%' . $request->nim . '%');
        }

        if ($request->filled('blok')) {
            $query->where('kamar', 'like', $request->blok . '%');
        }

        if ($request->filled('kamar')) {
            $query->where('kamar', $request->kamar);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $warga = $query->orderBy('nama')->get();

        // Return as JSON for AJAX
        if ($request->wantsJson()) {
            return response()->json([
                'html' => view('petugas.warga.table', ['warga' => $warga])->render()
            ]);
        }

        return view('petugas.warga.index', ['warga' => $warga]);
    }

    public function create()
    {
        return view('petugas.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|unique:warga_asrama,nim',
            'kamar' => 'required|string',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        WargaAsrama::create($validated);

        return redirect()->route('petugas.warga.index')->with('success', 'Warga berhasil ditambahkan.');
    }

    public function show($id)
    {
        $warga = WargaAsrama::with(['riwayatPelanggaran', 'riwayatPenghargaan'])->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($warga);
        }

        return view('petugas.warga.show', compact('warga'));
    }

    public function edit($id)
    {
        $warga = WargaAsrama::findOrFail($id);
        return view('petugas.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = WargaAsrama::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|unique:warga_asrama,nim,' . $warga->id_warga . ',id_warga',
            'kamar' => 'required|string',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $warga->update($validated);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'warga' => $warga]);
        }

        return redirect()->route('petugas.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warga = WargaAsrama::findOrFail($id);
        $warga->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('petugas.warga.index')->with('success', 'Warga berhasil dihapus.');
    }
}
