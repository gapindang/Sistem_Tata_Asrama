@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Profil Saya')
    @section('content')
    @endif

    <style>
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
            color: #667eea;
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
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 40px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-box.pelanggaran .stat-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-box.penghargaan .stat-icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .stat-box.denda .stat-icon {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        /* Tablet Responsive - 768px */
        @media (max-width: 768px) {
            .profile-header {
                padding: 25px;
                margin-bottom: 20px;
                border-radius: 12px;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
                margin-bottom: 15px;
            }

            .profile-name {
                font-size: 1.6rem;
                margin-bottom: 5px;
            }

            .profile-role {
                font-size: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
                margin-bottom: 20px;
            }

            .stat-box {
                padding: 18px 10px;
                border-radius: 12px;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .stat-value {
                font-size: 1.6rem;
                margin-bottom: 3px;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .info-card {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 12px;
            }

            .info-card h4 {
                font-size: 1.1rem;
                margin-bottom: 18px;
                padding-bottom: 12px;
            }

            .info-row {
                padding: 12px 0;
                flex-direction: column;
                gap: 5px;
            }

            .info-label {
                flex: unset;
                font-size: 0.85rem;
            }

            .info-value {
                font-size: 0.95rem;
            }

            .form-label {
                font-size: 0.9rem;
                margin-bottom: 6px;
            }

            .form-control {
                padding: 10px 15px;
                font-size: 0.95rem;
                border-radius: 8px;
            }

            .btn-save {
                padding: 10px 30px;
                font-size: 0.95rem;
                border-radius: 8px;
            }

            .btn-save:hover {
                transform: none;
            }
        }

        /* Small Mobile Responsive - 480px */
        @media (max-width: 480px) {
            .profile-header {
                padding: 20px 15px;
                margin-bottom: 15px;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                margin-bottom: 12px;
            }

            .profile-name {
                font-size: 1.4rem;
            }

            .profile-role {
                font-size: 0.9rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 15px;
            }

            .stat-box {
                padding: 15px;
                display: flex;
                align-items: center;
                text-align: left;
                gap: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
                margin: 0;
                flex-shrink: 0;
            }

            .stat-content {
                flex: 1;
            }

            .stat-value {
                font-size: 1.5rem;
                margin-bottom: 2px;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .info-card {
                padding: 15px;
                margin-bottom: 15px;
            }

            .info-card h4 {
                font-size: 1rem;
                margin-bottom: 15px;
                padding-bottom: 10px;
            }

            .info-card h4 i {
                font-size: 0.9rem;
            }

            .info-row {
                padding: 10px 0;
            }

            .info-label {
                font-size: 0.8rem;
            }

            .info-value {
                font-size: 0.9rem;
            }

            .form-label {
                font-size: 0.85rem;
            }

            .form-label small {
                display: block;
                margin-top: 3px;
            }

            .form-control {
                padding: 8px 12px;
                font-size: 0.9rem;
            }

            .btn-save {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .btn-save i {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="profile-name">{{ Auth::user()->nama }}</div>
            <div class="profile-role">Warga Asrama</div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-box pelanggaran">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Pelanggaran</div>
                </div>
            </div>
            <div class="stat-box penghargaan">
                <div class="stat-icon">
                    <i class="bi bi-trophy"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Penghargaan</div>
                </div>
            </div>
            <div class="stat-box denda">
                <div class="stat-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Denda</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Information Card -->
            <div class="col-md-6">
                <div class="info-card">
                    <h4><i class="bi bi-info-circle"></i> Informasi Personal</h4>
                    <div class="info-row">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ Auth::user()->nama }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NIM</div>
                        <div class="info-value">{{ Auth::user()->wargaAsrama->nim ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kamar</div>
                        <div class="info-value">{{ Auth::user()->wargaAsrama->kamar ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Angkatan</div>
                        <div class="info-value">{{ Auth::user()->wargaAsrama->angkatan ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Role</div>
                        <div class="info-value">
                            <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Bergabung Sejak</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="col-md-6">
                <div class="info-card">
                    <h4><i class="bi bi-pencil-square"></i> Edit Profil</h4>
                    <form action="{{ route('warga.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ Auth::user()->nama }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control"
                                value="{{ Auth::user()->wargaAsrama->nim ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kamar</label>
                            <input type="text" name="kamar" class="form-control"
                                value="{{ Auth::user()->wargaAsrama->kamar ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Angkatan</label>
                            <input type="text" name="angkatan" class="form-control"
                                value="{{ Auth::user()->wargaAsrama->angkatan ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin
                                    mengubah)</small></label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password baru">
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

    @if (!request()->ajax())
    @endsection
@endif
