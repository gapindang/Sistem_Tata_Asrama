<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPenghargaan;

class PenghargaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        $riwayat = collect();
        if ($warga) {
            $riwayat = RiwayatPenghargaan::with('penghargaan')->where('id_warga', $warga->id_warga)->orderBy('tanggal', 'desc')->get();
        }

        return view('warga.penghargaan.riwayat', compact('riwayat'));
    }

    public function riwayat()
    {
        return $this->index();
    }
}
