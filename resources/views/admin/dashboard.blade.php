@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ session('nama') }}!</p>
    
    {{-- <a href="{{ route('admin.warga.index') }}">Kelola Warga Asrama</a> --}}
@endsection
