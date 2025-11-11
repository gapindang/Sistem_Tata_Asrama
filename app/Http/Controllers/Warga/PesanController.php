<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemberitahuan;

class PesanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Pemberitahuan::where('id_user', $user->id_user)->orderBy('tanggal', 'desc')->get();
        return view('warga.pesan.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'pesan' => 'required|string|max:2000',
            'to' => 'nullable|string',
        ]);

        Pemberitahuan::create([
            'id_user' => $user->id_user,
            'pesan' => $validated['pesan'],
            'jenis' => 'pesan',
            'tanggal' => now(),
            'status_baca' => 0,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }
}
