<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = DB::table('pengaturan')->get();
        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            DB::table('pengaturan')->where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
