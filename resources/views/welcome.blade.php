@extends('layouts.landing.layouts-landing')

@section('style')
    @include('landing.partials.styles')
    
    <style>
    .perspective-container {
        perspective: 1500px;
        position: relative;
        margin-top: -20px;
    }

    .hero-card-3d {
        transform: rotateY(-10deg) rotateX(5deg);
        transition: transform 0.5s ease;
        border-radius: 20px;
        box-shadow: -30px 30px 60px -10px rgba(0,0,0,0.15);
        border: 4px solid white;
        background: white;
        overflow: hidden;
    }
    
    .hero-card-3d:hover {
        transform: rotateY(-5deg) rotateX(2deg);
        box-shadow: -20px 20px 50px -10px rgba(0,0,0,0.2);
    }
    
    .hero-img {
        width: 100%;
        display: block;
        border-radius: 16px;
    }

    .float-widget {
        position: absolute;
        background: white;
        padding: 15px 20px;
        border-radius: 16px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10;
        animation: float 6s ease-in-out infinite;
    }
    
    .float-top-right {
        top: 40px;
        right: -30px;
        animation-delay: 1s;
    }
    
    .float-bottom-left {
        bottom: 60px;
        left: -40px;
        animation-delay: 2s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .features-section {
        padding: 120px 0;
        background: #ffffff;
    }
    
    .feature-card-hover {
        padding: 40px;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    
    .icon-blob {
        width: 64px;
        height: 64px;
        background: #eff6ff;
        color: var(--primary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 24px;
        transition: all 0.3s;
    }
    
    .feature-card-hover:hover .icon-blob {
        background: var(--primary);
        color: white;
        transform: scale(1.1) rotate(5deg);
    }

    .mobile-dual {
        background: linear-gradient(135deg, #0f172a 50%, #1e293b 50%);
        padding: 100px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .mobile-content h2 { font-weight: 800; font-size: 3rem; margin-bottom: 20px; }
    .mobile-content p { color: #94a3b8; font-size: 1.2rem; margin-bottom: 40px; }

    .partners-refined {
        padding: 80px 0 100px 0;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        position: relative;
        z-index: 10;
        overflow: hidden;
    }

    .partners-title {
        text-align: center;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
        margin-bottom: 40px;
    }

    .partner-logo-wrapper {
        background: white;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        margin: 0 10px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .partner-logo-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }

    .partner-logo-wrapper img {
        max-height: 50px;
        width: auto !important;
        filter: grayscale(100%);
        opacity: 0.6;
        transition: all 0.3s;
    }

    .partner-logo-wrapper:hover img {
        filter: grayscale(0%);
        opacity: 1;
    }

    @media (max-width: 991px) {
        .hero-title { font-size: 3rem; text-align: center; }
        .hero-desc { text-align: center; margin: 0 auto 30px; }
        .hero-btns { justify-content: center; }
        .perspective-container { perspective: none; margin-top: 50px; }
        .hero-card-3d { transform: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .hero-card-3d:hover { transform: none; }
        .float-widget { display: none; }
        .mobile-dual { background: #0f172a; }
        .mobile-dual .col-lg-6:last-child { margin-top: 50px; }
    }
</style>
@endsection

@section('content')

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="hero-label">Sistem Operasi Sekolah Generasi Baru</span>
                <h1 class="hero-title">
                    Kelola Sekolah <br> Seperti Perusahaan <br> Teknologi.
                </h1>
                <p class="hero-desc">
                    Rasakan kecepatan, kemudahan, dan kendali penuh dengan Sinergi6. 
                    Platform manajemen pendidikan modern yang terintegrasi.
                </p>
                <div class="d-flex align-items-center hero-btns">
                    <a href="{{ route('login') }}" class="btn-glow text-decoration-none">
                        Masuk Dashboard
                    </a>
                    <a href="#" class="btn-video">
                        <i class="icofont-play"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left">
                <div class="perspective-container">
                    <div class="float-widget float-top-right">
                        <div style="width: 10px; height: 10px; background: #22c55e; border-radius: 50%;"></div>
                        <span style="font-weight: 700; font-size: 0.9rem;">Kehadiran 98%</span>
                    </div>
                    
                    <div class="float-widget float-bottom-left">
                        <div class="d-flex align-items-center">
                            <i class="icofont-check-circled text-primary mr-2"></i>
                            <div>
                                <strong class="d-block" style="font-size: 0.8rem; line-height: 1.2;">Laporan Dibuat</strong>
                                <small class="text-muted" style="font-size: 0.7rem;">Baru saja</small>
                            </div>
                        </div>
                    </div>

                    <div class="hero-card-3d">
                        <img src="{{ asset('landing_assets/images/landing/dashboard_mockup.png') }}" class="hero-img" alt="Sinergi6 Dashboard">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 style="font-weight: 800; font-size: 2.5rem; color: #0f172a;">Didesain untuk Kecepatan</h2>
            </div>
            <div class="col-lg-6">
                <p style="font-size: 1.1rem; color: #64748b;">
                    Dikembangkan dengan teknologi yang sama dengan startup unicorn dunia. Cepat, handal, dan sangat mudah digunakan.
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card-hover">
                    <div class="icon-blob">
                        <i class="icofont-id-card"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Absensi RFID Pintar</h3>
                    <p class="text-secondary mb-0">Sistem kehadiran otomatis menggunakan kartu pelajar pintar (RFID). Cepat, akurat, dan anti-titip absen.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card-hover">
                    <div class="icon-blob" style="background: #f0fdf4; color: #16a34a;">
                        <i class="icofont-chart-growth"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Analitik Real-time</h3>
                    <p class="text-secondary mb-0">Visualisasi data langsung membantu Anda mengambil keputusan cerdas seketika.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card-hover">
                    <div class="icon-blob" style="background: #fdf4ff; color: #c026d3;">
                        <i class="icofont-smart-phone"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Mobile First</h3>
                    <p class="text-secondary mb-0">Aplikasi native untuk iOS dan Android memastikan Anda selalu terhubung di mana saja.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card-hover">
                    <div class="icon-blob" style="background: #fff7ed; color: #ea580c;">
                        <i class="icofont-teacher"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Jurnal Guru</h3>
                    <p class="text-secondary mb-0">Sistem jurnal digital dan penilaian yang memudahkan tugas harian para guru.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card-hover">
                    <div class="icon-blob" style="background: #ecfeff; color: #0891b2;">
                        <i class="icofont-users-social"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Manajemen Staff</h3>
                    <p class="text-secondary mb-0">Kelola Jabatan, izin, dan kinerja staff dari satu pusat komando yang efisien.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card-hover">
                    <div class="icon-blob" style="background: #f5f3ff; color: #7c3aed;">
                        <i class="icofont-shield-alt"></i>
                    </div>
                    <h3 style="font-weight: 700; font-size: 1.25rem; margin-bottom: 10px;">Keamanan Enkripsi</h3>
                    <p class="text-secondary mb-0">Data sensitif sekolah aman dengan enkripsi tingkat bank yang terpercaya.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mobile-dual">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mobile-content" data-aos="fade-right">
                <h2>Sinergi6 dalam <br> <span class="text-primary">Genggaman Anda.</span></h2>
                <p>Seluruh ekosistem Sinergi6 dioptimalkan untuk smartphone Anda. Input nilai, absensi, dan cek jadwal pelajaran secara instan.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" style="background: white; color: black; padding: 12px 24px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; text-decoration: none; margin-right: 15px;">
                        <i class="icofont-brand-apple mr-2" style="font-size: 24px;"></i> App Store
                    </a>
                    <a href="#" style="background: transparent; border: 2px solid rgba(255,255,255,0.2); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; text-decoration: none;">
                        <i class="icofont-brand-android-robot mr-2" style="font-size: 24px;"></i> Play Store
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="{{ asset('landing_assets/images/landing/about.png') }}" style="max-width: 80%; transform: rotate(-5deg); border-radius: 30px; box-shadow: 0 50px 100px -20px rgba(0,0,0,0.5); border: 4px solid #334155;" alt="App Mockup">
            </div>
        </div>
    </div>
</section>

@if(isset($schools) && count($schools) > 0)
<section class="partners-refined">
    <div class="container">
        <div class="partners-title">DIPERCAYA OLEH SEKOLAH UNGGULAN</div>
        <div class="owl-carousel owl-theme" id="company_slider">
            @foreach($schools as $school)
            <div class="item">
                <div class="partner-logo-wrapper">
                    <img src="{{ 'https://mischool.mijurnal.com/storage/' . $school['logo'] }}" alt="Logo Sekolah">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@section('script')
<script>
    $(document).ready(function() {
        if($('#company_slider').length) {
            $('#company_slider').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 2500,
                responsive: {
                    0: { items: 2 },
                    600: { items: 3 },
                    1000: { items: 5 }
                }
            });
        }
        
        const card = document.querySelector('.hero-card-3d');
        const container = document.querySelector('.perspective-container');
        
        if(container && card) {
            container.addEventListener('mousemove', (e) => {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 30;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 30;
                card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });
            
            container.addEventListener('mouseleave', () => {
                card.style.transform = `rotateY(-10deg) rotateX(5deg)`;
            });
        }
    });
</script>
@endsection
