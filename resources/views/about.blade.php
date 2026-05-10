<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Eagle Academy | أكاديمية الملاكمة الأولى</title>
    <meta name="description" content="The Eagle Academy - أكاديمية النسر للملاكمة. تدريب احترافي على يد أمهر المدربين. انضم الآن!">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --gold: #f1c40f; --dark: #0a0a0a; --card: #141414; }
        body { font-family: 'Cairo', sans-serif; background: var(--dark); color: #fff; overflow-x: hidden; }
        
        /* Navbar */
        .navbar { position: fixed; top: 15px; left: 50%; transform: translateX(-50%); width: 92%; max-width: 1200px; z-index: 100; padding: 12px 30px; display: flex; justify-content: space-between; align-items: center; background: rgba(8,8,12,0.4); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); border-radius: 50px; transition: all 0.5s ease; }
        .navbar.scrolled { background: rgba(8,8,12,0.9); padding: 10px 30px; border-color: rgba(241,196,15,0.12); box-shadow: 0 8px 32px rgba(0,0,0,0.5); }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-brand img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(241,196,15,0.6); transition: all 0.3s; box-shadow: 0 0 15px rgba(241,196,15,0.15); }
        .navbar.scrolled .nav-brand img { width: 34px; height: 34px; }
        .nav-brand span { font-size: 1.05rem; font-weight: 900; color: #fff; letter-spacing: 2px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .nav-links { display: flex; gap: 5px; align-items: center; }
        .nav-links a { color: rgba(255,255,255,0.75); text-decoration: none; font-weight: 600; transition: all 0.3s; font-size: 0.88rem; padding: 8px 16px; border-radius: 8px; }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-links a.active { color: var(--gold); background: rgba(241,196,15,0.08); }
        .nav-cta { background: rgba(241,196,15,0.15); color: var(--gold); padding: 9px 22px; border-radius: 10px; font-weight: 800; text-decoration: none; transition: all 0.3s; font-size: 0.88rem; border: 1px solid rgba(241,196,15,0.3); backdrop-filter: blur(10px); }
        .nav-cta:hover { background: var(--gold); color: #000; transform: translateY(-2px); box-shadow: 0 6px 25px rgba(241,196,15,0.3); }
        .nav-hamburger { display: none; cursor: pointer; flex-direction: column; gap: 5px; padding: 5px; }
        .nav-hamburger span { width: 24px; height: 2.5px; background: var(--gold); border-radius: 3px; transition: all 0.3s; }
        .nav-hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
        .nav-hamburger.open span:nth-child(2) { opacity: 0; }
        .nav-hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

        /* Scroll Animations */
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(50px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .reveal-scale { opacity: 0; transform: scale(0.85); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        /* Hero */
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; position: relative; background: url('/images/team.jpg') center/cover no-repeat; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.7) 40%, rgba(0,0,0,0.85) 100%); }
        .hero::after { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(241,196,15,0.08) 0%, transparent 70%); top: 50%; left: 50%; transform: translate(-50%, -50%); animation: pulse 4s ease-in-out infinite; }
        @keyframes pulse { 0%,100% { transform: translate(-50%,-50%) scale(1); opacity: 0.5; } 50% { transform: translate(-50%,-50%) scale(1.3); opacity: 1; } }
        .hero-content { position: relative; z-index: 2; padding: 20px; }
        .hero-badge { display: inline-block; background: rgba(241,196,15,0.1); border: 1px solid rgba(241,196,15,0.3); padding: 8px 20px; border-radius: 30px; color: var(--gold); font-weight: 700; font-size: 0.9rem; margin-bottom: 20px; animation: fadeInDown 1s; }
        .hero h1 { font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; line-height: 1.2; margin-bottom: 20px; animation: fadeInUp 1s; }
        .hero h1 span { color: var(--gold); display: block; }
        .hero p { font-size: 1.2rem; color: #94a3b8; max-width: 600px; margin: 0 auto 30px; animation: fadeInUp 1.2s; }
        .hero-btns { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; animation: fadeInUp 1.4s; }
        .btn-primary { background: var(--gold); color: #000; padding: 14px 32px; border-radius: 10px; font-weight: 800; text-decoration: none; font-size: 1.1rem; transition: all 0.3s; }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(241,196,15,0.3); }
        .btn-outline { border: 2px solid rgba(255,255,255,0.2); color: #fff; padding: 14px 32px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 1.1rem; transition: all 0.3s; }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes logoGlow { 0%,100% { box-shadow: 0 0 40px rgba(241,196,15,0.3), 0 0 80px rgba(241,196,15,0.1); } 50% { box-shadow: 0 0 60px rgba(241,196,15,0.5), 0 0 120px rgba(241,196,15,0.2); } }

        /* Stats */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 900px; margin: -60px auto 0; position: relative; z-index: 10; padding: 0 20px; }
        .stat-card { background: var(--card); border: 1px solid rgba(241,196,15,0.1); border-radius: 16px; padding: 25px; text-align: center; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-5px); border-color: var(--gold); box-shadow: 0 10px 30px rgba(241,196,15,0.1); }
        .stat-num { font-size: 2.5rem; font-weight: 900; color: var(--gold); }
        .stat-label { color: #94a3b8; font-size: 0.9rem; margin-top: 5px; }

        /* Sections */
        section { padding: 80px 20px; }
        .section-title { text-align: center; margin-bottom: 50px; }
        .section-title h2 { font-size: 2.2rem; font-weight: 900; margin-bottom: 10px; }
        .section-title h2 span { color: var(--gold); }
        .section-title p { color: #94a3b8; font-size: 1rem; }

        /* Features */
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; max-width: 1100px; margin: 0 auto; }
        .feature-card { background: var(--card); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 30px; transition: all 0.4s; }
        .feature-card:hover { transform: translateY(-8px); border-color: rgba(241,196,15,0.3); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .feature-icon { font-size: 2.5rem; margin-bottom: 15px; }
        .feature-card h3 { color: var(--gold); margin-bottom: 10px; font-size: 1.2rem; }
        .feature-card p { color: #94a3b8; font-size: 0.95rem; line-height: 1.7; }

        /* Gallery */
        .gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; max-width: 1100px; margin: 0 auto; }
        .gallery-item { border-radius: 16px; overflow: hidden; position: relative; aspect-ratio: 1; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .gallery-item:hover img { transform: scale(1.1); }
        .gallery-item::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%); opacity: 0; transition: opacity 0.3s; }
        .gallery-item:hover::after { opacity: 1; }
        .gallery-item:first-child { grid-column: span 2; grid-row: span 2; }

        /* Schedule */
        .schedule-section { background: linear-gradient(180deg, var(--dark) 0%, #1a1a2e 100%); }
        .schedule-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; max-width: 800px; margin: 0 auto; }
        .schedule-card { background: var(--card); border: 1px solid rgba(241,196,15,0.15); border-radius: 16px; padding: 30px; text-align: center; }
        .schedule-card h3 { color: var(--gold); font-size: 1.3rem; margin-bottom: 15px; }
        .schedule-days { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; margin-bottom: 15px; }
        .day-badge { background: rgba(241,196,15,0.1); color: var(--gold); padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; }
        .schedule-time { font-size: 2rem; font-weight: 900; color: #fff; }

        /* Social */
        .social-links { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        .social-btn { display: flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1rem; transition: all 0.3s; }
        .social-btn:hover { transform: translateY(-4px); }
        .social-fb { background: rgba(66,103,178,0.15); color: #4267B2; border: 1px solid rgba(66,103,178,0.3); }
        .social-fb:hover { background: #4267B2; color: #fff; box-shadow: 0 10px 25px rgba(66,103,178,0.3); }
        .social-ig { background: rgba(225,48,108,0.15); color: #E1306C; border: 1px solid rgba(225,48,108,0.3); }
        .social-ig:hover { background: #E1306C; color: #fff; box-shadow: 0 10px 25px rgba(225,48,108,0.3); }
        .social-tk { background: rgba(255,255,255,0.08); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
        .social-tk:hover { background: #fff; color: #000; box-shadow: 0 10px 25px rgba(255,255,255,0.2); }

        /* FAQ */
        .faq-container { max-width: 800px; margin: 0 auto; }
        .faq-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; margin-bottom: 12px; overflow: hidden; transition: all 0.3s; }
        .faq-item:hover { border-color: rgba(241,196,15,0.15); }
        .faq-item.open { border-color: rgba(241,196,15,0.25); background: rgba(241,196,15,0.03); }
        .faq-question { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; cursor: pointer; font-weight: 700; font-size: 1.05rem; color: #e2e8f0; transition: color 0.3s; }
        .faq-question:hover { color: var(--gold); }
        .faq-item.open .faq-question { color: var(--gold); }
        .faq-arrow { font-size: 1.2rem; transition: transform 0.3s; color: var(--gold); }
        .faq-item.open .faq-arrow { transform: rotate(180deg); }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; }
        .faq-item.open .faq-answer { max-height: 300px; }
        .faq-answer p { padding: 0 24px 20px; color: #94a3b8; line-height: 1.8; font-size: 0.95rem; }

        /* Videos */
        .videos-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1100px; margin: 0 auto; }
        .video-card { border-radius: 16px; overflow: hidden; background: var(--card); border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s; }
        .video-card:hover { transform: translateY(-5px); border-color: rgba(241,196,15,0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
        .video-card iframe { width: 100%; aspect-ratio: 9/16; display: block; }
        .video-card.landscape iframe { aspect-ratio: 16/9; }

        /* Scroll Progress Bar */
        .progress-container { position: fixed; top: 0; left: 0; width: 100%; height: 4px; background: transparent; z-index: 1001; }
        .progress-bar { height: 100%; background: var(--gold); width: 0%; box-shadow: 0 0 10px var(--gold); }

        /* Testimonials */
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; max-width: 1100px; margin: 0 auto; }
        .testi-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; padding: 30px; transition: all 0.3s; position: relative; }
        .testi-card:hover { transform: translateY(-10px); border-color: rgba(241,196,15,0.2); background: rgba(241,196,15,0.02); }
        .testi-quote { font-size: 2.5rem; color: rgba(241,196,15,0.2); position: absolute; top: 15px; right: 20px; font-family: serif; }
        .testi-text { font-size: 0.95rem; line-height: 1.8; color: #cbd5e1; margin-bottom: 20px; position: relative; z-index: 1; }
        .testi-user { display: flex; align-items: center; gap: 12px; }
        .testi-avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--gold); display: flex; align-items: center; justify-content: center; font-weight: 900; color: #000; font-size: 1.1rem; }
        .testi-info h4 { font-size: 1rem; margin-bottom: 2px; color: #fff; }
        .testi-info span { font-size: 0.8rem; color: #64748b; }

        /* Floating WhatsApp */
        .floating-wa { position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #25D366; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; box-shadow: 0 10px 25px rgba(37,211,102,0.4); z-index: 999; text-decoration: none; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .floating-wa:hover { transform: scale(1.1) rotate(10deg); box-shadow: 0 15px 35px rgba(37,211,102,0.5); }

        /* Lightbox */
        .lightbox { position: fixed; inset: 0; background: rgba(0,0,0,0.95); z-index: 2000; display: none; align-items: center; justify-content: center; cursor: pointer; padding: 20px; backdrop-filter: blur(10px); }
        .lightbox img { max-width: 90%; max-height: 90%; border-radius: 12px; box-shadow: 0 0 50px rgba(0,0,0,0.5); transform: scale(0.9); transition: transform 0.3s; }
        .lightbox.active { display: flex; }
        .lightbox.active img { transform: scale(1); }

        /* CTA */
        .cta-section { text-align: center; background: linear-gradient(135deg, rgba(241,196,15,0.05) 0%, transparent 100%); border-top: 1px solid rgba(241,196,15,0.1); border-bottom: 1px solid rgba(241,196,15,0.1); }
        .cta-section h2 { font-size: 2rem; margin-bottom: 15px; }
        .cta-section p { color: #94a3b8; margin-bottom: 30px; font-size: 1.1rem; }

        /* Footer */
        footer { text-align: center; padding: 30px; color: #64748b; font-size: 0.85rem; border-top: 1px solid rgba(255,255,255,0.05); }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar { padding: 10px 15px; }
            .nav-hamburger { display: flex; }
            .nav-links { display: none; position: fixed; top: 60px; left: 0; right: 0; background: rgba(10,10,10,0.98); backdrop-filter: blur(20px); flex-direction: column; padding: 20px; gap: 5px; border-bottom: 1px solid rgba(241,196,15,0.1); }
            .nav-links.open { display: flex; animation: fadeInDown 0.3s; }
            .nav-links a { padding: 12px 16px; font-size: 1rem; }
            .nav-cta { display: none; }
            .stats { grid-template-columns: repeat(2, 1fr); margin-top: -40px; }
            .gallery { grid-template-columns: 1fr 1fr; }
            .gallery-item:first-child { grid-column: span 2; grid-row: span 1; aspect-ratio: 16/9; }
            .schedule-grid { grid-template-columns: 1fr; }
            .social-links { flex-direction: column; align-items: center; }
            .videos-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .floating-wa { bottom: 20px; right: 20px; width: 50px; height: 50px; font-size: 24px; }
            #videos > div:last-child { grid-template-columns: 1fr 1fr !important; }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .videos-grid { grid-template-columns: repeat(2, 1fr); }
            .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            #videos > div:last-child { grid-template-columns: repeat(2, 1fr) !important; }
        }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body>

<div class="progress-container">
    <div class="progress-bar" id="progressBar"></div>
</div>

<!-- Navbar -->
<nav class="navbar" id="mainNav">
    <a href="#" class="nav-brand">
        <img src="/logo.jpg" alt="Logo">
        <span>THE EAGLE ACADEMY</span>
    </a>
    <div class="nav-links" id="navLinks">
        <a href="#about">من نحن</a>
        <a href="#features">مميزاتنا</a>
        <a href="#coach">المدرب</a>
        <a href="#gallery">معرض الصور</a>
        <a href="#schedule">المواعيد</a>
        <a href="#contact">تواصل معنا</a>
    </div>
    <a href="{{ route('portal.index') }}" class="nav-cta">بوابة اللاعبين</a>
    <div class="nav-hamburger" id="hamburger" onclick="this.classList.toggle('open'); document.getElementById('navLinks').classList.toggle('open');">
        <span></span><span></span><span></span>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-content">
        <img src="/logo.jpg" alt="The Eagle Academy Logo" style="display: block; margin: 0 auto 30px; width: 250px; height: 250px; border-radius: 50%; object-fit: cover; border: 4px solid var(--gold); box-shadow: 0 0 40px rgba(241,196,15,0.3), 0 0 80px rgba(241,196,15,0.1); animation: fadeInDown 0.8s, logoGlow 3s ease-in-out infinite;">
        <h1>اصنع بطلاً<span>THE EAGLE ACADEMY</span></h1>
        <p>أكاديمية النسر للملاكمة — تدريب احترافي للأبطال من جميع الأعمار. نبني الأجسام، نصقل المهارات، ونزرع الانضباط. 🦅</p>
        <div class="hero-btns">
            <a href="https://wa.me/201229189647?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20%D9%8A%D8%A7%20%D9%83%D8%A7%D8%A8%D8%AA%D9%86%D8%8C%20%D8%A3%D9%86%D8%A7%20%D9%85%D9%87%D8%AA%D9%85%20%D8%A8%D8%A7%D9%84%D8%A3%D9%83%D8%A7%D8%AF%D9%8A%D9%85%D9%8A%D8%A9%20%D9%88%D8%B9%D8%A7%D9%8A%D8%B2%20%D8%A3%D8%B9%D8%B1%D9%81%20%D8%A3%D9%83%D8%AA%D8%B1%20%D8%B9%D9%86%20%D8%A7%D9%84%D9%85%D9%88%D8%A7%D8%B9%D9%8A%D8%AF%20%D9%88%D8%A7%D9%84%D8%A3%D9%85%D8%A7%D9%83%D9%86%20%D9%88%D8%A7%D9%84%D8%A7%D8%B4%D8%AA%D8%B1%D8%A7%D9%83%D8%A7%D8%AA" target="_blank" class="btn-primary">سجّل الآن 🥊</a>
            <a href="#about" class="btn-outline">اعرف أكثر</a>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="stats">
    <div class="stat-card reveal" style="transition-delay:0.1s"><div class="stat-num" data-count="89">0</div><div class="stat-label">لاعب مسجل</div></div>
    <div class="stat-card reveal" style="transition-delay:0.2s"><div class="stat-num" data-count="45">0</div><div class="stat-label">بطولة ومشاركة</div></div>
    <div class="stat-card reveal" style="transition-delay:0.3s"><div class="stat-num" data-count="6">0</div><div class="stat-label">أيام تدريب أسبوعياً</div></div>
    <div class="stat-card reveal" style="transition-delay:0.4s"><div class="stat-num" data-count="3">0</div><div class="stat-label">سنوات خبرة</div></div>
</div>

<!-- About -->
<section id="about">
    <div class="section-title">
        <h2>من نحن <span>؟</span></h2>
        <p>The Eagle Academy for Boxing — سمنود، محافظة الغربية</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🥊</div>
            <h3>أكاديمية ملاكمة متخصصة</h3>
            <p>أكاديمية النسر هي أول أكاديمية ملاكمة متخصصة في سمنود. تأسست بهدف بناء جيل من الملاكمين المحترفين على أسس علمية وتدريبية صحيحة تحت إشراف الاتحاد المصري للملاكمة.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏅</div>
            <h3>إنجازات على مستوى الجمهورية</h3>
            <p>أبطال الأكاديمية يشاركون في بطولات الجمهورية وحققوا ميداليات ذهبية وفضية وبرونزية في فئات أوزان مختلفة. "سمنود بلد الأسود" — ده مش مجرد شعار، ده واقع بنثبته في كل بطولة.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👦</div>
            <h3>فئات من 6 سنين لحد الكبار</h3>
            <p>بنستقبل البراعم من سن 6 سنين والناشئين والشباب والكبار. كل فئة ليها برنامج تدريبي مخصص يتناسب مع سنها ومستواها البدني، مع متابعة مستمرة لتطور المستوى.</p>
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" style="background: linear-gradient(180deg, var(--dark) 0%, #0d1117 100%);">
    <div class="section-title">
        <h2>لماذا <span>النسر</span>؟</h2>
        <p>حاجات بتميزنا عن أي مكان تاني</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>نظام تقييم إلكتروني</h3>
            <p>كل لاعب له ملف شخصي رقمي بيتابع تطوره في 5 محاور: الفنيات، السرعة، الدفاع، اللياقة، والانضباط. ولي الأمر يقدر يتابع مستوى ابنه أول بأول من خلال بوابة إلكترونية بكود خاص.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚖️</div>
            <h3>متابعة الوزن والتغذية</h3>
            <p>الملاكمة رياضة أوزان، وعشان كده بنتابع وزن كل لاعب بشكل دوري ونسجله في النظام. ده بيساعدنا نحضر اللاعبين للبطولات في الوزن المثالي ونتجنب أي مشاكل صحية.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📅</div>
            <h3>6 أيام تدريب في الأسبوع</h3>
            <p>مجموعتين تدريب: (سبت - اتنين - أربع) الساعة 8 مساءً، و(حد - تلات - خميس) الساعة 6 مساءً. اختار الميعاد اللي يناسبك وابدأ فوراً.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎯</div>
            <h3>انضباط وروح قتالية</h3>
            <p>الملاكمة مش بس رياضة — دي أسلوب حياة بيعلم ابنك الانضباط والاحترام والثقة بالنفس والقدرة على مواجهة التحديات. بنبني شخصية البطل قبل ما نبني جسمه.</p>
        </div>
    </div>
</section>

<!-- Coach Section -->
<section id="coach" style="background: linear-gradient(180deg, #0d1117 0%, var(--dark) 100%);">
    <div class="section-title">
        <h2>المدرب <span>الرئيسي</span></h2>
    </div>
    <div style="max-width: 800px; margin: 0 auto; display: flex; align-items: center; gap: 40px; flex-wrap: wrap; justify-content: center;">
        <div style="flex-shrink: 0;">
            <img src="/images/coach.jpg" alt="الكابتن مروان الزفتاوي" style="width: 220px; height: 220px; border-radius: 50%; object-fit: cover; border: 4px solid var(--gold); box-shadow: 0 0 30px rgba(241,196,15,0.2);">
        </div>
        <div style="flex: 1; min-width: 280px;">
            <h3 style="color: var(--gold); font-size: 1.8rem; margin-bottom: 5px;">كابتن مروان الزفتاوي</h3>
            <p style="color: #94a3b8; font-size: 1rem; margin-bottom: 8px;">مؤسس ومدرب The Eagle Academy</p>
            <div style="background: rgba(241,196,15,0.08); border: 1px solid rgba(241,196,15,0.15); border-radius: 12px; padding: 15px; margin-bottom: 20px;">
                <p style="color: #dfe6e9; font-size: 0.95rem; line-height: 1.8; margin: 0;">مدرب ملاكمة معتمد من الاتحاد المصري للملاكمة. أسس أكاديمية النسر في سمنود بهدف نشر رياضة الملاكمة وبناء جيل من الأبطال. قاد لاعبيه لتحقيق ميداليات على مستوى الجمهورية في فئات مختلفة.</p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="https://www.instagram.com/marawan_elzeftawy1?igsh=MWd2ZXNkeWhrb3B2MA==" target="_blank" style="display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: rgba(225,48,108,0.12); border: 1px solid rgba(225,48,108,0.25); border-radius: 10px; color: #E1306C; text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: all 0.3s;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    Instagram
                </a>
                <a href="https://www.facebook.com/share/1GxvhtaRP2/?mibextid=wwXIfr" target="_blank" style="display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: rgba(66,103,178,0.12); border: 1px solid rgba(66,103,178,0.25); border-radius: 10px; color: #4267B2; text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: all 0.3s;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Gallery -->
<section id="gallery">
    <div class="section-title">
        <h2>معرض <span>الصور</span></h2>
        <p>لقطات من تدريبات وبطولات أبطالنا</p>
    </div>
    <div class="gallery">
        <div class="gallery-item"><img src="/images/team.jpg" alt="فريق الأكاديمية"></div>
        <div class="gallery-item"><img src="/images/champion1.jpg" alt="بطل الأكاديمية في البطولة"></div>
        <div class="gallery-item"><img src="/images/medal.jpg" alt="ميدالية بطولة الجمهورية"></div>
        <div class="gallery-item"><img src="/images/ring.jpg" alt="التتويج على الحلبة"></div>
        <div class="gallery-item"><img src="/images/fighters.jpg" alt="أبطال الأكاديمية"></div>
        <div class="gallery-item"><img src="/images/certificate.jpg" alt="شهادة الاتحاد المصري للملاكمة"></div>
        <div class="gallery-item"><img src="/images/kids_team.jpg" alt="فريق البراعم"></div>
        <div class="gallery-item"><img src="/images/gym_fighters.jpg" alt="تدريبات الملاكمين"></div>
        <div class="gallery-item"><img src="/images/gym_group.jpg" alt="فريق التدريب"></div>
        <div class="gallery-item"><img src="/images/tournament_group.jpg" alt="مشاركة في بطولة"></div>
    </div>
</section>

<!-- Videos -->
<section id="videos" style="background: linear-gradient(180deg, var(--dark) 0%, #0d1117 100%);">
    <div class="section-title">
        <h2>شوف <span>تدريباتنا</span></h2>
        <p>فيديوهات من داخل الأكاديمية والبطولات</p>
    </div>

    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <!-- Instagram Reel 1 -->
        <div class="reveal" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(225,48,108,0.15); box-shadow: 0 10px 40px rgba(0,0,0,0.2); transition-delay: 0s;">
            <iframe src="https://www.instagram.com/reel/DRcks2MDJgX/embed" style="width:100%; height:520px; border:none; display:block;" allowfullscreen></iframe>
        </div>
        <!-- Instagram Reel 2 -->
        <div class="reveal" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(225,48,108,0.15); box-shadow: 0 10px 40px rgba(0,0,0,0.2); transition-delay: 0.15s;">
            <iframe src="https://www.instagram.com/reel/DVweEiADDQ7/embed" style="width:100%; height:520px; border:none; display:block;" allowfullscreen></iframe>
        </div>
        <!-- Instagram Reel 3 -->
        <div class="reveal" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(225,48,108,0.15); box-shadow: 0 10px 40px rgba(0,0,0,0.2); transition-delay: 0.3s;">
            <iframe src="https://www.instagram.com/reel/DX4iTecM8j6/embed" style="width:100%; height:520px; border:none; display:block;" allowfullscreen></iframe>
        </div>
        <!-- TikTok Profile -->
        <div class="reveal" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06); box-shadow: 0 10px 40px rgba(0,0,0,0.2); transition-delay: 0.45s;">
            <iframe src="https://www.tiktok.com/embed/@the.eagle.acadmey" style="width:100%; height:520px; border:none; display:block;" allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq">
    <div class="section-title">
        <h2>أسئلة <span>شائعة</span></h2>
        <p>كل اللي محتاج تعرفه قبل ما تسجّل</p>
    </div>
    <div class="faq-container">
        <div class="faq-item reveal">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>إيه السن المناسب للتسجيل في الأكاديمية؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>بنقبل من سن 6 سنين (براعم) لحد الكبار. كل فئة عمرية ليها برنامج تدريبي مخصص يناسب سنها ومستواها البدني. مفيش سن متأخر — الملاكمة للكل!</p>
            </div>
        </div>
        <div class="faq-item reveal" style="transition-delay:0.1s">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>كام الاشتراك الشهري؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>الاشتراك بيختلف حسب الفئة والمكان. تواصل معانا على الواتساب وهنديك كل التفاصيل والأسعار. الأسعار مناسبة جداً مقارنة بمستوى التدريب!</p>
            </div>
        </div>
        <div class="faq-item reveal" style="transition-delay:0.2s">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>محتاج أجيب لبس أو معدات معينة؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>في البداية هتحتاج لبس رياضي مريح وحذاء رياضي بس. الأكاديمية بتوفر القفازات والمعدات في التدريب. بعد كده لو حبيت تجيب جوانتي خاص بيك هنساعدك تختار المناسب.</p>
            </div>
        </div>
        <div class="faq-item reveal" style="transition-delay:0.3s">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>إيه مواعيد التدريب؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>عندنا مجموعتين: المجموعة الأولى (سبت - اتنين - أربع) الساعة 8 مساءً، والمجموعة التانية (حد - تلات - خميس) الساعة 6 مساءً. اختار اللي يناسبك!</p>
            </div>
        </div>
        <div class="faq-item reveal" style="transition-delay:0.4s">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>هل فيه بطولات بتشاركوا فيها؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>أيوا! بنشارك في بطولات المنطقة وبطولات الجمهورية تحت إشراف الاتحاد المصري للملاكمة. أبطالنا حققوا ميداليات ذهبية وفضية وبرونزية على مستوى الجمهورية.</p>
            </div>
        </div>
        <div class="faq-item reveal" style="transition-delay:0.5s">
            <div class="faq-question" onclick="this.parentElement.classList.toggle('open')">
                <span>إزاي أقدر أتابع مستوى ابني؟</span>
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                <p>عندنا بوابة إلكترونية لأولياء الأمور. هتاخد كود خاص بابنك تقدر من خلاله تتابع التقييمات، سجل البطولات، تطور الوزن، وحالة الاشتراك — كل حاجة أونلاين!</p>
            </div>
        </div>
    </div>
</section>

<!-- Schedule -->
<section id="schedule" class="schedule-section">
    <div class="section-title">
        <h2>مواعيد <span>التدريب</span></h2>
        <p>اختار ميعادك المناسب وابدأ رحلتك مع النسر</p>
    </div>
    <div class="schedule-grid">
        <div class="schedule-card reveal-left">
            <div style="font-size: 2rem; margin-bottom: 10px;">🔴</div>
            <h3>المجموعة الأولى</h3>
            <div class="schedule-days">
                <span class="day-badge">SAT سبت</span><span class="day-badge">MON اتنين</span><span class="day-badge">WED أربع</span>
            </div>
            <div class="schedule-time">8:00 <span style="font-size:1rem;color:var(--gold)">مساءً</span></div>
        </div>
        <div class="schedule-card reveal-right">
            <div style="font-size: 2rem; margin-bottom: 10px;">🔵</div>
            <h3>المجموعة الثانية</h3>
            <div class="schedule-days">
                <span class="day-badge">SUN حد</span><span class="day-badge">TUE تلات</span><span class="day-badge">THU خميس</span>
            </div>
            <div class="schedule-time">6:00 <span style="font-size:1rem;color:var(--gold)">مساءً</span></div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" style="background: linear-gradient(180deg, #0a0a0a 0%, #0d1117 100%);">
    <div class="section-title">
        <h2>آراء <span>الأبطال والأهالي</span></h2>
        <p>فخورين بثقة أولياء الأمور واللاعبين في أكاديمية النسر</p>
    </div>
    <div class="testimonials-grid">
        <div class="testi-card reveal">
            <div class="testi-quote">"</div>
            <p class="testi-text">بصراحة فرق كبير جداً في انضباط ابني وشخصيته من يوم ما بدأ مع كابتن مروان. الملاكمة مش مجرد رياضة هنا، دي تربية وأخلاق قبل أي حاجة.</p>
            <div class="testi-user">
                <div class="testi-avatar">أ</div>
                <div class="testi-info">
                    <h4>أحمد محمد</h4>
                    <span>ولي أمر لاعب (براعم)</span>
                </div>
            </div>
        </div>
        <div class="testi-card reveal" style="transition-delay:0.15s">
            <div class="testi-quote">"</div>
            <p class="testi-text">أحسن مكان تدرب فيه ملاكمة في سمنود. الكابتن مروان بيشرح الفنيات بدقة وبيهتم بكل لاعب كأنه ابنه. والسيستم الإلكتروني بيخليني متابع مستوى ابني لحظة بلحظة.</p>
            <div class="testi-user">
                <div class="testi-avatar">م</div>
                <div class="testi-info">
                    <h4>محمود إبراهيم</h4>
                    <span>ولي أمر لاعب (ناشئين)</span>
                </div>
            </div>
        </div>
        <div class="testi-card reveal" style="transition-delay:0.3s">
            <div class="testi-quote">"</div>
            <p class="testi-text">بدأت من الصفر ودلوقتي شاركت في أول بطولة ليا وحققت مركز. الأكاديمية وفرتلي كل الدعم النفسي والبدني عشان أكون ملاكم حقيقي.</p>
            <div class="testi-user">
                <div class="testi-avatar">ف</div>
                <div class="testi-info">
                    <h4>فارس أحمد</h4>
                    <span>ملاكم (شباب)</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA & Contact -->
<section id="contact" style="background: linear-gradient(180deg, #0d1117 0%, var(--dark) 100%);">
    <div class="section-title">
        <h2>تواصل <span>معنا</span></h2>
        <p>تابعنا على السوشيال ميديا أو ابعتلنا على الواتساب</p>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        <!-- Social Buttons -->
        <div class="social-links" style="margin-bottom: 50px;">
            <a href="https://www.facebook.com/share/1BTDAdd2ur/?mibextid=wwXIfr" target="_blank" class="social-btn social-fb">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </a>
            <a href="https://www.instagram.com/the_eagle_academy_?igsh=NnJza3A0YjNrYWM0" target="_blank" class="social-btn social-ig">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                Instagram
            </a>
            <a href="https://www.tiktok.com/@the.eagle.acadmey" target="_blank" class="social-btn social-tk">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-.88-5.64v-3.5a6.37 6.37 0 105.25 6.27V9.84a8.2 8.2 0 004.73 1.49V7.88a4.85 4.85 0 01-1-.19z"/></svg>
                TikTok
            </a>
            <a href="https://wa.me/201229189647?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20%D9%8A%D8%A7%20%D9%83%D8%A7%D8%A8%D8%AA%D9%86%D8%8C%20%D8%A3%D9%86%D8%A7%20%D9%85%D9%87%D8%AA%D9%85%20%D8%A8%D8%A7%D9%84%D8%A3%D9%83%D8%A7%D8%AF%D9%8A%D9%85%D9%8A%D8%A9%20%D9%88%D8%B9%D8%A7%D9%8A%D8%B2%20%D8%A3%D8%B9%D8%B1%D9%81%20%D8%A3%D9%83%D8%AA%D8%B1%20%D8%B9%D9%86%20%D8%A7%D9%84%D9%85%D9%88%D8%A7%D8%B9%D9%8A%D8%AF%20%D9%88%D8%A7%D9%84%D8%A3%D9%85%D8%A7%D9%83%D9%86%20%D9%88%D8%A7%D9%84%D8%A7%D8%B4%D8%AA%D8%B1%D8%A7%D9%83%D8%A7%D8%AA" target="_blank" class="social-btn" style="background:rgba(37,211,102,0.12); color:#25D366; border:1px solid rgba(37,211,102,0.3);">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
            </a>
        </div>

        <!-- CTA Card -->
        <div class="reveal-scale" style="background: linear-gradient(135deg, rgba(241,196,15,0.08), rgba(241,196,15,0.02)); border: 1px solid rgba(241,196,15,0.15); border-radius: 20px; padding: 40px; text-align: center;">
            <h2 style="font-size: 1.8rem; margin-bottom: 10px;">جاهز تبدأ رحلتك مع النسر؟</h2>
            <p style="color: #94a3b8; margin-bottom: 25px; font-size: 1.05rem;">سجّل ابنك الآن وخليه يبدأ طريقه نحو البطولة</p>
            <a href="https://wa.me/201229189647?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20%D9%8A%D8%A7%20%D9%83%D8%A7%D8%A8%D8%AA%D9%86%D8%8C%20%D8%A3%D9%86%D8%A7%20%D9%85%D9%87%D8%AA%D9%85%20%D8%A8%D8%A7%D9%84%D8%A3%D9%83%D8%A7%D8%AF%D9%8A%D9%85%D9%8A%D8%A9%20%D9%88%D8%B9%D8%A7%D9%8A%D8%B2%20%D8%A3%D8%B9%D8%B1%D9%81%20%D8%A3%D9%83%D8%AA%D8%B1%20%D8%B9%D9%86%20%D8%A7%D9%84%D9%85%D9%88%D8%A7%D8%B9%D9%8A%D8%AF%20%D9%88%D8%A7%D9%84%D8%A3%D9%85%D8%A7%D9%83%D9%86%20%D9%88%D8%A7%D9%84%D8%A7%D8%B4%D8%AA%D8%B1%D8%A7%D9%83%D8%A7%D8%AA" target="_blank" class="btn-primary" style="display:inline-block; font-size: 1.15rem; padding: 16px 40px;">ابعتلنا على واتساب</a>
        </div>
    </div>
</section>

<!-- Location Map -->
<section id="location" style="background: linear-gradient(180deg, var(--dark) 0%, #0a0a0a 100%);">
    <div class="section-title">
        <h2>موقعنا على <span>الخريطة</span></h2>
        <p>📍 سمنود، أول الشحاتية بجانب التأمين الصحي — محافظة الغربية</p>
    </div>
    <div class="reveal-scale" style="max-width: 1000px; margin: 0 auto; border-radius: 20px; overflow: hidden; border: 1px solid rgba(241,196,15,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13659.22!2d31.25!3d30.97!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f7c0f6b0c0a0a1%3A0x0!2sSamanoud%2C%20Gharbia%20Governorate!5e0!3m2!1sar!2seg!4v1" 
            width="100%" height="400" style="border:0; display:block; filter: brightness(0.85) contrast(1.1) saturate(0.8);" 
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<!-- Footer -->
<footer style="border-top: 1px solid rgba(241,196,15,0.08); padding: 40px 20px;">
    <div style="max-width: 900px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <img src="/logo.jpg" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--gold);">
                <span style="color: var(--gold); font-weight: 800; font-size: 1rem;">THE EAGLE ACADEMY</span>
            </div>
            <p style="color: #64748b; font-size: 0.85rem;">© {{ date('Y') }} جميع الحقوق محفوظة</p>
        </div>
        <div style="text-align: left;">
            <p style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 4px;">📍 سمنود، أول الشحاتية بجانب التأمين الصحي</p>
            <p style="color: #94a3b8; font-size: 0.95rem;">📞 <a href="tel:+201229189647" style="color: var(--gold); text-decoration: none;">+20 12 29189647</a></p>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp -->
<a href="https://wa.me/201229189647?text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20%D9%8A%D8%A7%20%D9%83%D8%A7%D8%A8%D8%AA%D9%86%D8%8C%20%D8%A3%D9%86%D8%A7%20%D9%85%D9%87%D8%AA%D9%85%20%D8%A8%D8%A7%D9%84%D8%A3%D9%83%D8%A7%D8%AF%D9%8A%D9%85%D9%8A%D8%A9%20%D9%88%D8%B9%D8%A7%D9%8A%D8%B2%20%D8%A3%D8%B9%D8%B1%D9%81%20%D8%A3%D9%83%D8%AA%D8%B1%20%D8%B9%D9%86%20%D8%A7%D9%84%D9%85%D9%88%D8%A7%D8%B9%D9%8A%D8%AF%20%D9%88%D8%A7%D9%84%D8%A3%D9%85%D8%A7%D9%83%D9%86%20%D9%88%D8%A7%D9%84%D8%A7%D8%B4%D8%AA%D8%B1%D8%A7%D9%83%D8%A7%D8%AA" target="_blank" class="floating-wa">
    <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- Lightbox Overlay -->
<div class="lightbox" id="lightbox">
    <img src="" alt="Zoomed view">
</div>

<script>
// Scroll Progress
window.addEventListener('scroll', () => {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.getElementById('progressBar').style.width = scrolled + "%";
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 50);
});

// Gallery Lightbox
document.querySelectorAll('.gallery-item img').forEach(img => {
    img.addEventListener('click', () => {
        const lightbox = document.getElementById('lightbox');
        lightbox.querySelector('img').src = img.src;
        lightbox.classList.add('active');
    });
});
document.getElementById('lightbox').addEventListener('click', () => {
    document.getElementById('lightbox').classList.remove('active');
});

// Scroll reveal animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            // Counter animation for stats
            if (entry.target.querySelector('[data-count]')) {
                const num = entry.target.querySelector('[data-count]');
                const target = parseInt(num.dataset.count);
                let current = 0;
                const step = Math.ceil(target / 40);
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    num.textContent = current + '+';
                }, 30);
            }
        }
    });
}, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .feature-card, .gallery-item, .stat-card, .schedule-card, .social-btn, .testi-card, .faq-item, .video-card').forEach(el => {
    if (!el.classList.contains('reveal') && !el.classList.contains('reveal-left') && !el.classList.contains('reveal-right') && !el.classList.contains('reveal-scale')) {
        el.classList.add('reveal');
    }
    observer.observe(el);
});

// Active nav link on scroll
const sections = document.querySelectorAll('section[id]');
window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(sec => {
        if (window.scrollY >= sec.offsetTop - 200) current = sec.getAttribute('id');
    });
    document.querySelectorAll('.nav-links a').forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === '#' + current);
    });
});

// Close mobile menu on link click
document.querySelectorAll('.nav-links a').forEach(a => {
    a.addEventListener('click', () => {
        document.getElementById('navLinks').classList.remove('open');
        document.getElementById('hamburger').classList.remove('open');
    });
});
</script>

</body>
</html>
