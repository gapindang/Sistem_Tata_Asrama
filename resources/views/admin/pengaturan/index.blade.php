@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-3">Pengaturan Sistem</h3>
        <form action="{{ route('admin.pengaturan.update') }}" method="POST">
            @csrf
            @foreach ($settings as $setting)
                <div class="mb-3">
                    <label class="form-label">{{ $setting->key }}</label>
                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
        </form>
    </div>
@endsection
