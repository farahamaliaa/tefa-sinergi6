<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sinergi6 Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" />

    <link rel="stylesheet" href="https://school.mischool.id/assets/dist/css/app.css" />
    <link id="themeColors" rel="stylesheet" href="{{ asset('admin_assets/dist/css/style.min.css') }}" />

    <style>
        .bg-custom {
            background-color: #0896d1;
        }

        .welcome-title {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.1;
            text-align: left;
        }

        /* Input wrapper & icon */
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

        /* Button custom */
        .btn-primary {
            background-color: #0896d1 !important;
            border-color: #0896d1 !important;
            border-radius: 12px !important;
        }

        .form-check-label {
            font-size: 0.95rem;
        }
        #loginSection {
            position: relative;
            overflow: hidden;
        }
        .decoration {
            position: absolute;
            z-index: 1;
            width: 120px;
            opacity: 0.9;
        }

        .decoration-left {
            position: absolute;
            top: -10px;
            left: -40px;
            width: 200px;
            transform: rotate(-40deg);
            z-index: 1;
        }

        .decoration-right {
            position: absolute;
            top: 30px;
            right: -5px;
            width: 170px;
            z-index: 2;
        }

    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">

                    <div class="col-xl-7 col-xxl-8 d-flex align-items-center justify-content-center bg-custom p-5">
                        <div class="d-none d-xl-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/frame.png') }}" alt="" class="img-fluid" width="600" />
                        </div>
                    </div>

                    <div class="col-xl-5 col-xxl-4" id="loginSection"
                        style="opacity:0; transform:translateX(100px); transition:all 0.8s ease;">
                        
                        <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-5 position-relative">
                          <img src="{{ asset('assets/images/rectangle1.png') }}" 
                              class="decoration decoration-left" 
                              alt="rec1">

                          <img src="{{ asset('assets/images/rectangle2.png') }}" 
                              class="decoration decoration-right" 
                              alt="rec2">
                            <div class="col-sm-10 col-md-8 col-xl-10">

                                <img src="{{ asset('landing_assets/images/logo/sinergi6.png') }}" alt="Logo" width="300"
                                    class="mb-4" />

                                <h2 id="welcomeText" class="welcome-title"></h2>

                                <p class="text-start">Akses dashboard sekolah Anda dengan login di bawah ini.</p>

                                <form method="POST" action="{{ route('login') }}" class="fs-5">
                                    @csrf

                                    <div class="mb-4">
                                        <div class="input-wrapper">
                                            <input id="email" type="email"
                                                class="form-control custom-input @error('email') is-invalid @enderror"
                                                name="email" placeholder="Masukkan email" value="{{ old('email') }}"
                                                required />
                                            <i class="bi bi-envelope input-icon"></i>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="input-wrapper">
                                            <input id="password" type="password"
                                                class="form-control custom-input @error('password') is-invalid @enderror"
                                                name="password" placeholder="Masukkan password" required />
                                            <i class="bi bi-eye-slash input-icon" id="togglePassword"></i>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember"> Remember me </label>
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

            const text = "Welcome To School Portal";
            const container = document.getElementById("welcomeText");
            const loginSection = document.getElementById("loginSection");

            setTimeout(() => {
                loginSection.style.opacity = "1";
                loginSection.style.transform = "translateX(0)";
            }, 200);

            setTimeout(() => {
                const words = text.split(" ");
                let delay = 0;

                words.forEach(word => {
                    const spanWord = document.createElement("span");
                    spanWord.style.marginRight = "0.5rem";
                    container.appendChild(spanWord);

                    [...word].forEach(char => {
                        const charSpan = document.createElement("span");
                        charSpan.textContent = char;
                        charSpan.style.opacity = 0;
                        charSpan.style.display = "inline-block";
                        charSpan.style.transform = "translateY(10px)";
                        charSpan.style.transition = "all 0.3s ease";
                        spanWord.appendChild(charSpan);

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</body>

</html>
