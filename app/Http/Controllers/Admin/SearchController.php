<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WargaAsrama;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('admin.search.index');
    }

    public function search(Request $request)
    {
        $query = WargaAsrama::query();

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('nim', 'like', '%' . $request->q . '%');
        }

        $results = $query->get();

        return view('admin.search.results', compact('results'));
    }
}