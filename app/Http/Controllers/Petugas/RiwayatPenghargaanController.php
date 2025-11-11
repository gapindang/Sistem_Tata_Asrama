<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPenghargaan;
use App\Models\WargaAsrama;
use App\Models\Penghargaan;
use App\Mail\PenghargaanNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RiwayatPenghargaanController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatPenghargaan::with(['warga', 'penghargaan'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        $warga = WargaAsrama::all();
        $penghargaan = Penghargaan::all();

        return view('petugas.riwayat-penghargaan.index', compact('riwayat', 'warga', 'penghargaan'));
    }

    public function create()
    {
        $warga = WargaAsrama::all();
        $penghargaan = Penghargaan::all();

        return view('petugas.riwayat-penghargaan.create', compact('warga', 'penghargaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_warga' => 'required|string|exists:warga_asrama,id_warga',
            'id_penghargaan' => 'required|string|exists:penghargaan,id_penghargaan',
            'tanggal' => 'required|date',
        ]);

        $riwayat = RiwayatPenghargaan::create($validated);

        $riwayat->load(['warga', 'penghargaan']);

        // Send email notification
        if ($riwayat->warga && $riwayat->warga->user && $riwayat->warga->user->email) {
            try {
                Mail::to($riwayat->warga->user->email)->send(new PenghargaanNotification($riwayat));
            } catch (\Exception $e) {
                Log::error('Failed to send penghargaan notification: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'riwayat' => $riwayat]);
        }

        return redirect()->route('petugas.riwayat-penghargaan.index')
            ->with('success', 'Penghargaan berhasil diberikan dan notifikasi telah dikirim.');
    }

    public function destroy($id)
    {
        $riwayat = RiwayatPenghargaan::findOrFail($id);
        $riwayat->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('petugas.riwayat-penghargaan.index')
            ->with('success', 'Riwayat penghargaan berhasil dihapus.');
    }
}
