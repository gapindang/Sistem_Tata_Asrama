<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Pemberitahuan::with('pengguna')->orderBy('tanggal', 'desc')->get();
        return view('petugas.notifikasi.index', compact('notifikasi'));
    }

    public function markAsRead($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->status_baca = 1;
        $notif->save();

        return redirect()->route('petugas.notifikasi.index')->with('success', 'Notifikasi ditandai terbaca.');
    }

    public function destroy($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->delete();

        return redirect()->route('petugas.notifikasi.index')->with('success', 'Notifikasi berhasil dihapus.');
    }
}
