@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ubah Password</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-primary">Reset Password</button>
        </form>
    </div>
@endsection
