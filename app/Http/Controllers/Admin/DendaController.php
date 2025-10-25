<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;


class DendaController extends Controller
{
    public function index()
    {
        $denda = Denda::latest()->get();
        return view('admin.denda.index', compact('denda'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'jumlah_denda' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $denda = Denda::create($validated);
        return response()->json(['success' => true, 'data' => $denda]);
    }

    public function update(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);

        $validated = $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'jumlah_denda' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $denda->update($validated);
        return response()->json(['success' => true, 'data' => $denda]);
    }

    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();

        return response()->json(['success' => true]);
    }
}
