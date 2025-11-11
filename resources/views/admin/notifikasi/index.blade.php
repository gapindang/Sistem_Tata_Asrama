@extends('layouts.app')

@section('title', 'Notifikasi Sistem')

@section('content')
    <div class="container">
        <h2 class="mb-4">🔔 Notifikasi Sistem</h2>

        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Pesan</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifikasi as $i => $notif)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $notif->pesan }}</td>
                        <td>{{ ucfirst($notif->jenis) }}</td>
                        <td>{{ $notif->tanggal }}</td>
                        <td>
                            @if ($notif->status_baca)
                                <span class="badge bg-success">Sudah dibaca</span>
                            @else
                                <span class="badge bg-danger">Belum dibaca</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
