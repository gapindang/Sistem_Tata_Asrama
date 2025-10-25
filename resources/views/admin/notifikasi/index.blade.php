{{-- @extends('layouts.app')

@section('title', 'Notifikasi Sistem')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📢 Notifikasi Sistem</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($notifikasi->isEmpty())
            <div class="alert alert-info">Belum ada notifikasi.</div>
        @else
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pesan</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifikasi as $i => $n)
                                <tr @if (!$n->status_baca) class="table-warning" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $n->pesan }}</td>
                                    <td>
                                        @switch($n->jenis)
                                            @case('pelanggaran')
                                                <span class="badge bg-danger">Pelanggaran</span>
                                            @break

                                            @case('penghargaan')
                                                <span class="badge bg-success">Penghargaan</span>
                                            @break

                                            @case('denda')
                                                <span class="badge bg-warning text-dark">Denda</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">Umum</span>
                                        @endswitch
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($n->tanggal)->format('d M Y H:i') }}</td>
                                    <td>
                                        @if ($n->status_baca)
                                            <span class="text-success">Sudah dibaca</span>
                                        @else
                                            <span class="text-danger">Belum dibaca</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$n->status_baca)
                                            <a href="{{ route('admin.notifikasi.read', $n->id_notifikasi) }}"
                                                class="btn btn-sm btn-primary">Tandai Dibaca</a>
                                        @endif
                                        <form action="{{ route('admin.notifikasi.destroy', $n->id_notifikasi) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Hapus notifikasi ini?')"
                                                class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $notifikasi->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection --}}

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
