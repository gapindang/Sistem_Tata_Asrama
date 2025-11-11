@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Catat Pelanggaran Baru</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('petugas.riwayat.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Warga</label>
                <select name="id_warga" class="form-control">
                    @foreach ($wargas as $w)
                        <option value="{{ $w->id_warga }}">{{ $w->nama }} ({{ $w->nim ?? '' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Pelanggaran</label>
                <select name="id_pelanggaran" class="form-control">
                    @foreach ($pelanggarans as $p)
                        <option value="{{ $p->id_pelanggaran }}">{{ $p->nama_pelanggaran }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Bukti (foto/pdf)</label>
                <input type="file" name="bukti" class="form-control">
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
