<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SITAMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }

        .verify-left {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .verify-left i {
            font-size: 80px;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .verify-left h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .verify-left p {
            font-size: 15px;
            line-height: 1.8;
            opacity: 0.95;
        }

        .verify-right {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .verify-right h3 {
            color: #333;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .verify-right .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            padding: 12px 20px;
            border-radius: 0 10px 10px 0;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            outline: none;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .btn-verify {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            width: 100%;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-resend {
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            width: 100%;
        }

        .btn-resend:hover {
            background: #f8f9ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .btn-resend:disabled {
            background: #f0f0f0;
            border-color: #d0d0d0;
            color: #999;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert i {
            margin-right: 8px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        #countdown {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .verify-container {
                flex-direction: column;
                margin: 20px;
            }

            .verify-left {
                display: none;
            }

            .verify-right {
                padding: 40px 30px;
            }

            .verify-right h3 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="verify-container">
        <div class="verify-left">
            <i class="bi bi-shield-check"></i>
            <h2>SITAMA</h2>
            <p>Sistem Informasi Tata Tertib Asrama - Verifikasi identitas Anda dengan kode OTP yang telah dikirimkan ke
                email Anda.</p>
        </div>

        <div class="verify-right">
            <h3><i class="bi bi-envelope-check"></i> Verifikasi OTP</h3>
            <p class="subtitle">Masukkan kode 6 digit yang telah dikirim ke email Anda</p>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.verify-otp.post') }}" id="verifyForm">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control" value="{{ session('email') }}"
                            readonly>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label">Kode OTP</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-key"></i>
                        </span>
                        <input type="text" name="otp" class="form-control"
                            placeholder="Masukkan 6 digit kode OTP" maxlength="6" pattern="[0-9]{6}" required
                            autofocus>
                    </div>
                </div>

                <button type="submit" class="btn-verify">
                    <i class="bi bi-check-circle"></i> Verifikasi Sekarang
                </button>
            </form>

            <form method="POST" action="{{ route('auth.resend-otp') }}" id="resendForm">
                @csrf
                <button type="submit" class="btn-resend" id="resendBtn">
                    <i class="bi bi-arrow-repeat"></i> Kirim Ulang OTP
                </button>
                <div id="countdown"></div>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="bi bi-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer for resend OTP
        let countdownSeconds = 60;
        let countdownInterval;
        const resendBtn = document.getElementById('resendBtn');
        const countdownDiv = document.getElementById('countdown');

        function startCountdown() {
            resendBtn.disabled = true;
            countdownSeconds = 60;

            countdownInterval = setInterval(() => {
                countdownSeconds--;
                countdownDiv.textContent = `Kirim ulang tersedia dalam ${countdownSeconds} detik`;

                if (countdownSeconds <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    countdownDiv.textContent = '';
                }
            }, 1000);
        }

        // Start countdown on page load
        window.addEventListener('load', () => {
            startCountdown();
        });

        // Restart countdown when resend button is clicked
        document.getElementById('resendForm').addEventListener('submit', (e) => {
            if (!resendBtn.disabled) {
                startCountdown();
            }
        });

        // Auto-format OTP input (numbers only)
        const otpInput = document.querySelector('input[name="otp"]');
        otpInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
