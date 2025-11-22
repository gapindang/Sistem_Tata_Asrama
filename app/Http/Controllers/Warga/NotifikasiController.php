<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemberitahuan;
use App\Models\Berita;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi dengan filter by user dan eager load berita
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

        // Ambil data berita untuk yang ada di notifikasi
        $beritaList = Berita::orderBy('created_at', 'desc')->get()->keyBy('id_berita');

        return view('warga.notifikasi.index', compact('notifikasi', 'unreadCount', 'readCount', 'totalCount', 'beritaList'));
    }

    public function markAsRead($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->status_baca = 1;
        $notif->save();

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function destroy($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->delete();

        return redirect()->back()->with('success', 'Notifikasi dihapus.');
    }
}
