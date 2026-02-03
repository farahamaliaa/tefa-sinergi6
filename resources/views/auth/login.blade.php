<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sinergi6 Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" />

    <link rel="stylesheet" href="https://school.mischool.id/assets/dist/css/app.css" />
    <link id="themeColors" rel="stylesheet" href="{{ asset('admin_assets/dist/css/style.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

    <style>
        .bg-custom {
            background-color: #0896d1;
        }

        .welcome-title {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.4;
            text-align: left;
        }

        .input-wrapper {
            position: relative;
        }

        .custom-input {
            padding-right: 50px !important;
            height: 55px;
            font-size: 1.1rem;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            opacity: 0.7;
            cursor: pointer;
        }

        .input-wrapper:focus-within .input-icon {
            opacity: 1;
        }

        .btn-primary {
            background-color: #0896d1 !important;
            border-color: #0896d1 !important;
            border-radius: 12px !important;
        }

        #loginSection {
            position: relative;
            overflow: hidden;
        }

        .decoration {
            position: absolute;
            z-index: 0;
            opacity: 0.9;
        }

        .decoration-left {
            top: -10px;
            left: -40px;
            width: 200px;
            transform: rotate(-40deg);
        }

        .decoration-right {
            top: 30px;
            right: -5px;
            width: 170px;
        }

        #welcomeText {
            display: block;
            width: 100%;
            padding: 0 0 15px 0;
        }

        #welcomeText span {
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            #welcomeText {
                font-size: 1.2rem !important;
                text-align: center;
            }
        }

        @media (max-width: 1200px) {
            .welcome-title {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 992px) {
            .bg-custom {
                display: none !important;
            }

            #loginSection {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.5rem;
                text-align: center;
            }

            .custom-input {
                height: 50px;
                font-size: 1rem;
            }

            .decoration-left,
            .decoration-right {
                display: none;
            }

            form.fs-5 {
                font-size: 1rem !important;
            }
        }

        @media (max-width: 576px) {
            #loginSection {
                padding: 20px;
            }

            img[alt="Logo"] {
                width: 250px !important;
                margin: auto;
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row g-0">

                    <div class="col-xl-7 col-xxl-7 d-none d-xl-flex align-items-center justify-content-center bg-custom p-5">
                        <img src="{{ asset('assets/images/frame.png') }}" alt="" class="img-fluid" width="600" />
                    </div>

                    <div class="col-12 col-xl-5 col-xxl-5" id="loginSection"
                        style="opacity: 0; transform: translateX(100px); transition: all 0.8s ease;">

                        <div class="authentication-login min-vh-100 bg-body d-flex justify-content-center align-items-center p-5 position-relative">

                            <img src="{{ asset('assets/images/rectangle1.png') }}" class="decoration decoration-left">
                            <img src="{{ asset('assets/images/rectangle2.png') }}" class="decoration decoration-right">

                            <div class="col-sm-10 col-md-8 col-xl-10" style="z-index: 1;">

                                <img src="{{ asset('landing_assets/images/logo/sinergi6.png') }}" alt="Logo" width="300"
                                    class="mb-4" style="z-index: 1;"/>

                                <h3 id="welcomeText" class="welcome-title"></h3>

                                <p class="text-start">Akses dashboard sekolah Anda dengan login di bawah ini.</p>

                                <form method="POST" action="{{ route('login') }}" class="fs-5">
                                    @csrf

                                    <div class="mb-4">
                                        <div class="input-wrapper">
                                            <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                                name="email" placeholder="Masukkan email" value="{{ old('email') }}" required />
                                            <i class="bi bi-envelope input-icon"></i>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="input-wrapper">
                                            <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror"
                                                name="password" placeholder="Masukkan password" required />
                                            <i class="bi bi-eye-slash input-icon" id="togglePassword"></i>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember"> Ingat Saya </label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #0896d1;">Lupa Kata Sandi?</a>
                                    </div>

                                    <div id="failed-login" class="text-center error-text mb-3"></div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold">
                                        Masuk
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("togglePassword");
            const passwordInput = document.getElementById("password");

            toggle.addEventListener("click", () => {
                const isText = passwordInput.type === "text";
                passwordInput.type = isText ? "password" : "text";

                toggle.classList.toggle("bi-eye");
                toggle.classList.toggle("bi-eye-slash");
            });


            const container = document.getElementById("welcomeText");
            const loginSection = document.getElementById("loginSection");

            setTimeout(() => {
                loginSection.style.opacity = "1";
                loginSection.style.transform = "translateX(0)";
            }, 200);

            setTimeout(() => {
                const segments = ["Selamat Datang", "Di Website", "Manajemen Sekolah"];
                let delay = 0;

                segments.forEach(segment => {
                    const spanSegment = document.createElement("span");
                    spanSegment.style.marginRight = "0.5rem";
                    spanSegment.style.whiteSpace = "nowrap";
                    container.appendChild(spanSegment);
                    
                    container.appendChild(document.createTextNode("\u200B"));

                    [...segment].forEach(char => {
                        const charSpan = document.createElement("span");
                        if (char === " ") {
                            charSpan.innerHTML = "&nbsp;";
                        } else {
                            charSpan.textContent = char;
                        }
                        
                        charSpan.style.opacity = 0;
                        charSpan.style.display = "inline-block";
                        charSpan.style.transform = "translateY(10px)";
                        charSpan.style.transition = "all 0.3s ease";
                        spanSegment.appendChild(charSpan);

                        setTimeout(() => {
                            charSpan.style.opacity = 1;
                            charSpan.style.transform = "translateY(0)";
                        }, delay);

                        delay += 60;
                    });
                });
            }, 1000);
        });
    </script>

    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/libs/jquery/dist/jquery.min.js') }}"></script>

</body>

</html>
