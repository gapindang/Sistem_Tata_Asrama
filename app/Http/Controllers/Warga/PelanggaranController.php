<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPelanggaran;

class PelanggaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        $riwayat = collect();
        if ($warga) {
            $riwayat = RiwayatPelanggaran::with(['pelanggaran', 'denda'])->where('id_warga', $warga->id_warga)->orderBy('tanggal', 'desc')->get();
        }

        return view('warga.pelanggaran.riwayat', compact('riwayat'));
    }

    public function riwayat()
    {
        return $this->index();
    }

    public function show($id)
    {
        $riwayat = RiwayatPelanggaran::with(['pelanggaran', 'denda', 'petugas'])->findOrFail($id);
        return view('warga.pelanggaran.show', compact('riwayat'));
    }
}
