<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index($id)
    {
        $warga = WargaAsrama::with(['riwayatPelanggaran', 'riwayatPenghargaan'])->findOrFail($id);
        return view('admin.warga.riwayat', compact('warga'));
    }
}
