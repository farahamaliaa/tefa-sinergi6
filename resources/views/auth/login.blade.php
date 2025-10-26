    <!DOCTYPE html>
<html lang="id">

<head>
    <!--  Title -->
    <title>Sinergi6 | Login</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="handheldfriendly" content="true">
    <meta name="MobileOptimized" content="width">
    <meta name="description" content="Mordenize">
    <meta name="author" content="">
    <meta name="keywords" content="Mordenize">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}">
    <!-- Core Css -->
    <style>
        
    </style>
    <link rel="stylesheet" href="https://school.mischool.id/assets/dist/css/app.css">
    <link id="themeColors" rel="stylesheet" href="{{ asset('admin_assets/dist/css/style.min.css') }}">
</head>
<body>
    <!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100">
      <div class="position-relative z-index-5">
        <div class="row">
          <!-- Bagian kiri -->
          <div class="col-xl-7 col-xxl-8 d-flex align-items-center justify-content-center">
            <div class="d-none d-xl-flex align-items-center justify-content-center">
              <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg"
                alt="" class="img-fluid" width="550">
            </div>
          </div>
    
          <!-- Bagian kanan -->
          <div class="col-xl-5 col-xxl-4" id="loginSection" style="opacity: 0; transform: translateX(100px); transition: all 0.8s ease;">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-5">
                <div class="col-sm-10 col-md-8 col-xl-10">

                <!-- Judul -->
                <h2 id="welcomeText" class="mb-4 fw-bold text-center lh-1" style="font-size: 2rem;">
                </h2>

                <form method="POST" action="{{ route('login') }}" class="fs-5">
                @method('post')
                @csrf

                    <!-- Email -->
                <div class="mb-4">
                  <label for="email" class="form-label fw-semibold">Email</label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light">
                      <i class="bi bi-envelope"></i>
                    </span>
                    <input
                      id="email"
                      type="email"
                      class="form-control @error('email') is-invalid @enderror"
                      name="email"
                      value="{{ old('email') }}"
                      placeholder="Masukkan email"
                      required
                      autocomplete="email"
                      autofocus
                    />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <!-- Password -->
                <div class="mb-4">
                  <label for="password" class="form-label fw-semibold">Password</label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="bi bi-lock fs-5"></i>
                    </span>
                    <input
                      type="password"
                      name="password"
                      class="form-control @error('password') is-invalid @enderror"
                      placeholder="Masukkan password"
                      required
                      autocomplete="current-password"
                      id="password"
                    />
                    <span class="input-group-text bg-light border-start-0" style="cursor:pointer" id="togglePassword">
                      <i class="bi bi-eye-slash fs-5"></i>
                    </span>
                  </div>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                        @enderror
                        </div>
                        <div id="failed-login" class="text-center error-text mb-4"></div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-3">Masuk</button>
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
  const text = "Selamat Datang di Sinergi6";
  const container = document.getElementById("welcomeText");
  const loginSection = document.getElementById("loginSection");

  // Simpan tinggi sementara sebelum animasi dimulai
  container.style.minHeight = "2.5rem"; // bisa disesuaikan sesuai ukuran teks
  container.style.display = "block";

  // 🔹 Awal: form geser dari kanan
  loginSection.style.opacity = "0";
  loginSection.style.transform = "translateX(100px)";
  loginSection.style.transition = "all 0.8s ease";

  setTimeout(() => {
    loginSection.style.opacity = "1";
    loginSection.style.transform = "translateX(0)";
  }, 200);

  // 🔹 Setelah animasi form, tampilkan teks
  setTimeout(() => {
    const words = text.split(" "); // pisah jadi kata
    let delay = 0;

    words.forEach((word, wordIndex) => {
      const wordSpan = document.createElement("span");
      wordSpan.style.display = "inline-block";
      wordSpan.style.whiteSpace = "nowrap"; // jaga agar huruf dalam satu kata tetap bareng
      wordSpan.style.marginRight = "0.5rem"; // jarak antar kata
      container.appendChild(wordSpan);

      // animasi huruf per huruf dalam kata
      [...word].forEach((char, i) => {
        const charSpan = document.createElement("span");
        charSpan.textContent = char;
        charSpan.style.display = "inline-block";
        charSpan.style.opacity = 0;
        charSpan.style.transform = "translateY(10px)";
        charSpan.style.transition = "all 0.3s ease";
        wordSpan.appendChild(charSpan);

        setTimeout(() => {
          charSpan.style.opacity = 1;
          charSpan.style.transform = "translateY(0)";
        }, delay);

        delay += 70; // jeda antar huruf
      });
    });
  }, 1000);

  // 🔹 Toggle password
  const toggle = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");
  const icon = toggle.querySelector("i");

  // kondisi awal
  passwordInput.type = "password";
  icon.classList.remove("bi-eye");
  icon.classList.add("bi-eye-slash");

  toggle.addEventListener("click", () => {
    const isVisible = passwordInput.type === "text";
    if (isVisible) {
      passwordInput.type = "password";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      passwordInput.type = "text";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  });
});
</script>

   
    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#show').click(function() {
                var passwordInput = $('#password');
                var passwordConfirmationInput = $('#password_confirmation');
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordConfirmationInput.attr('type', 'text');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordConfirmationInput.attr('type', 'password');
                }
            });
        });

    </script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
