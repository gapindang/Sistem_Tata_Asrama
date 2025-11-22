<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Filter notifikasi hanya untuk admin yang sedang login
        $notifikasi = Pemberitahuan::where('id_user', $user->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        $unreadCount = Pemberitahuan::where('id_user', $user->id_user)
            ->where('status_baca', 0)
            ->count();

        $readCount = Pemberitahuan::where('id_user', $user->id_user)
            ->where('status_baca', 1)
            ->count();

        $totalCount = $notifikasi->count();

        return view('admin.notifikasi.index', compact('notifikasi', 'unreadCount', 'readCount', 'totalCount'));
    }

    public function markAsRead($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->status_baca = 1;
        $notif->save();

        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi ditandai terbaca.');
    }

    public function destroy($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->delete();

        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil dihapus.');
    }
}
