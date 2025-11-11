@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reset Password</h1>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button class="btn btn-primary">Kirim Link Reset</button>
        </form>
    </div>
@endsection
