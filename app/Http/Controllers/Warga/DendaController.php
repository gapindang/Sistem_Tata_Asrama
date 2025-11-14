<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        if ($warga) {
            $riwayat = Denda::whereHas('riwayatPelanggaran', function ($q) use ($warga) {
                $q->where('id_warga', $warga->id_warga);
            })->with(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.petugas'])->get();
        } else {
            $riwayat = collect();
        }

        return view('warga.denda.riwayat', compact('riwayat'));
    }

    public function riwayat()
    {
        return $this->index();
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $denda = Denda::findOrFail($id);

        // Verify ownership
        $user = Auth::user();
        $warga = $user->wargaAsrama;

        if (!$warga || $denda->riwayatPelanggaran->id_warga !== $warga->id_warga) {
            abort(403, 'Unauthorized');
        }

        // Upload file
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = 'bukti_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Update denda
            $denda->update([
                'bukti_bayar' => $path,
                'tanggal_bayar' => now()->format('Y-m-d'),
            ]);
        }

        return redirect()->route('warga.denda.riwayat')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi petugas.');
    }

    public function show($id)
    {
        $denda = Denda::with(['riwayatPelanggaran.pelanggaran'])->findOrFail($id);
        return view('warga.denda.show', compact('denda'));
    }
}
