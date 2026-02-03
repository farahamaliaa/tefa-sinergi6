<footer style="background-color: #0f172a; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; position: relative; overflow: hidden; margin-top: 0; z-index: 50;">
    
    {{-- Removed the gradient div as per request --}}

    <div class="top_footer" style="padding: 100px 0 60px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="mb-4">
                        <img src="{{ asset('landing_assets/images/logo/sinergi6.png') }}" 
                             alt="Sinergi6 Logo" 
                             style="max-width: 150px;"> 
                    </div>
                    <p style="line-height: 1.8; margin-bottom: 24px; font-size: 1rem;">
                        Platform manajemen sekolah modern yang membantu institusi pendidikan beralih ke era digital dengan mudah, cepat, dan aman.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="footer-social"><i class="icofont-facebook"></i></a>
                        <a href="#" class="footer-social"><i class="icofont-twitter"></i></a>
                        <a href="https://www.instagram.com/mischool.id/" class="footer-social"><i class="icofont-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 ml-lg-auto">
                    <h6 class="footer-heading">Menu</h6>
                    <ul class="footer-menu">
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('about-us') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('contact-us') }}">Kontak</a></li>
                        <li><a href="/login">Login</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="footer-heading">Fitur Utama</h6>
                    <ul class="footer-menu">
                        <li><a href="#">Absensi Digital</a></li>
                        <li><a href="#">Manajemen Staff</a></li>
                        <li><a href="#">Jurnal Kelas</a></li>
                        <li><a href="#">Laporan Akademik</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Hubungi Kami</h6>
                    <ul class="footer-contact">
                        <li>
                            <i class="icofont-location-pin icon"></i>
                            <span>Jl. PB.Sudirman, Tanggul Kulon, Jember, Jawa Timur 68155</span>
                        </li>
                        <li>
                            <i class="icofont-phone icon"></i>
                            <a href="tel:+62336441347">(0336) 441347</a>
                        </li>
                        <li>
                            <i class="icofont-email icon"></i>
                            <a href="mailto:smkn6.jember@yahoo.com">smkn6.jember@yahoo.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                    <p class="mb-0 copyright-text">&copy; {{ date('Y') }} Sinergi6. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="powered-by-simple">
                        <span class="label">Powered by:</span>
                        <a href="https://www.smkn6jember.sch.id/" target="_blank" class="partner-logo">
                            <!-- <img src="{{ asset('landing_assets/images/logo/smkn-6-jember.png') }}" alt="SMKN 6 Jember"> -->
                            <img src="{{ asset('landing_assets/images/logo/smkn-6-jember-text.png') }}" alt="SMKN 6 Jember">
                        </a>
                        <span class="divider">×</span>
                        <a href="https://hummatech.com/" target="_blank" class="partner-logo">
                            <img src="{{ asset('landing_assets/images/logo/LOGO-HUMMATECH_Putih.png') }}" alt="Hummatech">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .footer-heading {
            color: white; 
            margin-bottom: 24px; 
            font-weight: 700; 
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .footer-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-menu li {
            margin-bottom: 15px;
        }

        .footer-menu li a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-block;
            font-size: 0.95rem;
        }

        .footer-menu li a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-contact li {
            position: relative;
            padding-left: 35px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-contact li .icon {
            position: absolute;
            left: 0;
            top: 4px;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .footer-contact li a {
            color: #94a3b8;
            text-decoration: none;
            transition: 0.2s;
        }

        .footer-contact li a:hover {
            color: white;
        }

        .footer-social {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%; /* Circle looks cleaner */
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }

        .footer-social:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .bottom_footer {
            background-color: transparent; 
            padding: 30px 0; 
        }

        .copyright-text {
            font-size: 0.9rem;
            color: #64748b;
        }

        .powered-by-simple {
            display: inline-flex;
            align-items: center;
        }

        .powered-by-simple .label {
            font-size: 0.8rem;
            color: #64748b;
            margin-right: 12px;
        }

        .powered-by-simple .partner-logo img {
            height: 22px;
            width: auto;
            opacity: 0.8;
            transition: 0.2s;
        }

        .powered-by-simple .partner-logo:hover img {
            opacity: 1;
        }

        .powered-by-simple .divider {
            margin: 0 12px;
            color: #475569;
            font-size: 1.2rem;
        }
    </style>
</footer>
