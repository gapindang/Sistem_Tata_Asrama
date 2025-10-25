<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    public function index()
    {
        return view('admin.penghargaan.index');
    }
}
