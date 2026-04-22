@extends('layouts.guest')

@section('title', 'SimulasiMotor — Honda Jember')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     LANDING PAGE
═══════════════════════════════════════════════════════ --}}
<div id="page-landing">

    {{-- NAVBAR --}}
    <nav class="lp-nav">
        <a class="lp-logo" href="{{ route('landing') }}">
            <div class="lp-logo-mark">H</div>
            <span class="lp-logo-text">SimulasiMotor</span>
        </a>
        <div class="lp-nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#cara-pakai">Cara Pakai</a>
            <a href="#">Tentang</a>
        </div>
        <div class="lp-nav-btns">
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-red btn-sm">Daftar</a>
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
                <a href="{{ route('register') }}" class="btn btn-red btn-lg">Mulai Simulasi — Gratis</a>
                <a href="{{ route('login') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.3)">
                    Sudah punya akun? Masuk
                </a>
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
            <h2>Kenapa Pakai SimulasiMotor?</h2>
            <p>Platform terlengkap untuk merencanakan pembelian motor Honda Anda</p>
        </div>
        <div class="lp-features-grid">
            <div class="lp-feature-card fade-up">
                <div class="lp-feature-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                </div>
                <h3>Rekomendasi Cerdas</h3>
                <p>Sistem ML menganalisis pendapatan, uang muka, dan kebutuhan Anda untuk merekomendasikan cicilan terbaik.</p>
            </div>
            <div class="lp-feature-card fade-up delay-1">
                <div class="lp-feature-icon">
                    <svg viewBox="0 0 24 24"><path d="M9 11H7v9h2v-9zm4-4h-2v13h2V7zm4-4h-2v17h2V3z"/></svg>
                </div>
                <h3>Perbandingan Tenor</h3>
                <p>Bandingkan cicilan 6, 12, dan 24 bulan sekaligus. Lihat total bunga dan pilih yang paling menguntungkan.</p>
            </div>
            <div class="lp-feature-card fade-up delay-2">
                <div class="lp-feature-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                </div>
                <h3>Data Aman & Terenkripsi</h3>
                <p>Informasi finansial Anda tersimpan dengan aman. Hanya Anda yang bisa melihat histori simulasi milik Anda.</p>
            </div>
            <div class="lp-feature-card fade-up delay-3">
                <div class="lp-feature-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
                <h3>Histori Lengkap</h3>
                <p>Simpan dan bandingkan semua simulasi sebelumnya. Lacak perjalanan rencana pembelian motor Anda.</p>
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
                <h4>Daftar & Masuk</h4>
                <p>Buat akun gratis dengan email Anda. Proses cepat, kurang dari 1 menit.</p>
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
        <h2>Siap Punya Motor <span style="color:var(--red)">Honda?</span></h2>
        <p>Mulai simulasi sekarang dan temukan cicilan yang pas untuk Anda</p>
        <a href="{{ route('register') }}" class="btn btn-red btn-lg">Daftar Gratis Sekarang</a>
    </div>

    {{-- FOOTER --}}
    <div class="lp-footer">
        <p>&copy; {{ date('Y') }} SimulasiMotor — Honda Jember. Semua hak dilindungi.</p>
        <div style="display:flex;gap:1.5rem">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kontak</a>
        </div>
    </div>

</div>

@endsection