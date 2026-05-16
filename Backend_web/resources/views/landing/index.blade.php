@extends('layouts.guest')

@section('title', 'Simtor — Honda Jember')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Barlow+Condensed:wght@700;800;900&display=swap');

:root {
    --red:       #CC0000;
    --red-dark:  #A00000;
    --red-glow:  rgba(204,0,0,0.12);
    --white:     #FFFFFF;
    --gray-100:  #F4F4F4;
    --gray-200:  #E2E2E2;
    --gray-500:  #888888;
    --gray-700:  #444444;
    --dark:      #1A1A1A;
    --font-head: 'Barlow Condensed', sans-serif;
    --font-body: 'Poppins', sans-serif;
    --radius:    12px;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
    --shadow-md: 0 8px 32px rgba(0,0,0,0.10);
    --shadow-red:0 8px 32px rgba(204,0,0,0.22);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: var(--font-body); color: var(--dark); background: var(--white); overflow-x: hidden; }
a { text-decoration: none; color: inherit; }
img { max-width: 100%; display: block; }

/* ─── TOPBAR ─── */
.lp-topbar {
    background: var(--red);
    color: rgba(255,255,255,0.9);
    font-size: 12px; font-weight: 500;
    padding: 7px 2rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
}
.lp-topbar a { color: rgba(255,255,255,0.88); display:flex; align-items:center; gap:5px; transition: color .2s; }
.lp-topbar a:hover { color: #fff; }
.lp-topbar-left, .lp-topbar-right { display:flex; align-items:center; gap:1.4rem; }
.lp-topbar svg { width:13px; height:13px; fill:currentColor; flex-shrink:0; }

/* ─── NAVBAR ─── */
.lp-nav {
    position: sticky; top: 0; z-index: 200;
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
}
.lp-nav-inner {
    max-width: 1200px; margin: 0 auto;
    padding: 0 2rem; height: 68px;
    display: flex; align-items: center; gap: 1.5rem;
}
.lp-logo {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; flex-shrink: 0;
}
.lp-logo-mark {
    width: 40px; height: 40px; border-radius: 10px;
    background: var(--red);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-head); font-size: 22px; font-weight: 900; color: white;
    box-shadow: 0 3px 10px rgba(204,0,0,0.3);
}
.lp-logo-text {
    font-family: var(--font-head);
    font-size: 26px; font-weight: 900;
    color: var(--red); letter-spacing: -0.5px;
}
.lp-nav-links {
    display: flex; align-items: center; gap: 0;
    margin-left: auto; flex: 1; justify-content: center;
}
.lp-nav-links a {
    padding: 0 16px; height: 68px;
    display: flex; align-items: center;
    font-size: 14px; font-weight: 600;
    color: var(--dark); transition: color .2s; white-space: nowrap;
}
.lp-nav-links a:hover { color: var(--red); }
.lp-nav-btns { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

/* ─── BUTTONS ─── */
.btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 22px;
    font-family: var(--font-body); font-size: 14px; font-weight: 600;
    border-radius: 8px; cursor: pointer;
    transition: all .2s; border: none; outline: none; text-decoration: none;
}
.btn-red {
    background: var(--red); color: var(--white);
    box-shadow: 0 4px 14px rgba(204,0,0,0.3);
}
.btn-red:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(204,0,0,0.38); }
.btn-lg { padding: 14px 32px; font-size: 15px; border-radius: 10px; }
.btn-sm { padding: 8px 18px; font-size: 13px; }

