<style>
    .navbar-dynamic {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 1280px;
        padding: 0 20px;
        z-index: 1000;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .navbar-pill {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); */
        border-radius: 100px;
        padding: 10px 30px;
        transition: all 0.4s ease;
    }

    .navbar-dynamic.scrolled {
        top: 10px;
        max-width: 900px;
    }

    .navbar-dynamic.scrolled .navbar-pill {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .navbar-brand img {
        height: 32px;
        width: auto;
    }

    .nav-link-dynamic {
        color: #334155 !important;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 8px 18px !important;
        border-radius: 20px;
        transition: all 0.2s;
    }

    .nav-link-dynamic:hover,
    .nav-link-dynamic.active {
        color: #0896D1 !important;
        background: #E0F0F7;
    }

    .btn-login-dynamic {
        background: #0896D1;
        color: white !important;
        padding: 10px 24px !important;
        border-radius: 50px;
        font-weight: 600;
        /* box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3); */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
    }

    .btn-login-dynamic:hover {
        /* background: #1d4ed8; */
        transform: translateY(-2px);
        /* box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4); */
    }

    @media (max-width: 991px) {
        .navbar-dynamic {
            top: 0;
            padding: 0;
            max-width: 100%;
        }

        .navbar-pill {
            border-radius: 0;
            padding: 15px 20px;
            background: white;
            border: none;
            border-bottom: 1px solid #f1f5f9;
        }

        .navbar-dynamic.scrolled {
            max-width: 100%;
            top: 0;
        }

        .navbar-collapse {
            margin-top: 15px;
            padding-bottom: 20px;
        }

        .btn-login-dynamic {
            width: 100%;
            margin-top: 10px;
            text-align: center;
        }
    }
</style>

<div class="navbar-dynamic">
    <nav class="navbar navbar-expand-lg navbar-pill">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('landing_assets/images/logo/sinergi6.png') }}" alt="Sinergi6">
        </a>

        <button class="navbar-toggler border-0 p-0" type="button" data-toggle="collapse" data-target="#landingNavbar">
            <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,...');">
                <i class="icofont-navigation-menu text-dark" style="font-size: 24px;"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="landingNavbar">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-link-dynamic {{ request()->routeIs('beranda') ? 'active' : '' }}"
                        href="{{ route('beranda') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-dynamic {{ request()->routeIs('about-us') ? 'active' : '' }}"
                        href="{{ route('about-us') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-dynamic {{ request()->routeIs('contact-us') ? 'active' : '' }}"
                        href="{{ route('contact-us') }}">Kontak</a>
                </li>
                <li class="nav-item ml-lg-2">
                    <a class="nav-link btn-login-dynamic" href="/login">
                        Masuk
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.navbar-dynamic');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>
