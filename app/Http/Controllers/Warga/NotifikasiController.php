<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemberitahuan;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifikasi = Pemberitahuan::where('id_user', $user->id_user)->orderBy('tanggal', 'desc')->get();
        return view('warga.notifikasi.index', compact('notifikasi'));
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
