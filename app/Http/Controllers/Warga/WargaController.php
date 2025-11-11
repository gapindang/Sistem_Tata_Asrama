<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        // TODO: Implement logic to list warga for warga role
        return view('warga.warga.index');
    }

    public function create()
    {
        // TODO: Implement logic to show create form
        return view('warga.warga.create');
    }

    public function store(Request $request)
    {
        // TODO: Implement logic to store warga
    }

    public function show($id)
    {
        // TODO: Implement logic to show a single warga
        return view('warga.warga.show', compact('id'));
    }

    public function edit($id)
    {
        // TODO: Implement logic to show edit form
        return view('warga.warga.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement logic to update warga
    }

    public function destroy($id)
    {
        // TODO: Implement logic to delete warga
    }
}
