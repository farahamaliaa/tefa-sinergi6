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
            
            <div class="icon-circle">
                <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="50" rx="14" fill="#0896D1"/>
                    <path d="M38.3 12H12.7C10.94 12 9.516 13.4625 9.516 15.25L9.5 34.75C9.5 36.5375 10.94 38 12.7 38H38.3C40.06 38 41.5 36.5375 41.5 34.75V15.25C41.5 13.4625 40.06 12 38.3 12ZM37.66 18.9062L26.348 26.0887C25.836 26.4137 25.164 26.4137 24.652 26.0887L13.34 18.9062C13.1796 18.8148 13.0391 18.6912 12.927 18.543C12.815 18.3948 12.7337 18.225 12.6881 18.044C12.6425 17.8629 12.6336 17.6744 12.6619 17.4897C12.6901 17.3051 12.7549 17.1282 12.8525 16.9697C12.95 16.8113 13.0781 16.6746 13.2292 16.5679C13.3802 16.4612 13.551 16.3867 13.7312 16.349C13.9114 16.3113 14.0973 16.3111 14.2775 16.3484C14.4578 16.3858 14.6287 16.4599 14.78 16.5662L25.5 23.375L36.22 16.5662C36.3713 16.4599 36.5422 16.3858 36.7225 16.3484C36.9027 16.3111 37.0886 16.3113 37.2688 16.349C37.449 16.3867 37.6198 16.4612 37.7708 16.5679C37.9219 16.6746 38.05 16.8113 38.1476 16.9697C38.2451 17.1282 38.3099 17.3051 38.3382 17.4897C38.3664 17.6744 38.3575 17.8629 38.3119 18.044C38.2663 18.225 38.185 18.3948 38.073 18.543C37.9609 18.6912 37.8204 18.8148 37.66 18.9062Z" fill="white"/>
                </svg>
                <!-- <i class="bi bi-envelope-fill" style="font-size: 32px; color: #0896d1;"></i> -->
            </div>

            <h3 class="text-title">Email Telah Terkirim</h3>
            <p class="text-subtitle">
                Silakan buka email Anda untuk membuat kata<br>sandi baru.
            </p>

            <!-- <a href="https://mail.google.com/" target="_blank" class="btn btn-primary w-100">
                Buka Email
            </a> -->

            <div class="back-link">
                Kembali ke Halaman <a href="{{ route('login') }}">Login</a>
            </div>

        </div>
    </div>
    </div>

    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
