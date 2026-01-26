<!DOCTYPE html>
<html lang="id">

<head>
    <title>Lupa Kata Sandi - Sinergi6</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://school.mischool.id/assets/dist/css/app.css" />
    <link id="themeColors" rel="stylesheet" href="{{ asset('admin_assets/dist/css/style.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .bg-soft-blue {
            background-color: #eef7ff;
        }

        .bg-image {
            position: fixed;
            top: 0;
            /* width: 50%; */
            height: 100vh;
            z-index: -1;
            object-fit: cover;
        }

        .bg-left {
            left: 0;
        }

        .bg-right {
            right: 0;
        }

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
            border-radius: 8px !important;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .card-custom {
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            padding: 40px;
            background: white;
            position: relative;
            z-index: 10;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background-color: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            padding-left: 45px;
            border: 1px solid #e0e6ed;
            height: 50px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0896D1;
        }

        .input-group-text {
            background: transparent;
            border: none;
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 4;
            color: #6c757d;
            padding: 0;
        }

        .input-wrapper {
            position: relative;
        }

        .text-title {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .text-subtitle {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .back-link {
            color: #6c757d;
            font-size: 14px;
            text-decoration: none;
            margin-top: 24px;
            display: inline-block;
        }
        
        .back-link a {
            color: #0896D1;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 1125px) {
            .bg-image {
                width: 100%;
            }
            .bg-left {
                display: none;
            }
        }
    </style>
</head>

<body>
    <img src="{{ asset('assets/images/background/BgResetPasswordLeft.png') }}" alt="Background Left" class="bg-image bg-left">
    <img src="{{ asset('assets/images/background/BgResetPasswordRight.png') }}" alt="Background Right" class="bg-image bg-right">

    <div class="d-flex align-items-center justify-content-center min-vh-100 p-4">
        <div class="container" style="max-width: 500px;">
            <div class="card-custom text-center">
                
                <div class="icon-circle bg-light-primary">
                    <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="50" height="50" rx="14" fill="#0896D1"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M41 19.0687C41 24.6303 36.4721 29.139 30.8882 29.139C29.8706 29.139 27.5507 28.9054 26.4227 27.9678L25.0116 29.3726C24.1812 30.1998 24.4052 30.443 24.7748 30.843C24.9284 31.011 25.1076 31.2046 25.2467 31.4814C25.2467 31.4814 26.4227 33.1198 25.2467 34.7598C24.5412 35.6958 22.5652 37.0061 20.3093 34.7598L19.8389 35.227C19.8389 35.227 21.2484 36.8669 20.0741 38.5069C19.3685 39.4429 17.4869 40.3789 15.8406 38.7405L14.1958 40.3789C13.0662 41.5037 11.6871 40.8477 11.1399 40.3789L9.7271 38.9741C8.41033 37.6621 9.17831 36.2413 9.7271 35.6941L21.954 23.5183C21.954 23.5183 20.778 21.6463 20.778 19.0703C20.778 13.5088 25.3059 9 30.8898 9C36.4737 9 41 13.5088 41 19.0687ZM30.8898 22.5823C31.8231 22.584 32.7188 22.215 33.3801 21.5564C34.0414 20.8978 34.414 20.0036 34.4161 19.0703C34.4153 18.6081 34.3234 18.1505 34.1458 17.7238C33.9681 17.297 33.7081 16.9095 33.3807 16.5832C33.0532 16.2569 32.6647 15.9983 32.2373 15.8222C31.8099 15.6461 31.3521 15.5559 30.8898 15.5567C30.4276 15.5559 29.9697 15.6461 29.5423 15.8222C29.1149 15.9983 28.7264 16.2569 28.399 16.5832C28.0715 16.9095 27.8116 17.297 27.6339 17.7238C27.4562 18.1505 27.3643 18.6081 27.3635 19.0703C27.3656 20.0036 27.7383 20.8978 28.3996 21.5564C29.0608 22.215 29.9566 22.584 30.8898 22.5823Z" fill="white"/>
                    </svg>
                </div>

                <h3 class="text-title">Lupa Kata Sandi?</h3>
                <p class="text-subtitle">
                    Masukkan email Anda untuk mengatur ulang<br>kata sandi.
                </p>

                @if (session('status'))
                    <div class="alert alert-success text-start mb-4 py-2" role="alert">
                        <small>{{ session('status') }}</small>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="text-start mb-2">
                        <label for="email" class="form-label fw-bold small text-dark">Email</label>
                    </div>

                    <div class="mb-4">
                        <div class="input-wrapper">
                            <span class="input-group-text">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 6H6C4.89543 6 4 6.89543 4 8V16C4 17.1046 4.89543 18 6 18H18C19.1046 18 20 17.1046 20 16V8C20 6.89543 19.1046 6 18 6Z" stroke="#888888" stroke-width="2"/>
                                    <path d="M4 9L11.106 12.553C11.3836 12.6917 11.6897 12.7639 12 12.7639C12.3103 12.7639 12.6164 12.6917 12.894 12.553L20 9" stroke="#888888" stroke-width="2"/>
                                </svg>
                            </span>
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" 
                                placeholder="Masukkan Email Anda"
                                required autocomplete="email" autofocus>
                                
                            @error('email')
                                <span class="position-absolute end-0 top-50 translate-middle-y me-3">
                                    <i class="bi bi-exclamation-circle text-danger" style="color: #ff6b6b !important; font-size: 1.2rem;"></i>
                                </span>
                            @enderror
                        </div>
                        
                        @error('email')
                            <span class="invalid-feedback text-start d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Kirim Email
                    </button>
                </form>

                <div class="back-link">
                    Kembali ke Halaman <a href="{{ route('login') }}">Login</a>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
