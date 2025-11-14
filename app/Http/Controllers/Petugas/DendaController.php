<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\RiwayatPelanggaran;
use App\Mail\DendaNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        $denda = Denda::with(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $allRiwayat = RiwayatPelanggaran::with(['pelanggaran', 'warga', 'denda'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('petugas.denda.index', [
            'denda' => $denda,
            'allRiwayat' => $allRiwayat,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_riwayat_pelanggaran' => 'required|string|exists:riwayat_pelanggaran,id_riwayat_pelanggaran',
            'nominal' => 'required|numeric|min:0',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = [
            'id_riwayat_pelanggaran' => $request->id_riwayat_pelanggaran,
            'nominal' => $request->nominal,
            'status_bayar' => $request->input('status_bayar', 'belum'),
        ];

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_denda', $filename, 'public');
            $data['bukti_bayar'] = $path;
        }

        $denda = Denda::create($data);

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

        return response()->json(['success' => true, 'denda' => $denda]);
    }

    public function update(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);

        $request->validate([
            'nominal' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:belum,dibayar',
            'tanggal_bayar' => 'nullable|date',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = [
            'nominal' => $request->nominal,
            'status_bayar' => $request->status_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
        ];

        if ($request->hasFile('bukti_bayar')) {
            // Delete old file if exists
            if ($denda->bukti_bayar && Storage::disk('public')->exists($denda->bukti_bayar)) {
                Storage::disk('public')->delete($denda->bukti_bayar);
            }

            $file = $request->file('bukti_bayar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_denda', $filename, 'public');
            $data['bukti_bayar'] = $path;
        }

        $denda->update($data);
        $denda->load(['riwayatPelanggaran.pelanggaran', 'riwayatPelanggaran.warga']);

        return response()->json(['success' => true, 'denda' => $denda]);
    }

    public function approve($id)
    {
        $denda = Denda::with('riwayatPelanggaran')->findOrFail($id);

        if (!$denda->bukti_bayar) {
            return response()->json(['success' => false, 'message' => 'Tidak ada bukti pembayaran'], 400);
        }

        // Check if current petugas is the one who created the violation
        $currentPetugas = Auth::user()->id_user;
        if ($denda->riwayatPelanggaran->id_petugas !== $currentPetugas) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk approve denda ini. Hanya petugas yang mencatat pelanggaran yang dapat approve.'], 403);
        }

        $denda->update([
            'status_bayar' => 'dibayar',
        ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran denda telah disetujui']);
    }

    public function reject($id)
    {
        $denda = Denda::with('riwayatPelanggaran')->findOrFail($id);

        // Check if current petugas is the one who created the violation
        $currentPetugas = Auth::user()->id_user;
        if ($denda->riwayatPelanggaran->id_petugas !== $currentPetugas) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menolak denda ini. Hanya petugas yang mencatat pelanggaran yang dapat menolak.'], 403);
        }

        // Delete uploaded proof
        if ($denda->bukti_bayar && Storage::disk('public')->exists($denda->bukti_bayar)) {
            Storage::disk('public')->delete($denda->bukti_bayar);
        }

        $denda->update([
            'bukti_bayar' => null,
            'tanggal_bayar' => null,
        ]);

        return response()->json(['success' => true, 'message' => 'Bukti pembayaran ditolak. Warga harus mengupload ulang.']);
    }
    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);

        // Delete file if exists
        if ($denda->bukti_bayar && Storage::disk('public')->exists($denda->bukti_bayar)) {
            Storage::disk('public')->delete($denda->bukti_bayar);
        }

        $denda->delete();

        return response()->json(['success' => true, 'message' => 'Denda berhasil dihapus']);
    }
}
