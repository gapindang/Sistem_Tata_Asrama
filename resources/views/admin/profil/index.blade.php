@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
    <style>
        .profile-header {
            background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%);
            border-radius: 15px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(36, 150, 255, 0.3);
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #2496FF;
            margin: 0 auto 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-role {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .info-card h4 {
            color: #333;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f0f0f0;
        }

        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            flex: 0 0 150px;
            font-weight: 600;
            color: #666;
        }

        .info-value {
            flex: 1;
            color: #333;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #2496FF;
            box-shadow: 0 0 0 0.2rem rgba(36, 150, 255, 0.25);
        }

        .btn-save {
            background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%);
            border: none;
            padding: 12px 40px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(36, 150, 255, 0.4);
        }

        @media (max-width: 768px) {
            .profile-header {
                padding: 25px;
                border-radius: 12px;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .profile-name {
                font-size: 1.6rem;
            }

            .info-card {
                padding: 20px;
                border-radius: 12px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
                padding: 12px 0;
            }

            .info-label {
                flex: unset;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div class="profile-name">{{ $user->nama }}</div>
            <div class="profile-role">Administrator</div>
        </div>

        <div class="row">
            <!-- Information Card -->
            <div class="col-md-6">
                <div class="info-card">
                    <h4><i class="bi bi-info-circle"></i> Informasi Personal</h4>
                    <div class="info-row">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $user->nama }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Role</div>
                        <div class="info-value">
                            <span class="badge bg-danger">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Bergabung Sejak</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="col-md-6">
                <div class="info-card">
                    <h4><i class="bi bi-pencil-square"></i> Edit Profil</h4>
                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <small class="text-muted">(Tidak dapat diubah)</small></label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled readonly>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle"></i> Email tidak dapat diubah untuk alasan keamanan
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru
                                <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                            </label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password baru">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Konfirmasi password baru">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
