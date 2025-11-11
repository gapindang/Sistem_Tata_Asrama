<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Penghargaan;
use App\Models\Denda;


class SearchController extends Controller
{
    public function index()
    {
        return view('admin.search.index');
    }

    public function search(Request $request)
    {
        $q = $request->q ?? '';

        $warga = WargaAsrama::where('nama', 'like', "%$q%")->orWhere('nim', 'like', "%$q%")->get();
        $pelanggaran = Pelanggaran::where('nama_pelanggaran', 'like', "%$q%")->get();
        $penghargaan = Penghargaan::where('nama_penghargaan', 'like', "%$q%")->get();
        $denda = Denda::where('nominal', 'like', "%$q%")->get();

        return view('admin.search.results', compact('warga', 'pelanggaran', 'penghargaan', 'denda'));
    }
}
