@extends('layouts.app')
@section('title', 'Data Warga Asrama')

@section('content')
    <div class="container">
        <h2 class="mb-4">👥 Data Warga Asrama</h2>

        <a href="{{ route('admin.warga.create') }}" class="btn btn-primary mb-3">+ Tambah Warga</a>

        <form method="GET" class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="blok" class="form-control" placeholder="Filter Blok"
                    value="{{ request('blok') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="kamar" class="form-control" placeholder="Filter Kamar"
                    value="{{ request('kamar') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Blok</th>
                    <th>Kamar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warga as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->blok ?? '-' }}</td>
                        <td>{{ $row->kamar ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.warga.show', $row->id_user) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.warga.edit', $row->id_user) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.warga.destroy', $row->id_user) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus warga ini?')"
                                    class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
