<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function export()
    {
        return redirect()->route('admin.laporan.index')->with('success', 'Export laporan berhasil.');
    }
}
