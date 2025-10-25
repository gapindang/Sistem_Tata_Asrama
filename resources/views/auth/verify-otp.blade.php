@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Verifikasi Kode OTP</h2>

        @if (session('success'))
            <div style="color:green;">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.verify-otp.post') }}">
            @csrf
            <div>
                <label>Email</label><br>
                <input type="email" name="email" value="{{ session('email') }}" readonly><br><br>
            </div>

            <div>
                <label>Kode OTP</label><br>
                <input type="text" name="otp" required><br><br>
            </div>

            <button type="submit">Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('auth.resend-otp') }}" style="margin-top:10px;">
            @csrf
            <button type="submit">Kirim Ulang OTP</button>
        </form>
    </div>
@endsection
