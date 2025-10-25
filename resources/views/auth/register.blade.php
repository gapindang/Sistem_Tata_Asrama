@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <h2 class="mb-4 text-center">Register Warga</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        {{-- {!! NoCaptcha::display() !!} --}}
        {{-- @if ($errors->has('g-recaptcha-response'))
            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
        @endif --}}

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </div>
    </form>
</div>
@endsection
