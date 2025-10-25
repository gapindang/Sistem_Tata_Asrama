@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Dashboard Petugas')
    @section('content')
    @endif

    <div class="container mt-4">
        <h2>Dashboard Petugas</h2>
        <hr>
        <div class="alert alert-primary">
            Selamat datang, <strong>{{ Auth::user()->nama }}</strong>!
            Berikut ringkasan kegiatan Anda hari ini.
        </div>

        <div class="row text-center mt-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0">
                    <h5>Pelanggaran yang Dicatat</h5>
                    <h2>{{ $data['pelanggaranDicatat'] ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-0">
                    <h5>Penghargaan yang Diberikan</h5>
                    <h2>{{ $data['penghargaanDiberikan'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if (!request()->ajax())
    @endsection
@endif
