<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Pemberitahuan::with('pengguna')
            ->latest('tanggal')
            ->get();

        return view('admin.notifikasi.index', compact('notifikasi'));
    }

    public function markAsRead($id)
    {
        $notif = Pemberitahuan::findOrFail($id);
        $notif->update(['status_baca' => true]);

        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}
