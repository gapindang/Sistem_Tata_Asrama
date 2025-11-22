<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\RiwayatPelanggaran;
use App\Models\Pelanggaran;
use App\Models\WargaAsrama;
use App\Models\Pengguna;
use App\Mail\PelanggaranNotification;
use Illuminate\Support\Str;

class RiwayatPelanggaranController extends Controller
{
    public function create()
    {
        $pelanggarans = Pelanggaran::all();
        $wargas = WargaAsrama::all();
        return view('petugas.riwayat_pelanggaran.create', compact('pelanggarans', 'wargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|string|exists:warga_asrama,id_warga',
            'id_pelanggaran' => 'required|string|exists:pelanggaran,id_pelanggaran',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = [
            'id_warga' => $request->id_warga,
            'id_pelanggaran' => $request->id_pelanggaran,
            'tanggal' => $request->tanggal,
            'status_sanksi' => $request->input('status_sanksi', 'proses'),
            'id_petugas' => Auth::id(),
        ];

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pelanggaran', $filename, 'public');
            $data['bukti'] = $path;
        }

        $riwayat = RiwayatPelanggaran::create($data);

        $riwayat->load(['warga', 'pelanggaran']);

        if ($riwayat->warga && $riwayat->warga->user && $riwayat->warga->user->email) {
            try {
                Mail::to($riwayat->warga->user->email)->send(new PelanggaranNotification($riwayat));
            } catch (\Exception $e) {
                Log::error('Failed to send pelanggaran notification: ' . $e->getMessage());
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pelanggaran berhasil dicatat', 'riwayat' => $riwayat]);
        }

        return redirect()->route('petugas.warga.show', [$request->id_warga])->with('success', 'Pelanggaran berhasil dicatat.');
    }

    public function markAsDone($id)
    {
        $riwayat = RiwayatPelanggaran::findOrFail($id);
        $riwayat->status_sanksi = 'selesai';
        $riwayat->save();

        return response()->json(['success' => true, 'riwayat' => $riwayat]);
    }
}
