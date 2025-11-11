<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\RiwayatPelanggaran;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\DendaNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class DendaController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $denda = Denda::with(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga'])->get();

        $riwayatWithoutDenda = RiwayatPelanggaran::doesntHave('denda')->with(['pelanggaran', 'warga'])->get();

        // also send all riwayat so the view can show which ones are already denda-ed
        $allRiwayat = RiwayatPelanggaran::with(['pelanggaran', 'warga', 'denda'])->get();

        return view('admin.denda.index', compact('denda', 'riwayatWithoutDenda', 'allRiwayat'));
    }

    public function store(Request $request)
    {
        // Only petugas can create denda
        $this->authorize('create-denda');

        $validated = $request->validate([
            'id_riwayat_pelanggaran' => 'required|string',
            'nominal' => 'required|numeric',
            'status_bayar' => 'nullable|in:belum,dibayar',
            'tanggal_bayar' => 'nullable|date',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $path = $file->store('bukti_denda', 'public');
            $validated['bukti_bayar'] = $path;
        }

        $denda = Denda::create([
            'id_riwayat_pelanggaran' => $validated['id_riwayat_pelanggaran'],
            'nominal' => $validated['nominal'],
            'status_bayar' => $validated['status_bayar'] ?? 'belum',
            'tanggal_bayar' => $validated['tanggal_bayar'] ?? null,
            'bukti_bayar' => $validated['bukti_bayar'] ?? null,
        ]);

        $denda->load(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga']);

        // Send email notification
        if ($denda->riwayatPelanggaran && $denda->riwayatPelanggaran->warga) {
            try {
                $warga = $denda->riwayatPelanggaran->warga;
                if ($warga->user && $warga->user->email) {
                    Mail::to($warga->user->email)->send(new DendaNotification($denda));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send denda notification: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $denda]);
        }

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        // Only petugas can update denda
        $this->authorize('create-denda');

        $denda = Denda::findOrFail($id);

        $validated = $request->validate([
            'id_riwayat_pelanggaran' => 'required|string',
            'nominal' => 'required|numeric',
            'status_bayar' => 'nullable|in:belum,dibayar',
            'tanggal_bayar' => 'nullable|date',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $path = $file->store('bukti_denda', 'public');
            $validated['bukti_bayar'] = $path;
        }

        $denda->update([
            'id_riwayat_pelanggaran' => $validated['id_riwayat_pelanggaran'],
            'nominal' => $validated['nominal'],
            'status_bayar' => $validated['status_bayar'] ?? $denda->status_bayar,
            'tanggal_bayar' => $validated['tanggal_bayar'] ?? $denda->tanggal_bayar,
            'bukti_bayar' => $validated['bukti_bayar'] ?? $denda->bukti_bayar,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            $denda->load(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga']);
            return response()->json(['success' => true, 'data' => $denda]);
        }

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.denda.index')->with('success', 'Denda berhasil dihapus.');
    }

    public function confirmPayment(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);
        $denda->status_bayar = 'dibayar';
        $denda->tanggal_bayar = $request->input('tanggal_bayar', now());
        $denda->save();

        if ($request->wantsJson() || $request->ajax()) {
            $denda->load(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga']);
            return response()->json(['success' => true, 'denda' => $denda]);
        }

        return redirect()->route('admin.denda.index')->with('success', 'Pembayaran denda dikonfirmasi.');
    }
}
