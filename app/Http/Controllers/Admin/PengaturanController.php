<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::getAllSettings();
        $kategoris = Pelanggaran::select('kategori')->distinct()->pluck('kategori');
        $pelanggaranByKategori = Pelanggaran::all()->groupBy('kategori');

        return view('admin.pengaturan.index', compact('pengaturan', 'kategoris', 'pelanggaranByKategori'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_asrama' => 'required|string|max:255',
            'alamat_asrama' => 'nullable|string',
            'telepon_asrama' => 'nullable|string|max:20',
            'email_asrama' => 'nullable|email|max:255',
            'kepala_asrama' => 'nullable|string|max:255',
            'logo_asrama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update text settings
        Pengaturan::setValue('nama_asrama', $request->nama_asrama);
        Pengaturan::setValue('alamat_asrama', $request->alamat_asrama);
        Pengaturan::setValue('telepon_asrama', $request->telepon_asrama);
        Pengaturan::setValue('email_asrama', $request->email_asrama);
        Pengaturan::setValue('kepala_asrama', $request->kepala_asrama);

        // Handle logo upload
        if ($request->hasFile('logo_asrama')) {
            // Delete old logo if exists
            $oldLogo = Pengaturan::getValue('logo_asrama');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $path = $request->file('logo_asrama')->store('logos', 'public');
            Pengaturan::setValue('logo_asrama', $path);
        }

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function updateKategori(Request $request)
    {
        $request->validate([
            'id_pelanggaran' => 'required|exists:pelanggaran,id_pelanggaran',
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'poin' => 'required|integer|min:0',
            'denda' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($request->id_pelanggaran);
        $pelanggaran->update([
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'kategori' => $request->kategori,
            'poin' => $request->poin,
            'denda' => $request->denda,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Kategori pelanggaran berhasil diperbarui!');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'poin' => 'required|integer|min:0',
            'denda' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Pelanggaran::create([
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'kategori' => $request->kategori,
            'poin' => $request->poin,
            'denda' => $request->denda,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Kategori pelanggaran berhasil ditambahkan!');
    }

    public function deleteKategori($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Kategori pelanggaran berhasil dihapus!');
    }
}
