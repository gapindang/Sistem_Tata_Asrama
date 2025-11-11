@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Leaderboard Mahasiswa Teladan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nama</th>
                    <th>Total Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboard as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->nama ?? '-' }}</td>
                        <td>{{ $row->total_poin ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
