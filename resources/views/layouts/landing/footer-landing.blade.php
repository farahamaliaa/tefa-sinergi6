<footer style="background-color: #0f172a; color: #94a3b8; font-family: 'Outfit', sans-serif; position: relative; overflow: hidden; margin-top: 0; z-index: 50;">
    
    <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 100%; height: 300px; background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, transparent 70%); pointer-events: none;"></div>

    <div class="top_footer" style="padding: 140px 0 60px; position: relative; z-index: 1;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="mb-4">
                        <img src="{{ asset('landing_assets/images/logo/sinergi6-white.png') }}" 
                             alt="Sinergi6 Logo" 
                             style="max-width: 160px; filter: brightness(0) invert(1);"> 
                    </div>
                    <p style="line-height: 1.7; margin-bottom: 24px;">
                        Platform manajemen sekolah modern yang membantu institusi pendidikan beralih ke era digital dengan mudah dan aman.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-social"><i class="icofont-facebook"></i></a>
                        <a href="#" class="footer-social"><i class="icofont-twitter"></i></a>
                        <a href="https://www.instagram.com/mischool.id/" class="footer-social"><i class="icofont-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 ml-lg-auto">
                    <h5 style="color: white; margin-bottom: 24px; font-weight: 600; font-size: 1.1rem;">Menu</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li class="mb-3"><a href="{{ route('beranda') }}" class="footer-link">Beranda</a></li>
                        <li class="mb-3"><a href="{{ route('about-us') }}" class="footer-link">Tentang Kami</a></li>
                        <li class="mb-3"><a href="{{ route('contact-us') }}" class="footer-link">Kontak</a></li>
                        <li class="mb-3"><a href="/login" class="footer-link">Login</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 style="color: white; margin-bottom: 24px; font-weight: 600; font-size: 1.1rem;">Fitur Utama</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li class="mb-3"><a href="#" class="footer-link">Absensi Digital</a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Manajemen Staff</a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Jurnal Kelas</a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Laporan Akademik</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 style="color: white; margin-bottom: 24px; font-weight: 600; font-size: 1.1rem;">Hubungi Kami</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li class="d-flex mb-3 align-items-start">
                            <i class="icofont-location-pin text-primary mt-1 mr-3"></i>
                            <span style="font-size: 0.95rem;">Jl. PB.Sudirman, Tanggul Kulon, Jember, Jawa Timur 68155</span>
                        </li>
                        <li class="d-flex mb-3 align-items-center">
                            <i class="icofont-phone text-primary mr-3"></i>
                            <a href="tel:+62336441347" class="footer-link">(0336) 441347</a>
                        </li>
                        <li class="d-flex mb-3 align-items-center">
                            <i class="icofont-email text-primary mr-3"></i>
                            <a href="mailto:smkn6.jember@yahoo.com" class="footer-link">smkn6.jember@yahoo.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_footer" style="background-color: #0b1120; padding: 25px 0; border-top: 1px solid rgba(255,255,255,0.05); position: relative; z-index: 1;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                    <p class="mb-0 small">&copy; {{ date('Y') }} Sinergi6. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <span class="mr-2 small text-muted">Powered by:</span>
                    <a href="https://www.smkn6jember.sch.id/" target="_blank" class="d-inline-block align-middle ml-2 opacity-75 hover-opacity-100">
                        <img src="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" alt="SMKN 6 Jember" style="height: 24px; width: auto;">
                    </a>
                    <span class="mx-2 text-muted x-separator">×</span>
                    <a href="https://hummatech.com/" target="_blank" class="d-inline-block align-middle opacity-75 hover-opacity-100">
                        <img src="{{ asset('landing_assets/images/logo/LOGO-HUMMATECH_Putih.png') }}" alt="Hummatech" style="height: 20px; width: auto;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }
        .footer-link:hover {
            color: #ffffff;
            transform: translateX(5px);
            text-decoration: none;
        }
        .footer-social {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }
        .footer-social:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        .hover-opacity-100:hover { opacity: 1 !important; }
    </style>
</footer>
