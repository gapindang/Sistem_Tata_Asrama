<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengguna;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('pembuat')->orderBy('created_at', 'desc')->get();
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'poster' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'isi_berita' => 'required|string',
        ]);

        $validated['id_pembuat'] = Auth::id();

        // Upload poster jika ada
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('posters', $filename, 'public');
            $validated['poster'] = $path;
        }

        $berita = Berita::create($validated);

        // Kirim notifikasi ke semua petugas dan warga
        $users = Pengguna::whereIn('role', ['petugas', 'warga'])->get();

        $pesanNotif = "Berita Baru: {$berita->judul}\n\n{$berita->isi_berita}";

        foreach ($users as $user) {
            Pemberitahuan::create([
                'id_user' => $user->id_user,
                'id_berita' => $berita->id_berita,
                'pesan' => $pesanNotif,
                'jenis' => 'umum',
                'tanggal' => now(),
                'status_baca' => 0,
            ]);
        }

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dibuat dan dikirim ke semua petugas dan warga.');
    }

    public function show($id)
    {
        $berita = Berita::with('pembuat')->findOrFail($id);
        return view('admin.berita.show', compact('berita'));
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'poster' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'isi_berita' => 'required|string',
        ]);

        // Upload poster baru jika ada
        if ($request->hasFile('poster')) {
            // Hapus poster lama
            if ($berita->poster) {
                Storage::disk('public')->delete($berita->poster);
            }

            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('posters', $filename, 'public');
            $validated['poster'] = $path;
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus poster jika ada
        if ($berita->poster) {
            Storage::disk('public')->delete($berita->poster);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
