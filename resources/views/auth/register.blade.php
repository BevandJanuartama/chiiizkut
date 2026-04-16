<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ChiiiZkut - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(145deg, #FFF8F0 0%, #FEEBD9 100%);
            position: relative; min-height: 100vh;
        }
        body::before {
            content: ""; position: fixed; top: -20%; right: -10%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(242,175,23,0.12) 0%, rgba(242,175,23,0) 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
        }
        body::after {
            content: ""; position: fixed; bottom: -15%; left: -5%; width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(230,126,34,0.1) 0%, rgba(230,126,34,0) 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
        }
        .login-wrapper { width: 100%; max-width: 450px; margin: 0 auto; }
        .login-card {
            border-radius: 2.5rem; border: none; background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 30px 55px -20px rgba(0, 0, 0, 0.25), 0 10px 25px -8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .main-logo {
            width: 300px; max-width: 300%; height: auto; object-fit: contain; margin-bottom: 1.25rem;
        }
        .badge-custom {
            background: #FEF0E0; display: inline-block; padding: 0.4rem 1.2rem;
            border-radius: 40px; font-size: 0.75rem; font-weight: 700; color: #C4681A; letter-spacing: 0.5px;
        }
        .welcome-text h3 { font-size: 1.7rem; font-weight: 800; color: #2C2418; margin-bottom: 0.25rem; }
        .welcome-text p { color: #9B7A5A; font-size: 0.9rem; font-weight: 500; }

        .form-floating-group { position: relative; margin-bottom: 1.25rem; }
        .form-control-custom {
            width: 100%; padding: 1rem 1rem 1rem 3.2rem; border: 1.5px solid #F0E0D0;
            border-radius: 1.2rem; font-size: 0.95rem; background-color: #FEFAF5;
            transition: all 0.3s ease; outline: none; -webkit-appearance: none; appearance: none;
        }
        .form-control-custom:focus {
            border-color: #F2AF17; box-shadow: 0 0 0 4px rgba(242, 175, 23, 0.15); background-color: #ffffff;
        }
        .form-control-custom::placeholder { opacity: 0; }
        .form-label-custom {
            position: absolute; left: 3.2rem; top: 1.1rem; font-size: 0.95rem; color: #A68B6F;
            pointer-events: none; transition: 0.2s ease all; background: transparent; padding: 0 4px; font-weight: 500;
        }
        .form-control-custom:focus ~ .form-label-custom,
        .form-control-custom:not(:placeholder-shown) ~ .form-label-custom,
        select.form-control-custom ~ .form-label-custom {
            top: -0.6rem; left: 1.5rem; font-size: 0.75rem; background: white;
            color: #E67E22; font-weight: 600; padding: 0 8px; border-radius: 20px;
        }
        .input-icon-left {
            position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%);
            color: #E67E22; z-index: 10; font-size: 1rem; pointer-events: none; transition: 0.3s ease;
        }
        .select-wrapper::after {
            content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute;
            right: 1.2rem; top: 50%; transform: translateY(-50%); color: #A68B6F; pointer-events: none; font-size: 0.8rem;
        }

        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        @keyframes slideDownFade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-control-custom.is-invalid {
            border-color: #E74C3C !important; background-color: #FDEDEC !important; animation: shakeError 0.4s ease-in-out;
        }
        .form-control-custom.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.2) !important; background-color: #ffffff !important;
        }
        .form-control-custom.is-invalid ~ .form-label-custom { color: #E74C3C !important; }
        .form-control-custom.is-invalid ~ .input-icon-left { color: #E74C3C !important; }
        .custom-error-msg {
            display: flex; align-items: flex-start; gap: 0.35rem; color: #E74C3C;
            font-size: 0.7rem; font-weight: 600; margin-top: 0.4rem; margin-left: 0.8rem; line-height: 1.2;
            animation: slideDownFade 0.3s ease-out forwards;
        }

        .btn-primary-custom {
            background: linear-gradient(105deg, #F0A34B, #E67E22); border: none; padding: 0.9rem;
            border-radius: 1.8rem; font-weight: 700; font-size: 1.05rem; color: white;
            transition: all 0.25s; box-shadow: 0 6px 14px rgba(230, 126, 34, 0.25); width: 100%;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(105deg, #E67E22, #CF6A1A); transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(230, 126, 34, 0.35);
        }
        .register-link { color: #E67E22; font-weight: 700; text-decoration: none; }
        .register-link:hover { text-decoration: underline; }
        .divider {
            margin-top: 1.5rem; margin-bottom: 0; height: 1.5px;
            background: linear-gradient(to right, #F0E0D0, #E6C29F, #F0E0D0);
        }

        @media (max-width: 576px) {
            .login-wrapper { max-width: 95%; }
            .login-card { border-radius: 2rem; }
            .card-body { padding: 2rem 1.5rem 1.5rem 1.5rem !important; }
            .welcome-text h3 { font-size: 1.5rem; }
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-12 login-wrapper">
                <div class="card login-card">
                    <div class="card-body p-4 px-sm-5 pt-sm-4 pb-4">
                        
                        <div class="text-center mb-4">
                            <img id="mainLogo" src="{{ asset('images/logo.png') }}" class="main-logo" alt="ChiiiZkut Logo"
                                onerror="this.src='https://placehold.co/200x200?text=ChiiiZkut&font=montserrat'">
                            <div class="badge-custom">
                                <i class="fas fa-user-plus me-1" style="font-size: 9px;"></i> PENDAFTARAN AKUN BARU
                            </div>
                        </div>

                        <div class="welcome-text text-center mb-4">
                            <h3>Bergabunglah!</h3>
                            <p>Daftarkan akun kasir/admin baru ChiiiZkut.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf

                            <div class="form-floating-group">
                                <input type="text" name="username" id="username" value="{{ old('username') }}" required
                                    class="form-control-custom @error('username') is-invalid @enderror" placeholder=" ">
                                <label for="username" class="form-label-custom">Username</label>
                                <i class="fas fa-user input-icon-left"></i>
                                
                                @error('username')
                                    <div class="custom-error-msg"><i class="fas fa-exclamation-circle mt-1"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating-group select-wrapper">
                                <select id="role" name="role" required style="cursor: pointer;"
                                    class="form-control-custom @error('role') is-invalid @enderror">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}></option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                </select>
                                <label for="role" class="form-label-custom">Akses Role</label>
                                <i class="fas fa-id-badge input-icon-left" style="z-index: 11;"></i>
                                
                                @error('role')
                                    <div class="custom-error-msg"><i class="fas fa-exclamation-circle mt-1"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="form-floating-group mb-0">
                                        <input type="password" name="password" id="password" required
                                            class="form-control-custom @error('password') is-invalid @enderror" placeholder=" ">
                                        <label for="password" class="form-label-custom">Password</label>
                                        <i class="fas fa-lock input-icon-left"></i>
                                    </div>
                                    @error('password')
                                        <div class="custom-error-msg"><i class="fas fa-exclamation-circle mt-1"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mt-3 mt-sm-0">
                                    <div class="form-floating-group mb-0">
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                            class="form-control-custom @error('password') is-invalid @enderror" placeholder=" ">
                                        <label for="password_confirmation" class="form-label-custom">Konfirmasi</label>
                                        <i class="fas fa-check-circle input-icon-left"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-2">
                                <button type="submit" class="btn-primary-custom">
                                    <i class="fas fa-paper-plane me-2"></i> Daftar
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <span class="small text-secondary">Sudah punya akses?</span>
                                <a href="{{ route('login') }}" class="register-link ms-1">
                                    Masuk di sini <i class="fas fa-arrow-right fa-xs"></i>
                                </a>
                            </div>
                            <div class="divider"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>