/* ─── HERO ─── */
.lp-hero {
    position: relative; overflow: hidden;
    background: linear-gradient(140deg, #FAFAFA 0%, #F0F0F0 100%);
}
.lp-hero-bg {
    position: absolute; inset: 0; pointer-events: none;
    background-image:
        linear-gradient(rgba(204,0,0,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(204,0,0,0.05) 1px, transparent 1px);
    background-size: 56px 56px;
}
.lp-hero-bg::after {
    content: '';
    position: absolute; right: -100px; top: -80px;
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(204,0,0,0.07) 0%, transparent 70%);
}
.lp-hero-content {
    position: relative; z-index: 2;
    max-width: 1200px; margin: 0 auto;
    padding: 5rem 2rem;
}
.lp-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--red); color: white;
    font-size: 12px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase;
    padding: 6px 14px; border-radius: 30px; margin-bottom: 1.2rem;
}
.lp-hero-eyebrow::before {
    content: ''; width: 6px; height: 6px;
    background: rgba(255,255,255,0.8); border-radius: 50%;
    animation: blink 1.5s infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

.lp-hero-content h1 {
    font-family: var(--font-head);
    font-size: clamp(56px, 8vw, 96px);
    font-weight: 900; line-height: .92;
    letter-spacing: -1.5px; text-transform: uppercase;
    color: var(--dark); margin-bottom: 1.2rem;
}
.lp-hero-content h1 span { color: var(--red); }
.lp-hero-content > p {
    font-size: 15px; line-height: 1.75; color: var(--gray-500);
    max-width: 480px; margin-bottom: 2rem;
}
.lp-hero-btns { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 3.5rem; }

.lp-hero-stats {
    display: flex; gap: 3rem; flex-wrap: wrap;
    padding-top: 2rem; border-top: 1px solid var(--gray-200);
}
.lp-stat {}
.lp-stat-num {
    font-family: var(--font-head); font-size: 32px; font-weight: 900;
    color: var(--red); line-height: 1;
}
.lp-stat-label { font-size: 12px; color: var(--gray-500); font-weight: 500; margin-top: 3px; }

/* ─── SECTION BASE ─── */
.lp-features, .lp-how { max-width: 100%; }
.lp-section-title { text-align: center; margin-bottom: 3rem; }
.lp-section-title h2 {
    font-family: var(--font-head);
    font-size: clamp(30px, 4vw, 46px); font-weight: 900;
    text-transform: uppercase; letter-spacing: -.5px;
    color: var(--dark); margin-bottom: .5rem;
}
.lp-section-title p { font-size: 14px; color: var(--gray-500); max-width: 500px; margin: 0 auto; line-height: 1.7; }

/* ─── FEATURES ─── */
.lp-features { padding: 5rem 0; }
.lp-features .lp-section-title { max-width: 1200px; margin: 0 auto 3rem; padding: 0 2rem; }
.lp-features-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 1.5rem;
    max-width: 1200px; margin: 0 auto; padding: 0 2rem;
    perspective: 1000px;
}
.lp-feature-card {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 16px; padding: 2rem 1.8rem;
    position: relative; overflow: hidden;
    transition: transform .3s cubic-bezier(.22,.68,0,1.2), box-shadow .3s, border-color .3s;
    cursor: default;
}
.lp-feature-card::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(204,0,0,0.05) 0%, transparent 60%);
    opacity: 0; transition: opacity .3s; pointer-events: none;
}
.lp-feature-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    background: var(--red); transform: scaleX(0);
    transition: transform .3s ease; transform-origin: left;
}
.lp-feature-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 20px 50px rgba(204,0,0,0.10); border-color: rgba(204,0,0,0.2); }
.lp-feature-card:hover::before { opacity: 1; }
.lp-feature-card:hover::after { transform: scaleX(1); }

.lp-feature-icon {
    width: 50px; height: 50px;
    background: rgba(204,0,0,0.08); border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
    transition: transform .4s cubic-bezier(.22,.68,0,1.4), background .3s;
}
.lp-feature-icon svg { width: 24px; height: 24px; fill: var(--red); transition: fill .3s; }
.lp-feature-card:hover .lp-feature-icon { transform: scale(1.18) rotate(-4deg); background: var(--red); }
.lp-feature-card:hover .lp-feature-icon svg { fill: white; }

.simtor-card-label {
    display: inline-block; font-size: 11px; font-weight: 700;
    letter-spacing: .03em; color: var(--red);
    background: rgba(204,0,0,0.08); padding: 3px 10px; border-radius: 20px;
    margin-bottom: .6rem;
}
.lp-feature-card h3 { font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: .5rem; transition: color .2s; }
.lp-feature-card:hover h3 { color: var(--red); }
.lp-feature-card p { font-size: 13px; color: var(--gray-500); line-height: 1.65; }
.simtor-card-footer {
    margin-top: 1rem; font-size: 13px; font-weight: 500; color: var(--red);
    opacity: 0; transform: translateY(6px); transition: opacity .25s, transform .25s;
}
.lp-feature-card:hover .simtor-card-footer { opacity: 1; transform: translateY(0); }

/* ─── HOW TO USE ─── */
.lp-how { background: var(--gray-100); padding: 5rem 0; }
.lp-how .lp-section-title { max-width: 1200px; margin: 0 auto 3rem; padding: 0 2rem; }
.lp-steps {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 2rem; position: relative;
    max-width: 1200px; margin: 0 auto; padding: 0 2rem;
}
.lp-steps::before {
    content: ''; position: absolute; top: 38px; left: calc(16% + 2rem); right: calc(16% + 2rem); height: 2px;
    background: repeating-linear-gradient(90deg, var(--red) 0, var(--red) 8px, transparent 8px, transparent 20px);
}
.lp-step {
    background: var(--white); border: 1px solid var(--gray-200);
    border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
    position: relative; z-index: 1; transition: all .3s;
}
.lp-step:hover { transform: translateY(-4px); box-shadow: var(--shadow-red); border-color: rgba(204,0,0,0.25); }
.lp-step-num {
    width: 52px; height: 52px; border-radius: 50%;
    background: var(--red); color: white;
    font-family: var(--font-head); font-size: 26px; font-weight: 900;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.2rem; box-shadow: 0 6px 18px rgba(204,0,0,0.35);
}
.lp-step h4 { font-size: 15px; font-weight: 700; margin-bottom: .5rem; }
.lp-step p { font-size: 13px; color: var(--gray-500); line-height: 1.65; }

