<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('admin.search.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Implement your search logic here
        // For example, searching in Pengguna model
        $results = \App\Models\Pengguna::where('nama', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->get();

        return view('admin.search.results', compact('results', 'keyword'));
    }
}