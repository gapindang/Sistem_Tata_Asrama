<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Penghargaan;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalPelanggaran' => Pelanggaran::count(),
            'totalPenghargaan' => Penghargaan::count(),
            'totalDenda' => Denda::sum('nominal'),
        ];

        return view('petugas.dashboard', compact('data'));
    }
}
