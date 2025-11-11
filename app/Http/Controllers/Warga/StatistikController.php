<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        return view('warga.statistik.index');
    }

    public function data(Request $request)
    {
        $user = Auth::user();
        $warga = $user->warga ?? null;

        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        $pelanggaranData = [];
        $penghargaanData = [];

        foreach ($months as $m) {
            [$y, $mo] = explode('-', $m);
            $start = Carbon::createFromDate($y, $mo, 1)->startOfMonth();
            $end = (clone $start)->endOfMonth();

            if ($warga) {
                $pelanggaranPoints = RiwayatPelanggaran::where('id_warga', $warga->id_warga)
                    ->whereBetween('tanggal', [$start, $end])
                    ->with('pelanggaran')
                    ->get()
                    ->sum(function ($r) {
                        return $r->pelanggaran->poin ?? 0;
                    });

                $penghargaanPoints = RiwayatPenghargaan::where('id_warga', $warga->id_warga)
                    ->whereBetween('tanggal', [$start, $end])
                    ->with('penghargaan')
                    ->get()
                    ->sum(function ($r) {
                        return $r->penghargaan->poin_reward ?? 0;
                    });
            } else {
                $pelanggaranPoints = 0;
                $penghargaanPoints = 0;
            }

            $pelanggaranData[] = $pelanggaranPoints;
            $penghargaanData[] = $penghargaanPoints;
        }

        return response()->json([
            'labels' => $months,
            'pelanggaran' => $pelanggaranData,
            'penghargaan' => $penghargaanData,
        ]);
    }
}
