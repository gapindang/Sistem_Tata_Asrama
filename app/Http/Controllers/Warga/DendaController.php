<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga ?? null;

        if ($warga) {
            $riwayat = Denda::whereHas('riwayatPelanggaran', function ($q) use ($warga) {
                $q->where('id_warga', $warga->id_warga ?? $warga->id);
            })->with(['riwayatPelanggaran.pelanggaran'])->get();
        } else {
            $riwayat = collect();
        }

        return view('warga.denda.riwayat', compact('riwayat'));
    }

    public function riwayat()
    {
        return $this->index();
    }

    public function show($id)
    {
        $denda = Denda::with(['riwayatPelanggaran.pelanggaran'])->findOrFail($id);
        return view('warga.denda.show', compact('denda'));
    }

    public function create()
    {
        abort(403);
    }
    public function store(Request $request)
    {
        abort(403);
    }
    public function edit($id)
    {
        abort(403);
    }
    public function update(Request $request, $id)
    {
        abort(403);
    }
    public function destroy($id)
    {
        abort(403);
    }
}
