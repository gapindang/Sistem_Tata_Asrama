<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::info('Upload Bukti Started', [
            'denda_id' => $id,
            'user_id' => Auth::id(),
            'has_file' => $request->hasFile('bukti_bayar')
        ]);

        try {
            // Validasi
            $validated = $request->validate([
                'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            Log::info('Validation passed');

            // Ambil data denda
            $denda = Denda::with('riwayatPelanggaran.warga')->findOrFail($id);

            Log::info('Denda found', [
                'denda_id' => $denda->id_denda,
                'status_bayar' => $denda->status_bayar,
                'id_warga' => $denda->riwayatPelanggaran->id_warga ?? 'null'
            ]);

            // Cek akses
            $user = Auth::user();
            $warga = $user->wargaAsrama;

            if (!$warga) {
                Log::warning('Warga not found for user', ['user_id' => $user->id_user]);
                return redirect()->back()->with('error', 'Data warga tidak ditemukan.');
            }

            Log::info('Warga found', ['warga_id' => $warga->id_warga]);

            if ($denda->riwayatPelanggaran->id_warga !== $warga->id_warga) {
                Log::warning('Access denied', [
                    'denda_warga_id' => $denda->riwayatPelanggaran->id_warga,
                    'current_warga_id' => $warga->id_warga
                ]);
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupload bukti pembayaran ini.');
            }

            // Upload file
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');

                Log::info('File details', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'valid' => $file->isValid()
                ]);

                if (!$file->isValid()) {
                    Log::error('File is not valid');
                    return redirect()->back()->with('error', 'File upload gagal. Silakan coba lagi.');
                }

                // Simpan file
                $filename = 'bukti_' . time() . '_' . $warga->id_warga . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

                Log::info('File stored', ['path' => $path]);

                if (!$path) {
                    Log::error('Failed to store file');
                    return redirect()->back()->with('error', 'Gagal menyimpan file. Silakan coba lagi.');
                }

                // Update database
                $denda->bukti_bayar = $path;
                $denda->tanggal_bayar = now()->format('Y-m-d');

                Log::info('Before save', [
                    'bukti_bayar' => $denda->bukti_bayar,
                    'tanggal_bayar' => $denda->tanggal_bayar
                ]);

                $saved = $denda->save();

                Log::info('After save', [
                    'saved' => $saved,
                    'bukti_bayar_db' => $denda->fresh()->bukti_bayar
                ]);

                if (!$saved) {
                    Log::error('Failed to save to database');
                    return redirect()->back()->with('error', 'Gagal menyimpan data ke database. Silakan coba lagi.');
                }

                Log::info('Bukti bayar uploaded successfully', [
                    'denda_id' => $id,
                    'path' => $path,
                    'warga' => $warga->nama
                ]);

                return redirect()->route('warga.denda.riwayat')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi petugas.');
            }

            Log::warning('No file in request');
            return redirect()->back()->with('error', 'File tidak ditemukan. Silakan pilih file terlebih dahulu.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', [
                'errors' => $e->errors()
            ]);
            return redirect()->back()->withErrors($e->validator)->withInput()->with('error', 'File tidak valid. Pastikan format JPG, PNG, atau PDF dengan ukuran maksimal 2MB.');
        } catch (\Exception $e) {
            Log::error('Upload bukti bayar error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $denda = Denda::with(['riwayatPelanggaran.pelanggaran'])->findOrFail($id);
        return view('warga.denda.show', compact('denda'));
    }
}
