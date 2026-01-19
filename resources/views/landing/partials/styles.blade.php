<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #2563eb;
        --primary-dark: #1e3a8a;
        --accent: #8b5cf6;
        --dark: #0f172a;
        --light: #f8fafc;
        --text: #334155;
    }

    body,
    .page_wrapper {
        font-family: 'Outfit', sans-serif !important;
        color: var(--text);
        background-color: #ffffff !important;
        background-image: none !important;
        overflow-x: hidden;
    }

    .top_home_wraper {
        background: transparent !important;
    }

    .bg-shape {
        position: absolute;
        z-index: 0;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.6;
        pointer-events: none;
    }

    .shape-1 {
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        top: -200px;
        right: -100px;
    }

    .shape-2 {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        top: 200px;
        left: -150px;
    }

    .hero-section {
        padding: 160px 0 100px;
        position: relative;
        z-index: 1;
    }

    .hero-label {
        color: var(--primary);
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.9rem;
        margin-bottom: 15px;
        display: block;
    }

    .hero-title {
        font-weight: 800;
        color: var(--dark);
        font-size: 4rem;
        line-height: 1.1;
        margin-bottom: 25px;
        letter-spacing: -1px;
    }

    .hero-desc {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 40px;
        line-height: 1.6;
        max-width: 500px;
    }

    .btn-glow {
        background: #0896D1 !important;
        color: white !important;
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        /* box-shadow: 0 10px 25px -5px rgba(8, 150, 209, 0.4); */
        transition: all 0.3s ease;
        border: none;
        display: inline-block;
    }

    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(8, 150, 209, 0.5);
    }

    .btn-video {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        color: var(--primary);
        font-size: 1.2rem;
        margin-left: 20px;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .btn-video:hover {
        transform: scale(1.1);
        color: var(--primary);
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        font-weight: 800;
        color: var(--dark);
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .section-desc {
        color: #64748b;
        font-size: 1.1rem;
    }
</style>
