<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RusiaLearn — Belajar Bahasa Rusia dari Nol untuk Penutur Indonesia</title>
<meta name="description" content="Belajar bahasa Rusia dari nol dengan metode terstruktur. Kuasai 33 huruf Cyrillic, kosakata inti, dan tata bahasa melalui spaced repetition. Gratis dan mudah diakses.">
<meta name="theme-color" content="#2D3F31">

<!-- Open Graph / Social Media -->
<meta property="og:title" content="RusiaLearn — Belajar Bahasa Rusia dari Nol">
<meta property="og:description" content="Kuasai 33 huruf Cyrillic, kosakata inti, dan tata bahasa Rusia dengan metode belajar yang dirancang khusus untuk penutur Indonesia.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://rusialearn.id/">
<meta property="og:image" content="https://rusialearn.id/og-image.jpg">
<link rel="icon" href="New folder\favicon.svg">

<!-- Google Fonts: Anton + Inter + Poppins (Niskala Style) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Caveat:wght@400;600&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

<!-- Tailwind CSS via CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        cream: '#F5F0E1',
        sand: '#E8DCC4',
        kraft: '#EDE3CC',
        canopy: '#2D3F31',
        moss: '#4A5D4A',
        leaf: '#7A8B6F',
        dew: '#A8B89E',
        bark: '#6B5444',
        clay: '#C4956A',
        rose: '#D88B96',
        amber: '#D4A04E',
        charcoal: '#2A2620',
        mist: '#6B6357',
        twig: '#C9B89A',
      },
      fontFamily: {
        anton: ['Anton', 'Impact', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
        caveat: ['Caveat', 'cursive'],
      },
      borderRadius: {
        squircle: '28px',
      },
    },
  },
};
</script>

