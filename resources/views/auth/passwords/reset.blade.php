<!DOCTYPE html>
<html lang="id">

<head>
    <title>Reset Kata Sandi - Sinergi6</title>
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
            padding-right: 45px; /* Space for eye icon */
            border: 1px solid #e0e6ed;
            height: 50px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0896D1;
        }
        
        /* Input Wrapper for relative positioning */
        .input-wrapper {
            position: relative;
        }

        /* Toggle Icon Styling */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 1.2rem;
            z-index: 10;
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
        
        /* Validation Error Styling */
        :root {
            --error-color: #ff6b6b;
        }

        .form-control.is-invalid {
            border-color: var(--error-color) !important;
            background-image: none !important;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
        }

        .invalid-feedback {
            color: var(--error-color) !important;
            font-weight: 600;
            font-size: 0.9em;
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
                            <mask id="mask0_9387_5780" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="7" y="6" width="37" height="37">
                                <path d="M25.5 40.5C27.6015 40.5026 29.6829 40.0899 31.6244 39.2857C33.566 38.4814 35.3295 37.3015 36.8136 35.8136C38.3015 34.3295 39.4814 32.566 40.2857 30.6244C41.0899 28.6829 41.5026 26.6015 41.5 24.5C41.5026 22.3985 41.0899 20.3171 40.2857 18.3756C39.4814 16.434 38.3015 14.6705 36.8136 13.1864C35.3295 11.6985 33.566 10.5186 31.6244 9.71434C29.6829 8.9101 27.6015 8.49742 25.5 8.50001C23.3985 8.49742 21.3171 8.9101 19.3756 9.71434C17.434 10.5186 15.6705 11.6985 14.1864 13.1864C12.6985 14.6705 11.5186 16.434 10.7143 18.3756C9.9101 20.3171 9.49742 22.3985 9.50001 24.5C9.49742 26.6015 9.9101 28.6829 10.7143 30.6244C11.5186 32.566 12.6985 34.3295 14.1864 35.8136C15.6705 37.3015 17.434 38.4814 19.3756 39.2857C21.3171 40.0899 23.3985 40.5026 25.5 40.5Z" fill="white" stroke="white" stroke-width="4" stroke-linejoin="round"/>
                                <path d="M19.0996 24.5002L23.8996 29.3002L33.4996 19.7002" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </mask>
                            <g mask="url(#mask0_9387_5780)">
                                <path d="M6.30078 5.2998H44.7008V43.6998H6.30078V5.2998Z" fill="white"/>
                            </g>
                    </svg>
                </div>

                <h3 class="text-title">Atur Ulang Kata Sandi</h3>
                <p class="text-subtitle">
                    Buat kata sandi baru dan konfirmasikan kembali.
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <!-- Hidden Email Field (Required by Laravel) -->
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    <!-- Password Field -->
                    <div class="text-start mb-2">
                        <label for="password" class="form-label fw-bold small text-dark">Sandi Baru <span class="text-danger">*</span></label>
                    </div>
                    <div class="mb-4">
                        <div class="input-wrapper">
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password"
                                placeholder="Masukkan Kata Sandi Baru">
                            
                            <!-- Toggle Eye Icon -->
                            <i class="bi bi-eye-slash toggle-password" toggle="#password"></i>
                        </div>
                        
                        @error('password')
                            <span class="invalid-feedback text-start d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="text-start mb-2">
                        <label for="password-confirm" class="form-label fw-bold small text-dark">Konfirmasi Sandi <span class="text-danger">*</span></label>
                    </div>
                    <div class="mb-4">
                        <div class="input-wrapper">
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Konfirmasi Kata Sandi">
                                
                            <!-- Toggle Eye Icon -->
                            <i class="bi bi-eye-slash toggle-password" toggle="#password-confirm"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Perbarui Kata Sandi
                    </button>
                </form>

                <div class="back-link">
                    Kembali ke Halaman <a href="{{ route('login') }}">Login</a>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function() {
                const input = document.querySelector(this.getAttribute('toggle'));
                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                } else {
                    input.setAttribute('type', 'password');
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                }
            });
        });
    </script>
</body>

</html>
