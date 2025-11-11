{{-- @extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-3">Detail Denda</h3>

        <div class="card">
            <div class="card-body">
                <p><strong>Nama Pelanggaran:</strong> {{ $denda->riwayatPelanggaran->pelanggaran->nama_pelanggaran ?? '-' }}
                </p>
                <p><strong>Warga:</strong> {{ $denda->riwayatPelanggaran->warga->nama ?? '-' }}</p>
                <p><strong>Nominal:</strong> Rp{{ number_format($denda->nominal ?? 0, 0, ',', '.') }}</p>
                <p><strong>Status Bayar:</strong> {{ $denda->status_bayar ?? '-' }}</p>
                <p><strong>Tanggal Bayar:</strong> {{ $denda->tanggal_bayar ?? '-' }}</p>
            </div>
        </div>

        <a href="{{ route('admin.denda.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection --}}
