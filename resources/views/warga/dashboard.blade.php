@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Dashboard Warga')
    @section('content')
    @endif

    <div class="container mt-4">
        <h2>Dashboard Warga</h2>
        <hr>
        <div class="alert alert-success">
            Halo, <strong>{{ Auth::user()->nama }}</strong>!
            Selamat datang di sistem informasi asrama.
        </div>

        <div class="row text-center mt-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-0">
                    <h5>Total Pelanggaran</h5>
                    <h2>{{ $data['pelanggaran'] ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-0">
                    <h5>Total Penghargaan</h5>
                    <h2>{{ $data['penghargaan'] ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-0">
                    <h5>Total Denda (Rp)</h5>
                    <h2>{{ number_format($data['denda'] ?? 0, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if (!request()->ajax())
    @endsection
@endif
