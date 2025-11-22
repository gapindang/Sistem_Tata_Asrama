<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemberitahuan;
use App\Models\Pengguna;

class PesanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $messages = Pemberitahuan::where('id_user', $user->id_user)
            ->where('jenis', 'umum')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('warga.pesan.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $warga = $user->wargaAsrama;

        $validated = $request->validate([
            'pesan' => 'required|string|max:2000',
            'to' => 'nullable|string',
        ]);

        $namaWarga = $warga ? $warga->nama : $user->nama;
        $pesanLengkap = "Pesan dari {$namaWarga}:\n\n{$validated['pesan']}";

        Pemberitahuan::create([
            'id_user' => $user->id_user,
            'pesan' => $validated['pesan'],
            'jenis' => 'umum',
            'tanggal' => now(),
            'status_baca' => 1,
        ]);

        $petugas = Pengguna::where('role', 'petugas')->get();

        foreach ($petugas as $penerima) {
            Pemberitahuan::create([
                'id_user' => $penerima->id_user,
                'pesan' => $pesanLengkap,
                'jenis' => 'umum',
                'tanggal' => now(),
                'status_baca' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim ke semua petugas asrama.');
    }
}
