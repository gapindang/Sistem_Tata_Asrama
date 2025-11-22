<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use App\Models\Denda;
use App\Models\Pemberitahuan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        $totalPoinPelanggaran = 0;
        $totalPoinPenghargaan = 0;
        $totalDenda = 0;
        $recentPenghargaan = collect();
        $notifikasiCount = 0;

        if ($warga) {
            $pelanggaranRiwayat = RiwayatPelanggaran::with('pelanggaran')->where('id_warga', $warga->id_warga)->get();
            $totalPoinPelanggaran = $pelanggaranRiwayat->sum(function ($r) {
                return $r->pelanggaran->poin ?? 0;
            });

            $penghargaanRiwayat = RiwayatPenghargaan::with('penghargaan')->where('id_warga', $warga->id_warga)->orderBy('tanggal', 'desc')->take(5)->get();
            $totalPoinPenghargaan = $penghargaanRiwayat->sum(function ($r) {
                return $r->penghargaan->poin_reward ?? 0;
            });
            $recentPenghargaan = $penghargaanRiwayat;

            $totalDenda = Denda::whereHas('riwayatPelanggaran', function ($q) use ($warga) {
                $q->where('id_warga', $warga->id_warga);
            })->sum('nominal');

            $notifikasiCount = Pemberitahuan::where('id_user', $user->id_user)->where('status_baca', 0)->count();
        }

        // Count violations and achievements
        $countPelanggaran = 0;
        $countPenghargaan = 0;

        if ($warga) {
            $countPelanggaran = RiwayatPelanggaran::where('id_warga', $warga->id_warga)->count();
            $countPenghargaan = RiwayatPenghargaan::where('id_warga', $warga->id_warga)->count();
        }

        $data = [
            'pelanggaran' => $countPelanggaran,
            'penghargaan' => $countPenghargaan,
            'poin_pelanggaran' => $totalPoinPelanggaran,
            'poin_penghargaan' => $totalPoinPenghargaan,
            'denda' => $totalDenda,
            'recent_penghargaan' => $recentPenghargaan,
            'notifikasiCount' => $notifikasiCount,
        ];

        return view('warga.dashboard', compact('data'));
    }
}