/* ─── CTA ─── */
.lp-cta {
    background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
    color: white; padding: 5rem 2rem; text-align: center;
    position: relative; overflow: hidden;
}
.lp-cta::before {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.07) 0%, transparent 50%),
                      radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
}
.lp-cta h2 {
    font-family: var(--font-head); font-size: clamp(34px, 5vw, 58px);
    font-weight: 900; letter-spacing: -1px; text-transform: uppercase;
    margin-bottom: 1rem; line-height: 1; position: relative;
}
.lp-cta p { font-size: 16px; opacity: .88; margin-bottom: 2rem; line-height: 1.6; position: relative; }
.lp-cta .btn-cta {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 16px 38px; background: white; color: var(--red);
    font-family: var(--font-body); font-size: 15px; font-weight: 700;
    border-radius: 10px; text-decoration: none;
    box-shadow: 0 8px 30px rgba(0,0,0,0.18);
    transition: all .2s; position: relative;
}
.lp-cta .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 14px 40px rgba(0,0,0,0.22); }

/* ─── FOOTER ─── */
.lp-footer {
    background: var(--dark);
    padding: 2.2rem 2rem;
}
.lp-footer-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.lp-footer-inner > p { font-size: 13px; color: rgba(255,255,255,0.45); }
.lp-footer-links { display: flex; gap: 1.4rem; }
.lp-footer-links a { font-size: 13px; color: rgba(255,255,255,0.45); transition: color .2s; }
.lp-footer-links a:hover { color: white; }

/* ─── ANIMATIONS ─── */
.fade-up { opacity: 0; transform: translateY(28px); animation: fadeUp .7s ease forwards; }
@keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
.delay-1 { animation-delay: .15s; }
.delay-2 { animation-delay: .3s; }
.delay-3 { animation-delay: .45s; }

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
    .lp-nav-links { display: none; }
    .lp-topbar-left { display: none; }
    .lp-features-grid { grid-template-columns: 1fr !important; }
    .lp-steps { grid-template-columns: 1fr; }
    .lp-steps::before { display: none; }
    .lp-hero-stats { gap: 1.5rem; }
    .lp-footer-inner { flex-direction: column; text-align: center; }
    .lp-footer-links { flex-wrap: wrap; justify-content: center; }
}
</style>

