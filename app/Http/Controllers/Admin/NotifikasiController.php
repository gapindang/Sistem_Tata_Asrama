<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Pemberitahuan::with('pengguna')->orderBy('tanggal', 'desc')->get();
        return view('admin.notifikasi.index', compact('notifikasi'));
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