/>
</body>
</html>

{{-- @section('script')
    <script src="{{ asset('admin_assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin_assets/dist/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin_assets/dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#show').click(function() {
            var passwordInput = $('#password');
            var passwordConfirmationInput = $('#password_confirmation');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                passwordConfirmationInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
                passwordConfirmationInput.attr('type', 'password');
            }
        });
    });

</script>
<!--  core files -->
<script>
    $(document).ready(function() {
        const token = localStorage.getItem('token')
        $.ajax({
            url: "https://dev.mischool.id/api/user"
            , type: 'GET'
            , headers: {
                'Accept': 'application/json'
                , 'Authorization': 'Bearer ' + token
            , }
            , dataType: "JSON"
            , success: function(response) {
                if (response.data.role == 'head master') {
                    window.location.href = "https://school.mischool.id/dashboard"
                } else {
                    window.location.href = "https://school.mischool.id/login"
                }
            }
            , error: function(err) {
                $('.preloader').fadeOut()
            }
        })
        $('#form-login').submit(function(e) {
            e.preventDefault();
            $('.preloader').show()
            $.ajax({
                url: "https://dev.mischool.id/api/login"
                , type: "POST"
                , headers: {
                    'Accept': 'application/json'
                , }
                , data: $(this).serialize()
                , success: function(response) {
                    $('.preloader').fadeOut()
                    console.log(response.data.user.role);
                    if (response.data.user.role === 'head master' ||
                        response.data.user.role === 'admin school') {
                        localStorage.setItem('token', response.data.token)
                        $('#token').val(response.data.token)
                        $('#save-token').submit()
                    } else {
                        $('#failed-login').html('Email Atau Password Tidak Sesuai')
                        $('#password').val('');
                        $('.preloader').fadeOut()
                    }
                }
                , error: function(response) {
                    $('.preloader').fadeOut()
                    var response = response.responseJSON
                    var status = response.meta.code
                    if (status == 422) {
                        handleValidate(response.data)
                        $('#password').val('');
                    } else if (status == 400) {
                        $('#failed-login').html(response.meta.message)
                        $('#password').val('');
                    } else if (status == 403) {
                        $('#failed-login').html(response.meta.message)
                        $('#password').val('');
                    } else {
                        $('#failed-login').html('Error tidak diketahui')
                    }

                }
            })
        })
    })

    function handleValidate(messages) {
        const keys = Object.keys(messages);
        for (const key of keys) {
            const text = messages[key];
            var ErrorList = $('<li>').text(text[0])
            let inputElement = $(`#${key}`)
            inputElement.addClass('error')
            inputElement.next('ul').prepend(ErrorList)
        }

        $('.error').change(function() {
            $(this).removeClass('error')
            $(this).next('ul').html('')
        })
    }

</script>
@endsection --}}
