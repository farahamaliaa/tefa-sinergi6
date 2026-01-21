@extends('layouts.landing.layouts-landing')

@section('style')
    @include('landing.partials.styles')
    
    <style>
        .contact-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.1);
            border-color: var(--primary);
        }
        
        .contact-icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(139,92,246,0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--primary);
            font-size: 2rem;
            transition: all 0.3s;
        }

        .contact-card:hover .contact-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            background: var(--primary);
            color: white;
        }

        .contact-label {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .contact-text {
            color: #64748b;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .contact-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .contact-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .modern-form-wrapper {
            background: white;
            padding: 50px;
            border-radius: 24px;
            box-shadow: 0 20px 60px -10px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
        }

        .form-control-modern {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 1rem;
            color: var(--dark);
            width: 100%;
            transition: all 0.3s;
        }

        .form-control-modern:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .page-header {
            text-align: center;
            padding: 180px 0 60px;
            background: radial-gradient(circle at top center, rgba(37,99,235,0.05) 0%, transparent 70%);
        }
    </style>
@endsection

@section('content')

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<div class="page-header">
    <div class="container">
        <span class="hero-label">Hubungi Kami</span>
        <h1 class="hero-title" style="font-size: 3.5rem;">Mari Terhubung dengan <br> Sinergi6</h1>
        <p class="hero-desc" style="margin: 0 auto;">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda kapan saja.</p>
    </div>
</div>

<section style="padding: 60px 0 100px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <i class="icofont-email"></i>
                    </div>
                    <h3 class="contact-label">Email Support</h3>
                    <p class="contact-text">Kirimkan pertanyaan Anda melalui email, kami akan membalas secepatnya.</p>
                    <a href="mailto:info@hummatech.com" class="contact-link">info@hummatech.com</a>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <i class="icofont-location-pin"></i>
                    </div>
                    <h3 class="contact-label">Kunjungi Kami</h3>
                    <p class="contact-text">Datang langsung ke kantor pusat kami untuk konsultasi lebih lanjut.</p>
                    <a href="https://maps.app.goo.gl/7e2rM6FNLSsX7M379" target="_blank" class="contact-link">Lihat di Google Maps</a>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <i class="icofont-phone"></i>
                    </div>
                    <h3 class="contact-label">Telepon</h3>
                    <p class="contact-text">Butuh bantuan mendesak? Hubungi layanan pelanggan kami.</p>
                    <a href="tel:085176777785" class="contact-link">0851-7677-7785</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding-bottom: 120px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="modern-form-wrapper" data-aos="fade-up">
                    <div class="text-center mb-5">
                        <h2 class="section-title">Kirim Pesan</h2>
                        <p class="section-desc">Silakan isi formulir di bawah ini, kami akan segera merespon pesan Anda.</p>
                    </div>

                    <form action="{{ route('store.send.email') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-secondary">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control-modern" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-secondary">Email</label>
                                    <input type="email" name="email" class="form-control-modern" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-secondary">Pesan</label>
                                    <textarea name="description" class="form-control-modern" style="height: 180px; resize: none;" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button class="btn-glow" type="submit" style="min-width: 200px;">
                                    Kirim Pesan <i class="icofont-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
