<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi dengan eager load berita
        $notifikasi = Pemberitahuan::with('berita')
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung statistik
        $unreadCount = Pemberitahuan::where('id_user', $user->id_user)
            ->where('status_baca', 0)
            ->count();

        $readCount = Pemberitahuan::where('id_user', $user->id_user)
            ->where('status_baca', 1)
            ->count();

        $totalCount = $notifikasi->count();

        return view('petugas.notifikasi.index', compact('notifikasi', 'unreadCount', 'readCount', 'totalCount'));
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
