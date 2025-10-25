@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
    <h2>Selamat Datang di Asrama, {{ session('nama') }}</h2>
    <p>Status akun Anda: {{ session('role') }}</p>
@endsection
