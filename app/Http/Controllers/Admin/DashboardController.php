<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Penghargaan;
use App\Models\Denda;
use App\Models\Pemberitahuan;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        // Basic Statistics
        $totalPelanggaran = Pelanggaran::count();
        $totalPenghargaan = Penghargaan::count();
        $totalDenda = Denda::sum('nominal');
        $totalDendaBayar = Denda::where('status_bayar', 'dibayar')->sum('nominal');

        // Pelanggaran per kategori (jenis pelanggaran)
        $pelanggaranPerJenis = Pelanggaran::with('riwayatPelanggaran')
            ->get()
            ->map(function ($p) {
                return [
                    'nama' => $p->nama_pelanggaran,
                    'count' => $p->riwayatPelanggaran->count()
                ];
            })
            ->sortByDesc('count')
            ->take(10)
            ->values();

        // Weekly trend (7 hari terakhir)
        $weeklyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $count = RiwayatPelanggaran::whereDate('tanggal', $date)->count();
            $weeklyTrend[] = [
                'date' => Carbon::parse($date)->format('d M'),
                'count' => $count
            ];
        }

        // Penghargaan distribution
        $penghargaanDistribution = Penghargaan::with('riwayatPenghargaan')
            ->get()
            ->map(function ($p) {
                return [
                    'nama' => $p->nama_penghargaan,
                    'count' => $p->riwayatPenghargaan->count()
                ];
            })
            ->sortByDesc('count')
            ->take(8)
            ->values();

        // Denda status
        $dendaBelumBayar = Denda::where('status_bayar', 'belum')->count();
        $dendaSudahBayar = Denda::where('status_bayar', 'dibayar')->count();

        // Monthly revenue (12 bulan terakhir)
        // Prefer `tanggal_bayar` (payment date) when available; fallback to `created_at`.
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $total = Denda::where('status_bayar', 'dibayar')
                ->where(function ($q) use ($month) {
                    // payments that have a payment date in this month
                    $q->whereYear('tanggal_bayar', $month->year)
                        ->whereMonth('tanggal_bayar', $month->month);
                })
                ->orWhere(function ($q) use ($month) {
                    // or records without tanggal_bayar but created in this month
                    $q->whereNull('tanggal_bayar')
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month);
                })
                ->sum('nominal');

            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'total' => $total
            ];
        }

        $data = [
            'totalPelanggaran' => $totalPelanggaran,
            'totalPenghargaan' => $totalPenghargaan,
            'totalDenda' => $totalDenda,
            'totalDendaBayar' => $totalDendaBayar,
            'pelanggaranPerJenis' => $pelanggaranPerJenis,
            'weeklyTrend' => $weeklyTrend,
            'penghargaanDistribution' => $penghargaanDistribution,
            'dendaBelumBayar' => $dendaBelumBayar,
            'dendaSudahBayar' => $dendaSudahBayar,
            'monthlyRevenue' => $monthlyRevenue,
            'recentNotifications' => Pemberitahuan::with('pengguna')->orderBy('tanggal', 'desc')->take(10)->get(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}
