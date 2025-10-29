<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $wargas = WargaAsrama::all();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'wargas' => $wargas
            ]);
        }

        return view('admin.warga.index', compact('wargas'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:warga_asrama,nim',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
        ]);

        DB::beginTransaction();

        try {
            $pengguna = Pengguna::create([
                'id_user' => Str::uuid(),
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'warga',
            ]);

            $warga = WargaAsrama::create([
                'id_warga' => Str::uuid(),
                'id_user' => $pengguna->id_user,
                'nama' => $validated['nama'],
                'nim' => $validated['nim'],
                'kamar' => $validated['kamar'],
                'angkatan' => $validated['angkatan'],
                'status' => $validated['status'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Warga dan pengguna berhasil dibuat!',
                'data' => [
                    'pengguna' => $pengguna,
                    'warga' => $warga,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $warga = WargaAsrama::findOrFail($id);
    }

    public function show($id)
    {
        $warga = WargaAsrama::with([
            'riwayatPelanggaran.pelanggaran',
            'riwayatPenghargaan.penghargaan'
        ])->findOrFail($id);

        return response()->json(['data' => $warga]);
    }

    public function destroy($id)
    {
        $warga = WargaAsrama::findOrFail($id);
        $warga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data warga berhasil dihapus!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $warga = WargaAsrama::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:warga_asrama,nim,' . $id . ',id_warga',
            'kamar' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $warga->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data warga berhasil diperbarui!',
            'data' => $warga,
        ]);
    }

    public function filter(Request $request)
    {
        $query = WargaAsrama::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('nim')) {
            $query->where('nim', $request->nim);
        }
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $wargas = $query->get();

        return response()->json([
            'success' => true,
            'wargas' => $wargas,
        ]);
    }
}