<style>
  :root {
    --c-bg-base: #F5F0E1;
    --c-bg-warm: #E8DCC4;
    --c-bg-paper: #EDE3CC;
    --c-green-deep: #2D3F31;
    --c-green-primary: #4A5D4A;
    --c-green-soft: #7A8B6F;
    --c-green-mist: #A8B89E;
    --c-wood: #6B5444;
    --c-terracotta: #C4956A;
    --c-accent-rose: #D88B96;
    --c-accent-amber: #D4A04E;
    --c-text-primary: #2A2620;
    --c-text-muted: #6B6357;
    --c-border-soft: #C9B89A;
    --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }
  
  html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
  }
  
  body {
    background-color: var(--c-bg-base);
    color: var(--c-text-primary);
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  h1, h2, h3 { font-family: 'Anton', sans-serif; letter-spacing: 0.02em; text-transform: uppercase; }
  a { color: inherit; text-decoration: none; }
  
  /* Aksesibilitas: Fokus keyboard yang jelas */
  a:focus-visible, button:focus-visible {
    outline: 2px solid var(--c-green-primary);
    outline-offset: 4px;
    border-radius: 4px;
  }

  .wrap { max-width: 1080px; margin: 0 auto; padding: 0 24px; }

  /* NAV */
  nav {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(245, 240, 225, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(201, 184, 154, 0.4);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    max-width: 1080px;
    margin: 0 auto;
    transition: all 0.3s ease;
  }
  
  nav.scrolled {
    box-shadow: 0 4px 20px rgba(45, 63, 49, 0.08);
  }
  
  .logo { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.25rem; text-transform: lowercase; letter-spacing: -0.02em; color: var(--c-green-deep); }
  .logo span { color: var(--c-accent-amber); }
  
  nav .cta-small {
    border: 1px solid var(--c-green-primary);
    padding: 10px 20px;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.25s var(--ease-out);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--c-green-primary);
  }
  nav .cta-small:hover {
    background: var(--c-green-primary);
    color: var(--c-bg-base);
    transform: scale(1.02);
  }

  /* HERO */
  .hero { 
    padding: 80px 24px 100px; 
    position: relative; 
    overflow: hidden;
    background: linear-gradient(180deg, #F5F0E1 0%, #E8DCC4 45%, #A8B89E 100%);
  }
  .hero-inner { max-width: 1080px; margin: 0 auto; position: relative; }
  
  .eyebrow {
    color: var(--c-accent-amber);
    font-weight: 700;
    font-size: 0.8rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    margin-bottom: 18px;
    font-family: 'Inter', sans-serif;
  }
  
  .hero h1 {
    font-size: clamp(2.2rem, 5.5vw, 3.7rem);
    font-weight: 400;
    line-height: 1.1;
    max-width: 820px;
    letter-spacing: -0.01em;
    color: var(--c-green-deep);
  }
  .hero h1 em { font-style: normal; color: var(--c-accent-amber); }
  
  .hero p {
    margin-top: 22px;
    font-size: 1.08rem;
    color: var(--c-text-muted);
    max-width: 520px;
  }
  
  .hero-cta { margin-top: 34px; display: flex; gap: 14px; flex-wrap: wrap; }
  
  .btn-primary {
    background: var(--c-green-primary);
    color: #F5F0E1;
    font-weight: 700;
    padding: 15px 32px;
    border-radius: 9999px;
    font-size: 0.95rem;
    transition: all 0.25s var(--ease-out);
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    box-shadow: 0 4px 14px rgba(74, 93, 74, 0.25);
  }
  .btn-primary:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 28px rgba(74, 93, 74, 0.35);
    background: var(--c-green-deep);
  }
  
  .btn-ghost {
    border: 1px solid var(--c-border-soft);
    padding: 15px 28px;
    border-radius: 9999px;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.25s var(--ease-out);
    color: var(--c-text-primary);
    background: rgba(237, 227, 204, 0.6);
  }
  .btn-ghost:hover {
    border-color: var(--c-green-primary);
    color: var(--c-green-primary);
    background: transparent;
  }

  /* CYRILLIC RIBBON */
  .ribbon-wrap {
    margin-top: 72px;
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: none;
    -ms-overflow-style: none;
    -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
  }
  .ribbon-wrap::-webkit-scrollbar { display: none; }
  
  .ribbon { display: flex; gap: 12px; min-width: max-content; padding: 0 4px; }
  
  .letter {
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid var(--c-border-soft);
    border-radius: 16px;
    width: 64px; height: 64px;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    cursor: default;
    transition: all 0.3s var(--ease-out);
    user-select: none;
    backdrop-filter: blur(4px);
  }
  .letter:hover {
    border-color: var(--c-accent-amber);
    transform: translateY(-6px);
    box-shadow: 0 10px 30px rgba(212, 160, 78, 0.2);
    background: white;
  }
  .letter .cyr { font-family: 'Anton', sans-serif; font-weight: 400; font-size: 1.4rem; color: var(--c-green-deep); }
  .letter .lat {
    position: absolute; bottom: -26px; left: 50%; transform: translateX(-50%);
    font-size: 0.72rem; color: var(--c-accent-amber); opacity: 0; transition: all 0.3s var(--ease-out);
    white-space: nowrap; font-weight: 700; font-family: 'Inter', sans-serif;
  }
  .letter:hover .lat { opacity: 1; bottom: -24px; }
  
  .ribbon-caption { margin-top: 42px; font-size: 0.85rem; color: var(--c-text-muted); }

  /* SECTION */
  section { padding: 80px 24px; }
  .section-head { max-width: 560px; margin-bottom: 52px; }
  .section-head .eyebrow { margin-bottom: 14px; }
  .section-head h2 { font-size: clamp(1.6rem, 3.5vw, 2.3rem); font-weight: 400; line-height: 1.2; color: var(--c-green-deep); }
  .section-head p { color: var(--c-text-muted); margin-top: 14px; }

  .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; max-width: 1080px; margin: 0 auto; }
  
  .card {
    background: rgba(255, 255, 255, 0.75);
    border: 1px solid var(--c-border-soft);
    border-radius: 28px;
    padding: 32px 28px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.35s ease;
    backdrop-filter: blur(4px);
  }
  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(74, 93, 74, 0.15);
    border-color: var(--c-green-soft);
    background: rgba(255, 255, 255, 0.9);
  }
  .card .num { font-family: 'Inter', sans-serif; color: var(--c-accent-amber); font-size: 0.85rem; font-weight: 700; margin-bottom: 18px; letter-spacing: 0.05em; text-transform: uppercase; }
  .card h3 { font-size: 1.15rem; font-weight: 400; margin-bottom: 10px; color: var(--c-green-deep); font-family: 'Anton', sans-serif; letter-spacing: 0.02em; }
  .card p { color: var(--c-text-muted); font-size: 0.94rem; }

  /* STAT STRIP */
  .stats { 
    border-top: 1px solid var(--c-border-soft); 
    border-bottom: 1px solid var(--c-border-soft);
    background: linear-gradient(180deg, rgba(232, 220, 196, 0.5) 0%, rgba(168, 184, 158, 0.2) 100%);
  }
  .stats-inner { max-width: 1080px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); }
  .stat { padding: 44px 24px; text-align: center; border-right: 1px solid var(--c-border-soft); }
  .stat:last-child { border-right: none; }
  .stat .n { font-family: 'Anton', sans-serif; font-size: 2.1rem; font-weight: 400; color: var(--c-accent-amber); }
  .stat .l { color: var(--c-text-muted); font-size: 0.85rem; margin-top: 8px; }

  /* CTA FOOTER */
  .cta-final { 
    text-align: center; 
    padding: 100px 24px; 
    background: linear-gradient(180deg, rgba(168, 184, 158, 0.2) 0%, #F5F0E1 100%);
  }
  .cta-final h2 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 400; max-width: 600px; margin: 0 auto; line-height: 1.15; color: var(--c-green-deep); }
  .cta-final p { color: var(--c-text-muted); margin: 18px auto 34px; max-width: 440px; }

  footer { 
    border-top: 1px solid var(--c-border-soft); 
    padding: 32px 24px; 
    text-align: center; 
    color: var(--c-text-muted); 
    font-size: 0.85rem;
    background: var(--c-bg-warm);
  }

  /* SCROLL REVEAL ANIMATION */
  .reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.7s var(--ease-out), transform 0.7s var(--ease-out);
  }
  .reveal.visible {
    opacity: 1;
    transform: translateY(0);
  }

  /* RESPONSIVE */
  @media (max-width: 760px) {
    .grid { grid-template-columns: 1fr; }
    .stats-inner { grid-template-columns: 1fr; }
    .stat { border-right: none; border-bottom: 1px solid var(--c-border-soft); }
    .stat:last-child { border-bottom: none; }
    .hero { padding: 48px 24px 64px; }
    .nav .cta-small { padding: 8px 16px; font-size: 0.78rem; }
  }

  @media (prefers-reduced-motion: reduce) {
    * { transition: none !important; animation: none !important; }
    html { scroll-behavior: auto; }
  }
