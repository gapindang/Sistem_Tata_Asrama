<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPenghargaan;
use App\Models\WargaAsrama;
use App\Models\Penghargaan;
use App\Mail\PenghargaanNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RiwayatPenghargaanController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatPenghargaan::with(['warga', 'penghargaan'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        $warga = WargaAsrama::all();
        $penghargaan = Penghargaan::all();

        return view('admin.riwayat-penghargaan.index', compact('riwayat', 'warga', 'penghargaan'));
    }

    public function create()
    {
        $warga = WargaAsrama::all();
        $penghargaan = Penghargaan::all();

        return view('admin.riwayat-penghargaan.create', compact('warga', 'penghargaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_warga' => 'required|string|exists:warga_asrama,id_warga',
            'id_penghargaan' => 'required|string|exists:penghargaan,id_penghargaan',
            'tanggal' => 'required|date',
        ]);

        // Tambahkan id_petugas dari user yang sedang login (admin)
        $validated['id_petugas'] = Auth::user()->id_user;

        $riwayat = RiwayatPenghargaan::create($validated);

        $riwayat->load(['warga', 'penghargaan']);

        // Kirim notifikasi email
        if ($riwayat->warga && $riwayat->warga->user && $riwayat->warga->user->email) {
            try {
                Mail::to($riwayat->warga->user->email)->send(new PenghargaanNotification($riwayat));
            } catch (\Exception $e) {
                Log::error('Failed to send penghargaan notification: ' . $e->getMessage());
            }
        }

        // Buat pemberitahuan di sistem
        if ($riwayat->warga && $riwayat->warga->user) {
            \App\Models\Pemberitahuan::create([
                'id_user' => $riwayat->warga->user->id_user,
                'judul' => 'Penghargaan Baru',
                'pesan' => 'Selamat! Anda mendapatkan penghargaan "' . $riwayat->penghargaan->nama_penghargaan . '" dengan poin reward ' . $riwayat->penghargaan->poin_reward . ' poin.',
                'status_baca' => 0,
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'riwayat' => $riwayat]);
        }

        return redirect()->route('admin.riwayat-penghargaan.index')
            ->with('success', 'Penghargaan berhasil diberikan dan notifikasi telah dikirim.');
    }

    public function destroy($id)
    {
        $riwayat = RiwayatPenghargaan::findOrFail($id);
        $riwayat->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.riwayat-penghargaan.index')
            ->with('success', 'Riwayat penghargaan berhasil dihapus.');
    }

    public function edit($id)
    {
        $riwayat = RiwayatPenghargaan::findOrFail($id);
        $warga = WargaAsrama::all();
        $penghargaan = Penghargaan::all();

        return view('admin.riwayat-penghargaan.edit', compact('riwayat', 'warga', 'penghargaan'));
    }

    public function update(Request $request, $id)
    {
        $riwayat = RiwayatPenghargaan::findOrFail($id);

        $validated = $request->validate([
            'id_warga' => 'required|string|exists:warga_asrama,id_warga',
            'id_penghargaan' => 'required|string|exists:penghargaan,id_penghargaan',
            'tanggal' => 'required|date',
        ]);

        $riwayat->update($validated);

        return redirect()->route('admin.riwayat-penghargaan.index')
            ->with('success', 'Riwayat penghargaan berhasil diperbarui.');
    }
}
