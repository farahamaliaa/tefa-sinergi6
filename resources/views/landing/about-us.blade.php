@extends('layouts.landing.layouts-landing')

@section('style')
    @include('landing.partials.styles')
    
    <style>
        .about-image-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .about-image-wrapper img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transform: rotate(2deg);
            transition: all 0.5s ease;
        }

        .about-image-wrapper:hover img {
            transform: rotate(0deg) scale(1.02);
            box-shadow: 0 30px 60px rgba(37, 99, 235, 0.15);
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.1);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .stat-desc {
            font-size: 0.9rem;
            color: #64748b;
        }

        .feature-list-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .feature-list-item:hover {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transform: translateX(10px);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .page-header {
            text-align: center;
            padding: 180px 0 80px;
            background: radial-gradient(circle at top center, rgba(37,99,235,0.05) 0%, transparent 70%);
        }
    </style>
@endsection

@section('content')

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<div class="page-header">
    <div class="container">
        <span class="hero-label">Tentang Kami</span>
        <h1 class="hero-title" style="font-size: 3.5rem;">Mengenal Lebih Dekat <br> Sinergi6</h1>
        <p class="hero-desc" style="margin: 0 auto;">Platform manajemen sekolah modern yang didedikasikan untuk transformasi pendidikan Indonesia.</p>
    </div>
</div>

<section class="section-padding" style="padding-bottom: 100px;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title">Solusi Cerdas untuk <br> Sekolah Modern</h2>
                <p class="section-desc mb-4">
                    Sinergi6 adalah platform manajemen sekolah komprehensif yang dirancang untuk menyederhanakan kompleksitas administrasi pendidikan. Dengan fitur-fitur canggih mulai dari absensi digital hingga pelaporan akademik, kami membantu sekolah beroperasi lebih efisien.
                </p>
                <p class="section-desc mb-5">
                    Kami melayani empat pilar utama ekosistem sekolah: Admin, Guru, Staff, dan Siswa. Masing-masing mendapatkan akses ke fitur yang dipersonalisasi untuk meningkatkan produktivitas dan transparansi.
                </p>
                
                <a href="#features" class="btn-glow text-decoration-none">Pelajari Fitur</a>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-image-wrapper">
                    <img src="{{ asset('landing_assets/images/landing/about-2.png') }}" class="img-fluid" alt="About Sinergi6">
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding: 100px 0; background: #f8fafc;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-number">4+</div>
                    <div class="stat-label">Sekolah Mitra</div>
                    <div class="stat-desc">Sekolah unggulan yang telah mempercayakan manajemen digitalnya kepada kami.</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-number">98+</div>
                    <div class="stat-label">Guru Aktif</div>
                    <div class="stat-desc">Pendidik yang terbantu dalam proses presensi dan jurnal mengajar setiap harinya.</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Siswa Terdaftar</div>
                    <div class="stat-desc">Siswa yang merasakan kemudahan akses informasi dan presensi digital.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" style="padding: 120px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <img src="{{ asset('landing_assets/images/landing/about-3.png') }}" class="img-fluid" alt="Why Choose Us" style="transform: rotate(-2deg);">
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <span class="hero-label">Keunggulan Kami</span>
                <h2 class="section-title">Mengapa Memilih <br> Sinergi6?</h2>
                <p class="section-desc mb-5">Kami tidak sekadar membuat aplikasi, kami membangun ekosistem digital yang memahami kebutuhan sekolah.</p>
                
                <div class="feature-list">
                    <div class="feature-list-item">
                        <div class="feature-icon"><i class="icofont-ui-touch-phone"></i></div>
                        <div><strong>Kemudahan Penggunaan</strong><br><small class="text-muted">Antarmuka intuitif untuk semua kalangan pengguna.</small></div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon"><i class="icofont-users-social"></i></div>
                        <div><strong>Multi-Role Access</strong><br><small class="text-muted">Hak akses spesifik untuk Guru, Staff, Siswa & Admin.</small></div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon"><i class="icofont-chart-bar-graph"></i></div>
                        <div><strong>Laporan Real-time</strong><br><small class="text-muted">Data kehadiran dan jurnal terupdate secara langsung.</small></div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon"><i class="icofont-shield-alt"></i></div>
                        <div><strong>Keamanan Data</strong><br><small class="text-muted">Infrastruktur aman untuk melindungi data sensitif sekolah.</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
