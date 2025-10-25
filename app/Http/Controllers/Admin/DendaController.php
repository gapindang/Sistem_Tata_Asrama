<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;


class DendaController extends Controller
{
    public function index()
    {
        $denda = Denda::with('riwayatPelanggaran')->get();
        return view('admin.denda.index', compact('denda'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_riwayat_pelanggaran' => 'required|string',
            'nominal' => 'required|integer',
            'status_bayar' => 'required|in:belum,lunas',
            'tanggal_bayar' => 'nullable|date',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $path = $file->store('bukti_denda', 'public');
            $validated['bukti_bayar'] = $path;
        }

        Denda::create($validated);

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);

        $validated = $request->validate([
            'id_riwayat_pelanggaran' => 'required|string',
            'nominal' => 'required|integer',
            'status_bayar' => 'required|in:belum,lunas',
            'tanggal_bayar' => 'nullable|date',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $path = $file->store('bukti_denda', 'public');
            $validated['bukti_bayar'] = $path;
        }

        $denda->update($validated);

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil dihapus.');
    }
}
