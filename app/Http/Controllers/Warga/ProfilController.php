<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use App\Models\WargaAsrama;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use App\Models\Denda;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;
        $data = [
            'pelanggaran' => 0,
            'penghargaan' => 0,
            'denda' => 0,
            'poin_pelanggaran' => 0,
            'poin_penghargaan' => 0,
        ];

        if ($warga) {
            $riwayatPelanggaran = RiwayatPelanggaran::with('pelanggaran')
                ->where('id_warga', $warga->id_warga)
                ->get();
            $data['pelanggaran'] = $riwayatPelanggaran->count();
            $data['poin_pelanggaran'] = $riwayatPelanggaran->sum(function ($r) {
                return $r->pelanggaran->poin ?? 0;
            });

            $riwayatPenghargaan = RiwayatPenghargaan::with('penghargaan')
                ->where('id_warga', $warga->id_warga)
                ->get();
            $data['penghargaan'] = $riwayatPenghargaan->count();
            $data['poin_penghargaan'] = $riwayatPenghargaan->sum(function ($r) {
                return $r->penghargaan->poin_reward ?? 0;
            });

            $data['denda'] = Denda::whereHas('riwayatPelanggaran', function ($q) use ($warga) {
                $q->where('id_warga', $warga->id_warga);
            })->sum('nominal');
        }

        return view('warga.profil.index', compact('user', 'warga', 'data'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama ?? null;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|string|max:4',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $pengguna = Pengguna::findOrFail($user->id_user);
        $pengguna->update([
            'nama' => $validated['nama'],
        ]);

        if (!empty($validated['password'])) {
            $pengguna->update([
                'password' => bcrypt($validated['password']),
            ]);
        }

        if ($warga) {
            $warga->update([
                'nim' => $validated['nim'],
                'kamar' => $validated['kamar'],
                'angkatan' => $validated['angkatan'],
            ]);
        }

        return redirect()->route('warga.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
