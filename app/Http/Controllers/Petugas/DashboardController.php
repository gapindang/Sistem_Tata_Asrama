<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $petugasId = Auth::user()->id_user;

        // Pelanggaran yang dicatat oleh petugas ini
        $pelanggaranDicatat = RiwayatPelanggaran::where('id_petugas', $petugasId)->count();
        $pelanggaranHariIni = RiwayatPelanggaran::where('id_petugas', $petugasId)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Penghargaan yang diberikan oleh petugas ini
        $penghargaanDiberikan = RiwayatPenghargaan::where('id_petugas', $petugasId)->count();
        $penghargaanHariIni = RiwayatPenghargaan::where('id_petugas', $petugasId)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Total denda dari pelanggaran yang dicatat petugas ini
        $totalDenda = Denda::whereHas('riwayatPelanggaran', function ($q) use ($petugasId) {
            $q->where('id_petugas', $petugasId);
        })->sum('nominal');

        // Pelanggaran terbaru yang dicatat petugas ini (untuk list)
        $recentPelanggaran = RiwayatPelanggaran::with(['warga.user', 'pelanggaran'])
            ->where('id_petugas', $petugasId)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Penghargaan terbaru yang diberikan petugas ini (untuk list)
        $recentPenghargaan = RiwayatPenghargaan::with(['warga.user', 'penghargaan'])
            ->where('id_petugas', $petugasId)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        $data = [
            'pelanggaranDicatat' => $pelanggaranDicatat,
            'pelanggaranHariIni' => $pelanggaranHariIni,
            'penghargaanDiberikan' => $penghargaanDiberikan,
            'penghargaanHariIni' => $penghargaanHariIni,
            'totalDenda' => $totalDenda,
            'recentPelanggaran' => $recentPelanggaran,
            'recentPenghargaan' => $recentPenghargaan,
        ];

        return view('petugas.dashboard', compact('data'));
    }
}
