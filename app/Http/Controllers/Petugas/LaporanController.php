<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('petugas.laporan.index');
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        return response()->json(['success' => true, 'filters' => $filters]);
    }
}
