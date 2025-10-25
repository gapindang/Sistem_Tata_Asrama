<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index()
    {
        $data = [
            'totalPelanggaran' => 12,
            'totalPenghargaan' => 5,
            'totalDenda' => 250000,
        ];

        return view('admin.dashboard', compact('data'));
    }
}