</style>
</head>
<body>

<nav id="navbar">
  <div class="logo">Русия<span>Learn</span></div>
  <a href="login.php" class="cta-small" aria-label="Masuk ke akun RusiaLearn">Masuk</a>
</nav>

<main>
  <header class="hero">
    <div class="hero-inner">
      <div class="eyebrow reveal">Untuk Penutur Indonesia</div>
      <h1 class="reveal">Baca, dengar, dan bicara Rusia — <em>mulai dari huruf Cyrillic-nya sendiri.</em></h1>
      <p class="reveal">RusiaLearn menyusun jalur belajar dari alfabet, kosakata inti dengan spaced repetition, sampai kuis harian. Tanpa buku tebal, tanpa kelas mahal.</p>
      <div class="hero-cta reveal">
        <a href="register.php" class="btn-primary">Mulai Belajar Gratis</a>
        <a href="#cara-kerja" class="btn-ghost">Lihat Cara Kerjanya</a>
      </div>

      <div class="ribbon-wrap reveal">
        <div class="ribbon">
          <div class="letter"><span class="cyr">А</span><span class="lat">A</span></div>
          <div class="letter"><span class="cyr">Б</span><span class="lat">B</span></div>
          <div class="letter"><span class="cyr">В</span><span class="lat">V</span></div>
          <div class="letter"><span class="cyr">Г</span><span class="lat">G</span></div>
          <div class="letter"><span class="cyr">Д</span><span class="lat">D</span></div>
          <div class="letter"><span class="cyr">Ж</span><span class="lat">Zh</span></div>
          <div class="letter"><span class="cyr">З</span><span class="lat">Z</span></div>
          <div class="letter"><span class="cyr">И</span><span class="lat">I</span></div>
          <div class="letter"><span class="cyr">Й</span><span class="lat">Y</span></div>
          <div class="letter"><span class="cyr">К</span><span class="lat">K</span></div>
          <div class="letter"><span class="cyr">Л</span><span class="lat">L</span></div>
          <div class="letter"><span class="cyr">П</span><span class="lat">P</span></div>
          <div class="letter"><span class="cyr">Р</span><span class="lat">R</span></div>
          <div class="letter"><span class="cyr">Ф</span><span class="lat">F</span></div>
          <div class="letter"><span class="cyr">Ш</span><span class="lat">Sh</span></div>
          <div class="letter"><span class="cyr">Я</span><span class="lat">Ya</span></div>
        </div>
      </div>
      <div class="ribbon-caption reveal">Arahkan kursor ke tiap huruf — semua 33 huruf Cyrillic tersedia di aplikasi.</div>
    </div>
  </header>

  <section id="cara-kerja">
    <div class="section-head reveal">
      <div class="eyebrow">Sistem Belajar</div>
      <h2>Tiga tahap, satu alur yang saling menguatkan</h2>
      <p>Setiap tahap dibangun di atas tahap sebelumnya — bukan materi lepas-lepas.</p>
    </div>
    <div class="grid">
      <div class="card reveal">
        <div class="num">Tahap 01</div>
        <h3>Alfabet Cyrillic</h3>
        <p>Kenali 33 huruf, bunyi, dan cara menulisnya sebelum masuk ke kata — fondasi yang sering dilewati kursus lain.</p>
      </div>
      <div class="card reveal" style="transition-delay: 100ms;">
        <div class="num">Tahap 02</div>
        <h3>Kosakata dengan Spaced Repetition</h3>
        <p>Kata muncul kembali tepat sebelum kamu lupa, jadi hafalan nempel lama tanpa drilling berulang-ulang.</p>
      </div>
      <div class="card reveal" style="transition-delay: 200ms;">
        <div class="num">Tahap 03</div>
        <h3>Kuis & Latihan Ringan</h3>
        <p>Uji pemahaman lewat kuis singkat dan progres yang terlihat, tanpa tekanan skor atau leaderboard yang bikin capek.</p>
      </div>
    </div>
  </section>

  <div class="stats reveal">
    <div class="stats-inner">
      <div class="stat"><div class="n">33</div><div class="l">Huruf Cyrillic diajarkan lengkap</div></div>
      <div class="stat"><div class="n">100%</div><div class="l">Materi dan instruksi berbahasa Indonesia</div></div>
      <div class="stat"><div class="n">0</div><div class="l">Materi berbayar untuk mulai belajar</div></div>
    </div>
  </div>

  <section class="cta-final" id="mulai">
    <div class="eyebrow reveal" style="display:flex;justify-content:center;">Mulai Sekarang</div>
    <h2 class="reveal">Huruf pertama hari ini, kalimat pertama minggu ini.</h2>
    <p class="reveal">Daftar gratis dan langsung mulai dari alfabet — tidak perlu kartu kredit.</p>
    <a href="register.php" class="btn-primary reveal">Buat Akun Gratis</a>
  </section>
</main>

<footer>
  © <span id="year">2026</span> RusiaLearn — Belajar Bahasa Rusia untuk Penutur Indonesia
</footer>

<script>
  // Update tahun secara dinamis
  document.getElementById('year').textContent = new Date().getFullYear();

  // Navbar scroll effect
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // Scroll Reveal Animation
  document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target); 
        }
      });
    }, { 
      threshold: 0.1,
      rootMargin: '0px 0px -40px 0px'
    });

    document.querySelectorAll('.reveal').forEach(el => {
      observer.observe(el);
    });
  });
</script>

</body>
</html>
