@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container mt-4">
        <h2>Dashboard Admin</h2>
        <hr>
        <div class="row text-center mt-4">
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total Pelanggaran</h4>
                    <h2>{{ $data['totalPelanggaran'] }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total Penghargaan</h4>
                    <h2>{{ $data['totalPenghargaan'] }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total Denda (Rp)</h4>
                    <h2>{{ number_format($data['totalDenda'], 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
