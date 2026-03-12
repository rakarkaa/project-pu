<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - SI PANDU</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            background: #fff;
            max-width: 950px;
            width: 100%;
        }

        /* Area Branding Kiri (Sisi Biru) */
        .login-brand {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-center;
        }

        .login-brand img {
            max-width: 180px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
        }

        .login-brand h2 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .login-brand p {
            font-weight: 300;
            opacity: 0.8;
            font-size: 0.95rem;
        }

        /* Area Form Kanan (Sisi Putih) */
        .login-form-area {
            padding: 4rem 3rem;
        }

        .login-header {
            margin-bottom: 2.5rem;
        }

        .login-header h3 {
            font-weight: 700;
            color: #2c3e50;
        }

        .login-header p {
            color: #7f8c8d;
        }

        /* Input Styling Modern */
        .form-floating > .form-control {
            border-radius: 10px;
            border: 1px solid #e1e8ed;
            padding-left: 3rem;
        }

        .form-floating > label {
            padding-left: 3.2rem;
            color: #aab8c2;
        }

        /* Menambahkan Ikon di depan Input */
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #4e73df;
            z-index: 10;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.15);
        }

        .is-invalid + .input-icon {
            color: #e74a3b;
        }

        /* Tombol Modern */
        .btn-login {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
            background: linear-gradient(45deg, #224abe, #4e73df);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .login-brand {
                padding: 2rem;
                border-radius: 20px 20px 0 0;
            }
            .login-brand img {
                max-width: 120px;
                margin-bottom: 1rem;
            }
            .login-brand h2 {
                font-size: 1.8rem;
            }
            .login-form-area {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card login-card shadow-lg">
        <div class="row g-0">
            
            {{-- ========================================================== --}}
            {{-- AREA KIRI (BRANDING & LOGO YANG ANDA SISIPKAN)             --}}
            {{-- ========================================================== --}}
            <div class="col-md-5 login-brand">
                {{-- Gunakan asset() agar Laravel bisa menemukan gambar logo Anda di folder public --}}
                <img src="{{ asset('assets/img/logopus.png') }}" alt="Logo SI PANDU">
                
                <h2 class="mt-3">SI PANDU</h2>
                <p class="mb-0">Sistem Informasi Pemantauan Dokumen PU</p>
                <div class="mt-auto small op-5 mt-5">
                    <i class="fas fa-copyright me-1"></i> Kementerian PU - PUS 4
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- AREA KANAN (FORM LOGIN - FUNGSI BACKEND TETAP SAMA)        --}}
            {{-- ========================================================== --}}
            <div class="col-md-7 login-form-area">
                <div class="login-header">
                    <h3>Selamat Datang!</h3>
                    <p>Silakan masukkan email dan password Anda untuk masuk.</p>
                </div>

                {{-- FORM ASLI TANPA DIUBAH FUNGSI DAN ATRIBUTNYA --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Input Email --}}
                    <div class="mb-3 position-relative form-floating">
                        {{-- Ikon FontAwesome di depan input --}}
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                        <label for="email">{{ __('Email Address') }}</label>
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Input Password --}}
                    <div class="mb-3 position-relative form-floating">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password" placeholder="Password">
                        <label for="password">{{ __('Password') }}</label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Remember Me & Link Lupa Password (Jika Ada) --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        {{-- Un-comment jika route request password tersedia --}}
                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link small text-primary p-0 text-decoration-none" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif --}}
                    </div>

                    {{-- Tombol Login --}}
                    <div class="d-grid gap-2 text-start">
                        <button type="submit" class="btn btn-primary btn-login shadow-sm text-white">
                            LOGIN SEKARANG <i class="fas fa-arrow-right ms-2 small"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>