{{-- ═══════════════════════════════════════════════════════
     LANDING PAGE
═══════════════════════════════════════════════════════ --}}
<div id="page-landing">

    {{-- TOP BAR --}}
    <div class="lp-topbar">
        <div class="lp-topbar-left">
            <a href="#">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                Sinulssarian Honda | CV. Karunia Sejahtera Motor (KSM)
            </a>
        </div>
        <div class="lp-topbar-right">
            <a href="tel:0932557900">
                <svg viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                095-255-7900
            </a>
            <a href="#">
                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                Contact Us
            </a>
        </div>
    </div>

    {{-- NAVBAR --}}
    <nav class="lp-nav">
        <div class="lp-nav-inner">
            <a class="lp-logo" href="{{ route('landing') }}">
                <div class="lp-logo-mark">H</div>
                <span class="lp-logo-text">Simtor</span>
            </a>
            <div class="lp-nav-links">
                <a href="#fitur">Fitur</a>
                <a href="#cara-pakai">Cara Pakai</a>
                <a href="#">Tentang</a>
            </div>
            <div class="lp-nav-btns">
                <a href="{{ route('login') }}" class="btn btn-red btn-sm">Masuk</a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="lp-hero">
        <div class="lp-hero-bg"></div>
        <div class="lp-hero-content fade-up">
            <div class="lp-hero-eyebrow">Honda Jember — Dealer Resmi</div>
            <h1>Simulasi<br><span>Cicilan</span><br>Motor</h1>
            <p>Temukan cicilan yang tepat sesuai kemampuan finansial Anda. Sistem rekomendasi cerdas berbasis kondisi nyata Anda.</p>
            <div class="lp-hero-btns">
                <a href="{{ route('login') }}" class="btn btn-red btn-lg">Mulai Simulasi</a>
            </div>
            <div class="lp-hero-stats">
                <div class="lp-stat">
                    <div class="lp-stat-num">50+</div>
                    <div class="lp-stat-label">Model Motor</div>
                </div>
                <div class="lp-stat">
                    <div class="lp-stat-num">3</div>
                    <div class="lp-stat-label">Pilihan Tenor</div>
                </div>
                <div class="lp-stat">
                    <div class="lp-stat-num">1.200+</div>
                    <div class="lp-stat-label">Simulasi Dijalankan</div>
                </div>
                <div class="lp-stat">
                    <div class="lp-stat-num">98%</div>
                    <div class="lp-stat-label">Akurasi Rekomendasi</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FITUR --}}
    <div class="lp-features" id="fitur">
        <div class="lp-section-title">
            <h2>Kenapa Simtor?</h2>
            <p>Bukan sekadar kalkulator — Simtor bantu kamu beli motor dengan kepala dingin</p>
        </div>
        <div class="lp-features-grid simtor-features-grid">
            <div class="lp-feature-card simtor-card fade-up">
                <div class="lp-feature-icon simtor-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                </div>
                <div class="simtor-card-label">✦ AI-powered</div>
                <h3>Rekomendasi yang ngerti kamu</h3>
                <p>Bukan angka asal — sistem kami baca pendapatan, uang muka, dan kebutuhanmu, lalu kasih saran cicilan yang masuk akal.</p>
                <div class="simtor-card-footer">
                    <span>Coba sekarang →</span>
                </div>
            </div>
            <div class="lp-feature-card simtor-card fade-up delay-1">
                <div class="lp-feature-icon simtor-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 11H7v9h2v-9zm4-4h-2v13h2V7zm4-4h-2v17h2V3z"/></svg>
                </div>
                <div class="simtor-card-label">✦ Komparasi</div>
                <h3>Bandingkan tenor sekaligus</h3>
                <p>6, 12, atau 24 bulan? Simtor tampilkan semuanya side-by-side. Lihat mana yang bikin dompet paling lega.</p>
                <div class="simtor-card-footer">
                    <span>Lihat contoh →</span>
                </div>
            </div>
            <div class="lp-feature-card simtor-card fade-up delay-2">
                <div class="lp-feature-icon simtor-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                </div>
                <div class="simtor-card-label">✦ Privasi</div>
                <h3>Data kamu, milik kamu</h3>
                <p>Informasi finansialmu dienkripsi dan tidak dibagikan ke siapapun. Simulasi bisa dihapus kapan saja.</p>
                <div class="simtor-card-footer">
                    <span>Pelajari lebih lanjut →</span>
                </div>
            </div>
            <div class="lp-feature-card simtor-card fade-up delay-3">
                <div class="lp-feature-icon simtor-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
                <div class="simtor-card-label">✦ Riwayat</div>
                <h3>Jejak simulasi tersimpan</h3>
                <p>Pernah simulasi minggu lalu? Masih ada. Simtor simpan semua riwayatmu biar kamu bisa balik kapanpun.</p>
                <div class="simtor-card-footer">
                    <span>Mulai simpan →</span>
                </div>
            </div>
        </div>
    </div>

    {{-- CARA PAKAI --}}
    <div class="lp-how" id="cara-pakai">
        <div class="lp-section-title">
            <h2>Cara Pakai</h2>
            <p>3 langkah mudah untuk mendapatkan rekomendasi cicilan terbaik</p>
        </div>
        <div class="lp-steps">
            <div class="lp-step fade-up">
                <div class="lp-step-num">1</div>
                <h4>Masuk ke Akun</h4>
                <p>Masuk menggunakan akun yang telah disiapkan. Proses cepat, kurang dari 1 menit.</p>
            </div>
            <div class="lp-step fade-up delay-1">
                <div class="lp-step-num">2</div>
                <h4>Pilih Motor & Isi Data</h4>
                <p>Pilih model Honda yang Anda inginkan dan masukkan kondisi finansial Anda.</p>
            </div>
            <div class="lp-step fade-up delay-2">
                <div class="lp-step-num">3</div>
                <h4>Dapatkan Rekomendasi</h4>
                <p>Sistem akan langsung merekomendasikan tenor dan cicilan yang paling sesuai.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="lp-cta">
        <h2>Siap Punya Motor <span style="color:rgba(255,255,255,0.65)">Honda?</span></h2>
        <p>Mulai simulasi sekarang dan temukan cicilan yang pas untuk Anda</p>
        <a href="{{ route('login') }}" class="btn-cta">Mulai Simulasi Sekarang</a>
    </div>

    {{-- FOOTER --}}
    <div class="lp-footer">
        <div class="lp-footer-inner">
            <p>&copy; {{ date('Y') }} Simtor — Honda Jember. Semua hak dilindungi.</p>
            <div class="lp-footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kontak</a>
            </div>
        </div>
    </div>

</div>

@endsection