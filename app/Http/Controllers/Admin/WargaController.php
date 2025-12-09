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
            'role' => 'required|in:warga,petugas',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
        ]);

        $role = $request->input('role', 'warga');

        // if role is warga, validate warga-specific fields
        if ($role === 'warga') {
            $request->validate([
                'nim' => 'required|string|max:50|unique:warga_asrama,nim',
                'kamar' => 'required|string|max:20',
                'angkatan' => 'required|integer',
                'status' => 'required|in:aktif,nonaktif',
            ]);
        }

        DB::beginTransaction();

        try {
            // create pengguna with chosen role
            $pengguna = Pengguna::create([
                'id_user' => Str::uuid(),
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $role,
            ]);

            $warga = null;
            if ($role === 'warga') {
                $warga = WargaAsrama::create([
                    'id_warga' => Str::uuid(),
                    'id_user' => $pengguna->id_user,
                    'nama' => $validated['nama'],
                    'nim' => $request->input('nim'),
                    'kamar' => $request->input('kamar'),
                    'angkatan' => $request->input('angkatan'),
                    'status' => $request->input('status'),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ($role === 'warga' ? 'Warga dan pengguna berhasil dibuat!' : 'Pengguna petugas berhasil dibuat!'),
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
        // normalize and trim inputs to avoid filtering issues
        $nama = $request->has('nama') ? trim($request->input('nama')) : null;
        $nim = $request->has('nim') ? trim($request->input('nim')) : null;
        $kamar = $request->has('kamar') ? trim($request->input('kamar')) : null;
        $angkatan = $request->has('angkatan') ? trim($request->input('angkatan')) : null;
        $status = $request->has('status') ? trim($request->input('status')) : null;

        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }

        if (!empty($nim)) {
            // use partial match for nim as users may type prefix
            $query->where('nim', 'like', '%' . $nim . '%');
        }

        if (!empty($kamar)) {
            // use partial match to be resilient to spacing/case
            $query->where('kamar', 'like', '%' . $kamar . '%');
        }

        if (!empty($angkatan)) {
            $query->where('angkatan', $angkatan);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $wargas = $query->get();

        return response()->json([
            'success' => true,
            'wargas' => $wargas,
        ]);
    }
}
