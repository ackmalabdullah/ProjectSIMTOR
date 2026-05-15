@extends('layouts.guest')

@section('title', 'Simtor — Honda Jember')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     LANDING PAGE
═══════════════════════════════════════════════════════ --}}
<div id="page-landing">

    {{-- NAVBAR --}}
    <nav class="lp-nav">
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
        <h2>Siap Punya Motor <span style="color:var(--red)">Honda?</span></h2>
        <p>Mulai simulasi sekarang dan temukan cicilan yang pas untuk Anda</p>
        <a href="{{ route('login') }}" class="btn btn-red btn-lg">Mulai Simulasi Sekarang</a>
    </div>

    {{-- FOOTER --}}
    <div class="lp-footer">
        <p>&copy; {{ date('Y') }} Simtor — Honda Jember. Semua hak dilindungi.</p>
        <div style="display:flex;gap:1.5rem">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kontak</a>
        </div>
    </div>

</div>

{{-- ── Dinamis: hover & entrance animation untuk section fitur ── --}}
<style>
.simtor-features-grid {
    perspective: 1000px;
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
}

.simtor-card {
    position: relative;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(.22,.68,0,1.2), box-shadow 0.3s ease;
    cursor: default;
}

.simtor-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(220,38,38,0.06) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.simtor-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}

.simtor-card:hover::before {
    opacity: 1;
}

.simtor-icon {
    transition: transform 0.4s cubic-bezier(.22,.68,0,1.4);
}

.simtor-card:hover .simtor-icon {
    transform: scale(1.18) rotate(-4deg);
}

.simtor-card-label {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.03em;
    color: var(--red);
    background: rgba(220,38,38,0.08);
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 0.6rem;
}

.simtor-card h3 {
    transition: color 0.2s ease;
}

.simtor-card:hover h3 {
    color: var(--red);
}

.simtor-card-footer {
    margin-top: 1rem;
    font-size: 13px;
    font-weight: 500;
    color: var(--red);
    opacity: 0;
    transform: translateY(6px);
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.simtor-card:hover .simtor-card-footer {
    opacity: 1;
    transform: translateY(0);
}
</style>

@endsection