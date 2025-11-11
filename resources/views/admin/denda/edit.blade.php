{{-- @extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-3">Edit Denda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.denda.update', $denda->id_denda ?? $denda->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Riwayat Pelanggaran</label>
                <select name="id_riwayat_pelanggaran" class="form-control" required>
                    <option value="">-- Pilih Riwayat --</option>
                    @foreach ($riwayatWithoutDenda as $r)
                        <option value="{{ $r->id_riwayat_pelanggaran }}"
                            {{ isset($denda) && $denda->id_riwayat_pelanggaran == $r->id_riwayat_pelanggaran ? 'selected' : '' }}>
                            {{ $r->warga->nama ?? 'Warga' }} - {{ $r->pelanggaran->nama_pelanggaran ?? 'Pelanggaran' }}
                            ({{ $r->tanggal }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nominal</label>
                <input type="number" name="nominal" class="form-control" value="{{ $denda->nominal ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status Bayar</label>
                <select name="status_bayar" class="form-control">
                    <option value="belum" {{ isset($denda) && $denda->status_bayar == 'belum' ? 'selected' : '' }}>Belum
                    </option>
                    <option value="dibayar" {{ isset($denda) && $denda->status_bayar == 'dibayar' ? 'selected' : '' }}>
                        Dibayar</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Bayar (opsional)</label>
                <input type="date" name="tanggal_bayar" class="form-control" value="{{ $denda->tanggal_bayar ?? '' }}">
            </div>
            <button class="btn btn-success" type="submit">Simpan</button>
            <a href="{{ route('admin.denda.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection --}}
